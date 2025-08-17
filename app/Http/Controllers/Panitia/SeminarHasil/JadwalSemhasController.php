<?php

namespace App\Http\Controllers\Panitia\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJadwalManualRequest;
use App\Models\Dosen;
use App\Models\JadwalSeminarHasil;
use App\Models\KuotaDosen;
use App\Models\Panitia;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\Tahap;
use App\Services\SemhasSchedulerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class JadwalSemhasController extends Controller
{
    public function index(): View
    {
        $prodiPanitia = Panitia::firstWhere('dosen_id', auth('dosen')->id())->prodi_id;
        $prodi = Prodi::findOrFail($prodiPanitia);

        // Ambil pasangan unik tahap dan periode dari jadwal sidang ujian akhir / semhas
        $pasangan = JadwalSeminarHasil::whereHas('proposal', function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi->id);
        })
            ->with(['proposal.tahapSemhas', 'proposal.periodeSemhas'])
            ->get()
            ->map(function ($item) {
                return [
                    "tahap_id" => $item->proposal->tahap_semhas_id,
                    "tahap" => $item->proposal->tahapSemhas->tahap,
                    "periode_id" => $item->proposal->periode_semhas_id,
                    "periode" => $item->proposal->periodeSemhas->tahun,
                ];
            })
            ->unique(function ($item) {
                return $item['tahap_id'] . "-" . $item["periode_id"];
            })
            ->sortBy(function ($item) {
                return $item['tahap_id'] . '-' . $item['periode_id'];
            })
            ->values();

        return view(
            'panitia.seminar-hasil.jadwal.index',
            compact('prodi', 'pasangan')
        );
    }

    public function create(): View
    {
        $prodiPanitia = Panitia::firstWhere('dosen_id', auth('dosen')->id())->prodi_id;
        $prodi = Prodi::findOrFail($prodiPanitia);

        $listPeriode = Periode::all();
        $listTahap = Tahap::all();
        $listDosen = Dosen::select(['id', 'nama'])->get();

        return view(
            'panitia.seminar-hasil.jadwal.create',
            compact('prodi', 'listPeriode', 'listTahap', 'listDosen')
        );
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'tahap_id' => 'required|exists:tahap,id',
            'periode_id' => 'required|exists:periode,id',
            'ruang' => 'required|array',
            'tanggal' => 'required|array',
            'sesi' => 'required|array',
        ]);

        // 2. Cek Prodi Panitia
        $idDosen = auth('dosen')->id();
        $prodiPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $tahapId = $request->integer("tahap_id");
        $periodeId = $request->integer("periode_id");

        // 3. Ambil proposal sesuai input
        $proposals = Proposal::whereHas('pendaftaranSemhas', function ($query) {
            $query->where('status_daftar_semhas_id', 1);
        })
            ->where('tahap_semhas_id', $request->tahap_id)
            ->where('periode_semhas_id', $request->periode_id)
            ->where('prodi_id', $prodiPanitia)
            ->get();

        // 4. Hitung jumlah proposal, ruang, tanggal, sesi
        $jumlahProposal = $proposals->count();
        $jumlahRuang = count($request->ruang);
        $jumlahTanggal = count($request->tanggal);
        $jumlahSesi = count($request->sesi);
        $totalSlot = $jumlahRuang * $jumlahTanggal * $jumlahSesi;

        if ($totalSlot <= $jumlahProposal) {
            return back()->withErrors(['error' => "Jumlah ruang, tanggal dan sesi tidak cukup. Pastikan perkalian jumlah ruang, tanggal dan sesi lebih dari $jumlahProposal"])->withInput();
        }

        // 5. Ambil kuota dosen
        $dosenKuota = Dosen::with(['kuotaDosen', 'bidangMinats'])->get()->keyBy('id')->map(function ($dosen) use ($prodiPanitia) {
            return [
                'kuota_penguji_sidang_TA_1' => $prodiPanitia == 1 ? $dosen->kuotaDosen->kuota_penguji_sidang_TA_1_D3 : $dosen->kuotaDosen->kuota_penguji_sidang_TA_1_D4,
                'kuota_penguji_sidang_TA_2' => $prodiPanitia == 1 ? $dosen->kuotaDosen->kuota_penguji_sidang_TA_2_D3 : $dosen->kuotaDosen->kuota_penguji_sidang_TA_2_D4,
                'bidang_minat_id' => $dosen->bidangMinats->pluck('id')->toArray(),
            ];
        })->toArray();

        // Hapus Jadwal Semhas yang lama jika ada
        $jadwalSemhasLama = JadwalSeminarHasil::whereHas('proposal', function ($query) use ($tahapId, $periodeId, $prodiPanitia) {
            $query->where('tahap_semhas_id', $tahapId)
                ->where('periode_semhas_id', $periodeId)
                ->where('prodi_id', $prodiPanitia);
        })->delete();

        // 6. Generate jadwal menggunakan SemhasSchedulerService
        $scheduler = new SemhasSchedulerService();

        $start = microtime(true);
        $jadwal = $scheduler->generate(
            $proposals,
            $request->ruang,
            $request->tanggal,
            $request->sesi, // $request->sesi harus berupa array sesi: [['waktu_mulai' => ..., 'waktu_selesai' => ...], ...]
            $dosenKuota
        );
        $end = microtime(true);
        $waktuRespon = $end - $start;
        Log::info("Waktu Respon Penjadwalan Sidang Ujian Akhir: " . $waktuRespon . " detik");

        // Urutkan jadwal berdasarkan tanggal dan waktu mulai (agar sesi 1 adalah waktu paling awal)
        usort($jadwal, function ($a, $b) {
            if ($a['tanggal'] === $b['tanggal']) {
                return strcmp($a['sesi']['waktu_mulai'], $b['sesi']['waktu_mulai']);
            }
            return strcmp($a['tanggal'], $b['tanggal']);
        });

        // Penomoran sesi: sesi sama untuk tanggal & waktu mulai yang sama, reset per tanggal
        $sesiMap = [];
        $sesiCounter = [];
        foreach ($jadwal as $item) {
            $tanggal = $item['tanggal'];
            $waktuKey = $item['sesi']['waktu_mulai'] . '|' . $item['sesi']['waktu_selesai'];
            $sesiKey = $tanggal . '|' . $waktuKey;
            if (!isset($sesiCounter[$tanggal])) {
                $sesiCounter[$tanggal] = 1;
            }
            if (!isset($sesiMap[$sesiKey])) {
                $sesiMap[$sesiKey] = $sesiCounter[$tanggal];
                $sesiCounter[$tanggal]++;
            }
        }

        // Simpan jadwal dengan nomor sesi
        foreach ($jadwal as $item) {
            $key = $item['tanggal'] . '|' . $item['sesi']['waktu_mulai'] . '|' . $item['sesi']['waktu_selesai'];
            $sesiNo = $sesiMap[$key];
            JadwalSeminarHasil::create([
                'proposal_id' => $item['proposal_id'],
                'ruang' => $item['ruang'],
                'tanggal' => $item['tanggal'],
                'sesi' => $sesiNo,
                'waktu_mulai' => $item['sesi']['waktu_mulai'],
                'waktu_selesai' => $item['sesi']['waktu_selesai'],
            ]);

            // Update penguji di tabel proposal
            $proposal = Proposal::find($item['proposal_id']);
            if ($proposal) {
                $proposal->penguji_sidang_ta_1_id = $item['penguji_sidang_TA_1_id'] ?? null;
                $proposal->penguji_sidang_ta_2_id = $item['penguji_sidang_TA_2_id'] ?? null;
                $proposal->save();
            }
        }

        return redirect()->route('panitia.jadwal-sidang-akhir.index')->with('success', 'Jadwal sidang ujian akhir berhasil digenerate!');
    }

    public function detail($tahap_id, $periode_id): View
    {
        $idDosen = auth('dosen')->id();
        $prodiPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $jadwalSemhas = JadwalSeminarHasil::whereHas('proposal', function ($q) use ($tahap_id, $periode_id, $prodiPanitia) {
            $q->where('tahap_semhas_id', $tahap_id)
                ->where('periode_semhas_id', $periode_id)
                ->where('prodi_id', $prodiPanitia);
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPembimbing1', 'proposal.dosenPembimbing2', 'proposal.dosenPengujiSidangTA1', 'proposal.dosenPengujiSidangTA2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $tahap = Tahap::findOrFail($tahap_id);
        $periode = Periode::findOrFail($periode_id);
        $prodi = Prodi::findOrFail($prodiPanitia);

        return view(
            "panitia.seminar-hasil.jadwal.detail",
            compact('jadwalSemhas', 'tahap', 'periode', 'prodi')
        );
    }

    public function showCreateManualPage(): View
    {
        $listPeriode = Periode::all();
        $listTahap = Tahap::all();
        $prodiIdPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        return view(
            'panitia.seminar-hasil.jadwal.create-manual',
            compact('listPeriode', 'listTahap', 'prodiIdPanitia')
        );
    }

    public function getCalonPesertaSemhas(Request $request): JsonResponse
    {
        // Validasi Input
        $validator = Validator::make(
            $request->all(),
            [
                "periode_id" => "exists:periode,id",
                "tahap_id" => "exists:tahap,id"
            ],
            [
                "periode_id.exists" => "Periode tidak valid",
                "tahap_id.exists" => "Tahap tidak valid",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first()
            ]);
        }

        // Ambil data yang sudah divalidasi
        $validated = $validator->validated();

        // Ambil data proposal calon peserta sidang ujian akhir dengan periode, tahap, dan prodi yang sesuai
        $periode = $validated["periode_id"];
        $tahap = $validated["tahap_id"];
        $prodiPanitia = Panitia::firstWhere('dosen_id', auth('dosen')->id())->prodi_id;

        $listDosenPenguji1 = Dosen::whereHas('kuotaDosen', function ($query) use ($prodiPanitia) {
            if ($prodiPanitia == 1) {
                $query->where("kuota_penguji_sidang_TA_1_D3", ">", 0);
            } else if ($prodiPanitia == 2) {
                $query->where("kuota_penguji_sidang_TA_1_D4", ">", 0);
            }
        })->get();

        $listDosenPenguji2 = Dosen::whereHas('kuotaDosen', function ($query) use ($prodiPanitia) {
            if ($prodiPanitia == 1) {
                $query->where("kuota_penguji_sidang_TA_2_D3", ">", 0);
            } else if ($prodiPanitia == 2) {
                $query->where("kuota_penguji_sidang_TA_2_D4", ">", 0);
            }
        })->get();

        $listProposal = Proposal::whereHas('pendaftaranSemhas', function ($query) {
            $query->where("status_daftar_semhas_id", 1);
        })
            ->where("periode_semhas_id", $periode)
            ->where("tahap_semhas_id", $tahap)
            ->where("prodi_id", $prodiPanitia)
            ->with(
                [
                    'proposalMahasiswas' => ['mahasiswa'],
                    'dosenPembimbing1',
                    'dosenPembimbing2',
                    'dosenPengujiSidangTA1',
                    'dosenPengujiSidangTA2'
                ]
            )
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'listProposal' => $listProposal,
                'prodi' => $prodiPanitia,
                'listDosenPenguji1' => $listDosenPenguji1,
                'listDosenPenguji2' => $listDosenPenguji2
            ]
        ]);
    }

    public function storeManual(StoreJadwalManualRequest $request)
    {
        $listProposalId = $request->proposal_id;
        $listRuang = $request->ruang;
        $listTanggal = $request->tanggal;
        $listSesi = $request->sesi;
        $listWaktuMulai = $request->waktu_mulai;
        $listWaktuSelesai = $request->waktu_selesai;
        $listDosenPenguji1Id = $request->dosen_penguji_1_id;
        $listDosenPenguji2Id = $request->dosen_penguji_2_id;

        $prodiPanitia = Panitia::firstWhere('dosen_id', auth("dosen")->id())->prodi_id;
        $rowCount = count($listProposalId);

        $proposal = Proposal::findOrFail($listProposalId[0]);
        $periodeId = $proposal->periode_semhas_id;
        $tahapId = $proposal->tahap_semhas_id;

        // Menghapus Jadwal Semhas Lama jika ada
        $jadwalSemhasLama = JadwalSeminarHasil::whereHas('proposal', function ($query) use ($periodeId, $tahapId, $prodiPanitia) {
            $query->where('periode_semhas_id', $periodeId)
                ->where('tahap_semhas_id', $tahapId)
                ->where('prodi_id', $prodiPanitia);
        })->delete();

        for ($i = 0; $i < $rowCount; $i++) {
            JadwalSeminarHasil::create([
                'proposal_id' => $listProposalId[$i],
                'ruang' => $listRuang[$i],
                'tanggal' => $listTanggal[$i],
                'sesi' => $listSesi[$i],
                'waktu_mulai' => $listWaktuMulai[$i],
                'waktu_selesai' => $listWaktuSelesai[$i]
            ]);

            $proposal = Proposal::findOrFail($listProposalId[$i]);
            $proposal->penguji_sidang_ta_1_id = $listDosenPenguji1Id[$i];
            $proposal->penguji_sidang_ta_2_id = $listDosenPenguji2Id[$i];
            $proposal->save();

            // 
            // Mengurangi kuota dosen penguji sidang ta 1
            // 
            $kuotaDosenPenguji1 = KuotaDosen::firstWhere("dosen_id", $listDosenPenguji1Id[$i]);

            if ($prodiPanitia == 1)
                $kuotaDosenPenguji1->kuota_penguji_sidang_TA_1_D3--;
            else if ($prodiPanitia == 2)
                $kuotaDosenPenguji1->kuota_penguji_sidang_TA_1_D4--;

            $kuotaDosenPenguji1->save();

            // 
            // Mengurangi kuota dosen penguji sempro 2
            // 
            $kuotaDosenPenguji2 = KuotaDosen::firstWhere("dosen_id", $listDosenPenguji2Id[$i]);

            if ($prodiPanitia == 1)
                $kuotaDosenPenguji2->kuota_penguji_sidang_TA_2_D3--;
            else if ($prodiPanitia == 2)
                $kuotaDosenPenguji2->kuota_penguji_sidang_TA_2_D4--;

            $kuotaDosenPenguji2->save();
        }

        return redirect()
            ->route('panitia.jadwal-sidang-akhir.index')
            ->with('success', 'Jadwal Sidang Ujian Akhir berhasil dibuat!');
    }
}
