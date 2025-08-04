<?php

namespace App\Http\Controllers\Panitia\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalSeminarHasil;
use App\Models\KuotaDosen;
use App\Models\Panitia;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\Tahap;
use App\Services\SemhasSchedulerService;
use Illuminate\Http\Request;
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
            ->with(['proposal.tahap', 'proposal.periode'])
            ->get()
            ->map(function($item){
                return [
                    "tahap_id" => $item->proposal->tahap_id,
                    "tahap" => $item->proposal->tahap->tahap,
                    "periode_id" => $item->proposal->periode_id,
                    "periode" => $item->proposal->periode->tahun,
                ];
            })
            ->unique(function($item){
                return $item['tahap_id'] . "-" . $item["periode_id"];
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
        $proposals = Proposal::where('tahap_id', $request->tahap_id)
            ->where('periode_id', $request->periode_id)
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
        $dosenKuota = KuotaDosen::all()->keyBy('dosen_id')->map(function ($item) use ($prodiPanitia) {
            return [
                'kuota_penguji_sidang_TA_1' => $prodiPanitia == 1 ? $item->kuota_penguji_sidang_TA_1_D3 : $item->kuota_penguji_sidang_TA_1_D4,
                'kuota_penguji_sidang_TA_2' => $prodiPanitia == 1 ? $item->kuota_penguji_sidang_TA_2_D3 : $item->kuota_penguji_sidang_TA_2_D4
            ];
        })->toArray();

        // Hapus Jadwal Sempro yang lama jika ada
        $jadwalSemhasLama = JadwalSeminarHasil::whereHas('proposal', function($query) use ($tahapId, $periodeId){
            $query->where('tahap_id', $tahapId)
                ->where('periode_id', $periodeId);
        })->get();

        if($jadwalSemhasLama->isNotEmpty()){
            $jadwalSemhasLama->each(function ($jadwal) {
                $jadwal->delete();
            });
        }

        // 6. Generate jadwal menggunakan SemhasSchedulerService
        $scheduler = new SemhasSchedulerService();

        $jadwal = $scheduler->generate(
            $proposals,
            $request->ruang,
            $request->tanggal,
            $request->sesi, // $request->sesi harus berupa array sesi: [['waktu_mulai' => ..., 'waktu_selesai' => ...], ...]
            $dosenKuota
        );

        // Simpan hasil jadwal ke database
        // Penomoran sesi otomatis dan urut berdasarkan tanggal, waktu_mulai, waktu_selesai
        $sesiMap = [];
        $sesiCounter = 1;
        // Kumpulkan semua kombinasi sesi unik
        foreach ($jadwal as $item) {
            $key = $item['tanggal'] . '|' . $item['sesi']['waktu_mulai'] . '|' . $item['sesi']['waktu_selesai'];
            if (!isset($sesiMap[$key])) {
                $sesiMap[$key] = null;
            }
        }
        // Urutkan berdasarkan tanggal dan waktu_mulai
        ksort($sesiMap);
        foreach (array_keys($sesiMap) as $key) {
            $sesiMap[$key] = $sesiCounter++;
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
            $q->where('tahap_id', $tahap_id)
                ->where('periode_id', $periode_id)
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
}
