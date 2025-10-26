<?php

namespace App\Http\Controllers\Panitia\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalSeminarProposal;
use App\Models\KuotaDosen;
use App\Models\Panitia;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\Tahap;
use App\Services\SemproSchedulerService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class JadwalSemproController extends Controller
{
    public function index(?Periode $periode = null): View
    {
        $idDosen = auth('dosen')->id();
        $prodiPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $listPeriode = Periode::all();
        $periodeAktif = $listPeriode->firstWhere('aktif_sempro', true);
        $periodeTerpilih = $periode ?? $periodeAktif;

        // Hitung Jumlah Peserta Seminar Proposal per tahap
        $counts = JadwalSeminarProposal::join("proposal", "jadwal_seminar_proposal.proposal_id", "=", "proposal.id")
            ->where('proposal.prodi_id', $prodiPanitia)
            ->selectRaw('proposal.tahap_id, proposal.periode_id, count(*) as jumlah')
            ->groupBy('proposal.tahap_id', 'proposal.periode_id')
            ->get()
            ->mapWithKeys(function ($row) {
                return [$row->tahap_id . '-' . $row->periode_id => (int) $row->jumlah];
            })
            ->toArray();
        
        // Ambil pasangan unik tahap dan periode dari jadwal sempro
        $pasangan = JadwalSeminarProposal::whereHas('proposal', function ($query) use ($prodiPanitia, $periodeTerpilih) {
            $query->where('prodi_id', $prodiPanitia)
                ->where("periode_id", $periodeTerpilih->id);
        })
            ->with(['proposal.tahap', 'proposal.periode'])
            ->get()
            ->map(function ($item) use ($counts) {
                return [
                    'tahap_id' => $item->proposal->tahap_id,
                    'periode_id' => $item->proposal->periode_id,
                    'tahap' => $item->proposal->tahap,
                    'periode' => $item->proposal->periode,
                    'jumlah_peserta' => $counts[$item->proposal->tahap_id . '-' . $item->proposal->periode_id] ?? 0,
                ];
            })
            ->unique(function ($item) {
                return $item['tahap_id'] . '-' . $item['periode_id'];
            })
            ->sortByDesc(function ($item) {
                return $item['tahap_id'] . '-' . $item['periode_id'];
            })
            ->values();

        $prodi = Prodi::findOrFail($prodiPanitia);

        return view(
            'panitia.seminar-proposal.jadwal.index', compact
            ('pasangan', 'prodi', 'listPeriode', 'periodeTerpilih')
        );
    }

    public function create()
    {
        $periodes = Periode::all();
        $tahaps = Tahap::all();
        $dosens = Dosen::select(['id', 'nama'])->get(); // Ambil dosen untuk opsi
        $prodiPanitia = Panitia::firstWhere('dosen_id', auth('dosen')->id())->prodi_id;
        $prodi = Prodi::findOrFail($prodiPanitia);

        return view('panitia.seminar-proposal.jadwal.create', compact('periodes', 'tahaps', 'dosens', 'prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahap_id' => 'required|exists:tahap,id',
            'periode_id' => 'required|exists:periode,id',
            'ruang' => 'required|array',
            'tanggal' => 'required|array',
            'jumlah_sesi' => 'required|integer|min:1',
            "waktu_mulai" => 'required|date_format:H:i',
            "durasi_seminar" => "required|integer|min:1",
            "jeda_antar_seminar" => "required|integer|min:1"
        ]);

        $jumlahSesi = $request->integer("jumlah_sesi");
        $durasiSeminar = $request->integer("durasi_seminar");
        $jedaAntarSeminar = $request->integer("jeda_antar_seminar");

        $idDosen = auth('dosen')->id();
        $prodiPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $proposals = Proposal::whereHas('pendaftaranSempro', function ($query) {
            $query->where('status_daftar_sempro_id', 1);
        })
            ->where('tahap_id', $request->tahap_id)
            ->where('periode_id', $request->periode_id)
            ->where('prodi_id', $prodiPanitia)
            ->get()
            ->toArray();

        if (count($proposals) == 0) {
            return redirect()
                ->route('jadwal-sempro.index')
                ->withErrors(['proposals' => 'Belum ada Pendaftaran yang dikonfirmasi!']);
        }

        $ruangs = $request->ruang;
        $tanggals = $request->tanggal;
        $sesis = [];

        for($i = 1; $i <= $jumlahSesi; $i++){
            $waktuMulai = Carbon::createFromFormat('H:i', $request->waktu_mulai)
                    ->addMinutes(($i - 1) * ($durasiSeminar + $jedaAntarSeminar))
                    ->format('H:i');

            $sesis[] = [
                "waktu_mulai" => $waktuMulai,
                "waktu_selesai" => Carbon::createFromFormat('H:i', $waktuMulai)
                    ->addMinutes($durasiSeminar)
                    ->format('H:i')
            ];
        }

        $tahapId = $request->integer("tahap_id");
        $periodeId = $request->integer("periode_id");

        $jumlahProposal = count($proposals);
        $jumlahRuang = count($ruangs);
        $jumlahTanggal = count($tanggals);
        $jumlahSesi = count($sesis);
        $totalSlot = $jumlahRuang * $jumlahTanggal * $jumlahSesi;
        if ($totalSlot <= $jumlahProposal) {
            return back()->withErrors(['error' => "Jumlah ruang, tanggal dan sesi tidak cukup. Pastikan perkalian jumlah ruang, tanggal dan sesi lebih dari $jumlahProposal"])->withInput();
        }

        $dosenKuota = KuotaDosen::whereHas('dosen', function ($query) {
            $query->whereNull('deleted_at');
        })->get()->keyBy('dosen_id')->map(function ($item) use ($prodiPanitia) {
            return [
                'kuota_penguji_sempro_1' => $prodiPanitia == 1 ? $item->kuota_penguji_sempro_1_D3 : $item->kuota_penguji_sempro_1_D4,
                'kuota_penguji_sempro_2' => $prodiPanitia == 1 ? $item->kuota_penguji_sempro_2_D3 : $item->kuota_penguji_sempro_2_D4
            ];
        })->toArray();

        // Ambil input waktu berhalangan dosen jika ada
        $waktuBerhalangan = [];
        if ($request->has('waktu_berhalangan_dosen') && $request->waktu_berhalangan_dosen) {
            $waktuBerhalangan = $request->input('waktu_berhalangan', []);
        }

        // Hapus Jadwal Sempro yang lama jika ada
        $jadwalSemproLama = JadwalSeminarProposal::whereHas('proposal', function ($query) use ($tahapId, $periodeId, $prodiPanitia) {
            $query->where('tahap_id', $tahapId)
                ->where('periode_id', $periodeId)
                ->where('prodi_id', $prodiPanitia);
        })->delete();

        $scheduler = new SemproSchedulerService();
        $start = microtime(true);           // waktu mulai penjadwalan
        $jadwal = $scheduler->generate($proposals, $ruangs, $tanggals, $sesis, $dosenKuota, $waktuBerhalangan);
        $end = microtime(true);             // waktu selesai penjadwalan
        $waktuRespon = $end - $start;

        Log::info("Waktu Respon Penjadwalan Sempro: " . $waktuRespon . " detik");

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

        foreach ($jadwal as $item) {
            $key = $item['tanggal'] . '|' . $item['sesi']['waktu_mulai'] . '|' . $item['sesi']['waktu_selesai'];
            $waktuKey = $item['sesi']['waktu_mulai'] . '|' . $item['sesi']['waktu_selesai'];
            $sesiKey = $item['tanggal'] . '|' . $waktuKey;
            JadwalSeminarProposal::create([
                'proposal_id' => $item['proposal_id'],
                'ruang' => $item['ruang'],
                'tanggal' => $item['tanggal'],
                'waktu_mulai' => $item['sesi']['waktu_mulai'],
                'waktu_selesai' => $item['sesi']['waktu_selesai'],
                'sesi' => $sesiMap[$sesiKey]
            ]);

            $proposal = Proposal::find($item['proposal_id']);
            $proposal->dosenPengujiSempro1()->associate($item['penguji_1']);
            $proposal->dosenPengujiSempro2()->associate($item['penguji_2']);
            $proposal->save();

            // 
            // Mengurangi kuota dosen penguji sempro 1
            // 
            $kuotaDosenPenguji1 = KuotaDosen::firstWhere("dosen_id", $item['penguji_1']);

            if ($prodiPanitia == 1)
                $kuotaDosenPenguji1->kuota_penguji_sempro_1_D3--;
            else if ($prodiPanitia == 2)
                $kuotaDosenPenguji1->kuota_penguji_sempro_1_D4--;

            $kuotaDosenPenguji1->save();

            // 
            // Mengurangi kuota dosen penguji sempro 2
            // 
            $kuotaDosenPenguji2 = KuotaDosen::firstWhere("dosen_id", $item['penguji_2']);

            if ($prodiPanitia == 1)
                $kuotaDosenPenguji2->kuota_penguji_sempro_2_D3--;
            else if ($prodiPanitia == 2)
                $kuotaDosenPenguji2->kuota_penguji_sempro_2_D4--;

            $kuotaDosenPenguji2->save();
        }

        return redirect()
            ->route('jadwal-sempro.index')
            ->with('success', 'Jadwal seminar proposal berhasil digenerate!');
    }

    public function detail($tahap_id, $periode_id)
    {
        $idDosen = auth('dosen')->id();
        $prodiPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahap_id, $periode_id, $prodiPanitia) {
            $q->where('tahap_id', $tahap_id)
                ->where('periode_id', $periode_id)
                ->where('prodi_id', $prodiPanitia);
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPembimbing1', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $tahap = Tahap::findOrFail($tahap_id);
        $periode = Periode::findOrFail($periode_id);
        $prodi = Prodi::findOrFail($prodiPanitia);
        return view('panitia.seminar-proposal.jadwal.detail', compact('jadwalSempro', 'tahap', 'periode', 'prodi'));
    }

    public function showCreateManualPage(): View
    {
        $listPeriode = Periode::all();
        $listTahap = Tahap::all();
        $prodiIdPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        return view(
            'panitia.seminar-proposal.jadwal.create-manual',
            compact('listPeriode', 'listTahap', 'prodiIdPanitia')
        );
    }

    public function getCalonPesertaSempro(Request $request): JsonResponse
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

        // Ambil data proposal calon peserta sempro dengan periode, tahap, dan prodi yang sesuai
        $periode = $validated["periode_id"];
        $tahap = $validated["tahap_id"];
        $prodiPanitia = Panitia::firstWhere('dosen_id', auth('dosen')->id())->prodi_id;

        $listDosenPenguji1 = Dosen::whereHas('kuotaDosen', function ($query) use ($prodiPanitia) {
            if ($prodiPanitia == 1) {
                $query->where("kuota_penguji_sempro_1_D3", ">", 0);
            } else if ($prodiPanitia == 2) {
                $query->where("kuota_penguji_sempro_1_D4", ">", 0);
            }
        })->get();

        $listDosenPenguji2 = Dosen::whereHas('kuotaDosen', function ($query) use ($prodiPanitia) {
            if ($prodiPanitia == 1) {
                $query->where("kuota_penguji_sempro_2_D3", ">", 0);
            } else if ($prodiPanitia == 2) {
                $query->where("kuota_penguji_sempro_2_D4", ">", 0);
            }
        })->get();

        $listProposal = Proposal::whereHas('pendaftaranSempro', function ($query) {
            $query->where("status_daftar_sempro_id", 1);
        })
            ->where("periode_id", $periode)
            ->where("tahap_id", $tahap)
            ->where("prodi_id", $prodiPanitia)
            ->with(['proposalMahasiswas' => ['mahasiswa', 'dosen']])
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

    public function storeManual(Request $request)
    {
        $rules = [
            // Validasi input utama
            'proposal_id' => 'required|array',
            'ruang' => 'required|array',
            'tanggal' => 'required|array',
            'sesi' => 'required|array',
            'waktu_mulai' => 'required|array',
            'waktu_selesai' => 'required|array',
            'dosen_penguji_1_id' => 'required|array',
            'dosen_penguji_2_id' => 'required|array',

            // Validasi setiap elemen di dalam array menggunakan '*'
            'proposal_id.*' => 'required|integer|exists:proposal,id',
            'ruang.*' => 'required|string|max:100',
            'tanggal.*' => 'required|date',
            'sesi.*' => 'required|integer|min:1',
            'waktu_mulai.*' => 'required|date_format:H:i',
            'waktu_selesai.*' => 'required|date_format:H:i|after:waktu_mulai.*',
            'dosen_penguji_1_id.*' => 'required|integer|exists:dosen,id',
            'dosen_penguji_2_id.*' => 'required|integer|exists:dosen,id',
        ];

        $messages = [
            'waktu_selesai.*.after' => 'Waktu selesai harus setelah waktu mulai pada baris yang sama.',
            'tanggal.*.date_format' => 'Format tanggal pada salah satu baris harus DD/MM/YYYY.',
        ];

        $request->validate($rules, $messages);

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
        $periodeId = $proposal->periode_id;
        $tahapId = $proposal->tahap_id;

        // Menghapus Jadwal Sempro Lama jika ada
        $jadwalSemhasLama = JadwalSeminarProposal::whereHas('proposal', function ($query) use ($periodeId, $tahapId, $prodiPanitia) {
            $query->where('periode_id', $periodeId)
                ->where('tahap_id', $tahapId)
                ->where('prodi_id', $prodiPanitia);
        })->delete();

        for ($i = 0; $i < $rowCount; $i++) {
            JadwalSeminarProposal::create([
                'proposal_id' => $listProposalId[$i],
                'ruang' => $listRuang[$i],
                'tanggal' => $listTanggal[$i],
                'sesi' => $listSesi[$i],
                'waktu_mulai' => $listWaktuMulai[$i],
                'waktu_selesai' => $listWaktuSelesai[$i]
            ]);

            $proposal = Proposal::findOrFail($listProposalId[$i]);
            $proposal->penguji_sempro_1_id = $listDosenPenguji1Id[$i];
            $proposal->penguji_sempro_2_id = $listDosenPenguji2Id[$i];
            $proposal->save();

            // 
            // Mengurangi kuota dosen penguji sempro 1
            // 
            $kuotaDosenPenguji1 = KuotaDosen::firstWhere("dosen_id", $listDosenPenguji1Id[$i]);

            if ($prodiPanitia == 1)
                $kuotaDosenPenguji1->kuota_penguji_sempro_1_D3--;
            else if ($prodiPanitia == 2)
                $kuotaDosenPenguji1->kuota_penguji_sempro_1_D4--;

            $kuotaDosenPenguji1->save();

            // 
            // Mengurangi kuota dosen penguji sempro 2
            // 
            $kuotaDosenPenguji2 = KuotaDosen::firstWhere("dosen_id", $listDosenPenguji2Id[$i]);

            if ($prodiPanitia == 1)
                $kuotaDosenPenguji2->kuota_penguji_sempro_2_D3--;
            else if ($prodiPanitia == 2)
                $kuotaDosenPenguji2->kuota_penguji_sempro_2_D4--;

            $kuotaDosenPenguji2->save();
        }

        return redirect()
            ->route('jadwal-sempro.index')
            ->with('success', 'Jadwal Seminar Proposal berhasil dibuat!');
    }

    public function edit(Periode $periode, Tahap $tahap): View
    {
        $idDosen = auth('dosen')->id();
        $prodiIdPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahap, $periode, $prodiIdPanitia) {
            $q->where('tahap_id', $tahap->id)
                ->where('periode_id', $periode->id)
                ->where('prodi_id', $prodiIdPanitia);
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPembimbing1', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $listDosenPenguji1 = Dosen::whereHas('kuotaDosen', function ($query) use ($prodiIdPanitia) {
            if ($prodiIdPanitia == 1) {
                $query->where("kuota_penguji_sempro_1_D3", ">", 0);
            } else if ($prodiIdPanitia == 2) {
                $query->where("kuota_penguji_sempro_1_D4", ">", 0);
            }
        })->get();

        $listDosenPenguji2 = Dosen::whereHas('kuotaDosen', function ($query) use ($prodiIdPanitia) {
            if ($prodiIdPanitia == 1) {
                $query->where("kuota_penguji_sempro_2_D3", ">", 0);
            } else if ($prodiIdPanitia == 2) {
                $query->where("kuota_penguji_sempro_2_D4", ">", 0);
            }
        })->get();

        $listSesi = $jadwalSempro
            ->pluck('sesi')
            ->unique()
            ->sort()
            ->values()
            ->all();

        return view(
            'panitia.seminar-proposal.jadwal.edit',
            compact([
                'periode',
                'tahap',
                'prodiIdPanitia',
                'jadwalSempro',
                'listDosenPenguji1',
                'listDosenPenguji2',
                'listSesi'
            ])
        );
    }

    public function updateDosenPenguji1(Request $request): JsonResponse
    {
        $request->validate([
            'dosen_penguji_1_id' => "required|exists:dosen,id",
            'jadwal_id' => "required|exists:jadwal_seminar_proposal,id"
        ]);

        $dosenTerpilih = Dosen::find($request->dosen_penguji_1_id);
        $jadwalSemproDospeng1 = JadwalSeminarProposal::with('proposal')->find($request->jadwal_id);
        $tanggal = $jadwalSemproDospeng1->tanggal;
        $sesi = $jadwalSemproDospeng1->sesi;

        $proposalList = Proposal::where('periode_id', $jadwalSemproDospeng1->proposal->periode_id)
            ->where('tahap_id', $jadwalSemproDospeng1->proposal->tahap_id)
            ->whereHas('pendaftaranSempro', function ($q) {
                $q->where('status_daftar_sempro_id', 1);
            })
            ->whereHas('jadwalSeminarProposal', function ($q) use ($tanggal, $sesi) {
                $q->where('tanggal', $tanggal)->where('sesi', $sesi);
            })
            ->get();

        $pengujiNotAvailable = array_merge(
            $proposalList->pluck('penguji_sempro_1_id')->toArray(),
            $proposalList->pluck('penguji_sempro_2_id')->toArray()
        );

        if (in_array($dosenTerpilih->id, $pengujiNotAvailable)) {
            // Jika dosen yang dipilih ada didaftar dosen yg tidak tersedia di tanggal & sesi sempro terpilih

            $tanggalFormatted = Carbon::parse($tanggal)->format('d-m-Y');

            return response()->json([
                "success" => false,
                "message" => "$dosenTerpilih->nama tidak tersedia di tanggal $tanggalFormatted, sesi $sesi",
                "errors" => [
                    "dosen_tidak_tersedia" => "Dosen yang dipilih tidak tersedia di tanggal $tanggal, sesi $sesi"
                ],
                "data" => [
                    "dosen" => [
                        "id" => $dosenTerpilih->id,
                        "nama" => $dosenTerpilih->nama
                    ]
                ]
            ], 422);
        }

        try {
            $proposal = $jadwalSemproDospeng1->proposal;
            $proposal->penguji_sempro_1_id = $dosenTerpilih->id;
            $proposal->save();
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan saat mengubah Dosen Penguji",
                "errors" => [
                    "update_error" => "Terjadi kesalahan saat mengubah Dosen Penguji"
                ],
                "data" => [
                    "dosen" => [
                        "id" => $dosenTerpilih->id,
                        "nama" => $dosenTerpilih->nama
                    ]
                ]
            ], 500);
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengubah Dosen Penguji Seminar Proposal 1"
        ]);
    }

    public function updateDosenPenguji2(Request $request): JsonResponse
    {
        $request->validate([
            'dosen_penguji_2_id' => "required|exists:dosen,id",
            'jadwal_id' => "required|exists:jadwal_seminar_proposal,id"
        ]);

        $dosenTerpilih = Dosen::find($request->dosen_penguji_2_id);
        $jadwalSemproDospeng2 = JadwalSeminarProposal::with('proposal')->find($request->jadwal_id);
        $tanggal = $jadwalSemproDospeng2->tanggal;
        $sesi = $jadwalSemproDospeng2->sesi;

        $proposalList = Proposal::where('periode_id', $jadwalSemproDospeng2->proposal->periode_id)
            ->where('tahap_id', $jadwalSemproDospeng2->proposal->tahap_id)
            ->whereHas('pendaftaranSempro', function ($q) {
                $q->where('status_daftar_sempro_id', 1);
            })
            ->whereHas('jadwalSeminarProposal', function ($q) use ($tanggal, $sesi) {
                $q->where('tanggal', $tanggal)->where('sesi', $sesi);
            })
            ->get();

        $pengujiNotAvailable = array_merge(
            $proposalList->pluck('penguji_sempro_1_id')->toArray(),
            $proposalList->pluck('penguji_sempro_2_id')->toArray()
        );

        if (in_array($dosenTerpilih->id, $pengujiNotAvailable)) {
            // Jika dosen yang dipilih ada didaftar dosen yg tidak tersedia di tanggal & sesi sempro terpilih

            $tanggalFormatted = Carbon::parse($tanggal)->format('d-m-Y');

            return response()->json([
                "success" => false,
                "message" => "$dosenTerpilih->nama tidak tersedia di tanggal $tanggalFormatted, sesi $sesi",
                "errors" => [
                    "dosen_tidak_tersedia" => "Dosen yang dipilih tidak tersedia di tanggal $tanggal, sesi $sesi"
                ],
                "data" => [
                    "dosen" => [
                        "id" => $dosenTerpilih->id,
                        "nama" => $dosenTerpilih->nama
                    ]
                ]
            ], 422);
        }

        try {
            $proposal = $jadwalSemproDospeng2->proposal;
            $proposal->penguji_sempro_2_id = $dosenTerpilih->id;
            $proposal->save();
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan saat mengubah Dosen Penguji",
                "errors" => [
                    "update_error" => "Terjadi kesalahan saat mengubah Dosen Penguji"
                ],
            ], 500);
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengubah Dosen Penguji Seminar Proposal 2"
        ]);
    }

    public function cekJumlahProposal(Request $request): JsonResponse
    {
        $request->validate([
            'tahap_id' => 'required|exists:tahap,id',
            'periode_id' => 'required|exists:periode,id',
        ]);

        $idDosen = auth('dosen')->id();
        $prodiPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $jumlahProposal = Proposal::whereHas('pendaftaranSempro', function ($query) {
            $query->where('status_daftar_sempro_id', 1);
        })
            ->where('tahap_id', $request->tahap_id)
            ->where('periode_id', $request->periode_id)
            ->where('prodi_id', $prodiPanitia)
            ->count();

        return response()->json([
            'status' => true,
            'data' => [
                'jumlah_proposal' => $jumlahProposal
            ]
        ]);
    }
}
