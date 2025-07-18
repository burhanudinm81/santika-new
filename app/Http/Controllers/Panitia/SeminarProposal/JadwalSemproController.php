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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JadwalSemproController extends Controller
{
    public function index()
    {
        $idDosen = auth('dosen')->id();
        $prodiPanita = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        // Ambil pasangan unik tahap dan periode dari jadwal sempro
        $pasangan = JadwalSeminarProposal::whereHas('proposal', function ($query) use ($prodiPanita) {
                $query->where('prodi_id', $prodiPanita);
            })
            ->with(['proposal.tahap', 'proposal.periode'])
            ->get()
            ->map(function ($item) {
                return [
                    'tahap_id' => $item->proposal->tahap_id,
                    'periode_id' => $item->proposal->periode_id,
                    'tahap' => $item->proposal->tahap,
                    'periode' => $item->proposal->periode,
                ];
            })
            ->unique(function ($item) {
                return $item['tahap_id'] . '-' . $item['periode_id'];
            })
            ->values();

        $prodi = Prodi::findOrFail($prodiPanita);

        return view('panitia.seminar-proposal.jadwal.index', compact('pasangan', 'prodi'));
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
            'sesi' => 'required|array',
        ]);

        $idDosen = auth('dosen')->id();
        $prodiPanitia = Panitia::firstWhere('dosen_id', $idDosen)->prodi_id;

        $proposals = Proposal::where('tahap_id', $request->tahap_id)
            ->where('periode_id', $request->periode_id)
            ->where('prodi_id', $prodiPanitia)
            ->get()
            ->toArray();
        $ruangs = $request->ruang;
        $tanggals = $request->tanggal;
        $sesis = $request->sesi;

        $jumlahProposal = count($proposals);
        $jumlahRuang = count($ruangs);
        $jumlahTanggal = count($tanggals);
        $jumlahSesi = count($sesis);
        $totalSlot = $jumlahRuang * $jumlahTanggal * $jumlahSesi;
        if ($totalSlot <= $jumlahProposal) {
            return back()->withErrors(['error' => "Jumlah ruang, tanggal dan sesi tidak cukup. Pastikan perkalian jumlah ruang, tanggal dan sesi lebih dari $jumlahProposal"])->withInput();
        }

        $dosenKuota = KuotaDosen::all()->keyBy('dosen_id')->map(function ($item) use ($prodiPanitia) {
            return [
                'kuota_penguji_sempro_1' => $prodiPanitia == 1 ? $item->kuota_penguji_sempro_1_D3 : $item->kuota_penguji_sempro_1_D4,
                'kuota_penguji_sempro_2' => $prodiPanitia == 1 ? $item->kuota_penguji_sempro_2_D3 : $item->kuota_penguji_sempro_2_D4
            ];
        })->toArray();

        // Log::info('Proposal: ' . json_encode($proposals, JSON_PRETTY_PRINT));

        // Ambil input waktu berhalangan dosen jika ada
        $waktuBerhalangan = [];
        if ($request->has('waktu_berhalangan_dosen') && $request->waktu_berhalangan_dosen) {
            $waktuBerhalangan = $request->input('waktu_berhalangan', []);
        }

        $scheduler = new SemproSchedulerService();
        $jadwal = $scheduler->generate($proposals, $ruangs, $tanggals, $sesis, $dosenKuota, $waktuBerhalangan);

        // Urutkan jadwal berdasarkan tanggal dan waktu mulai (agar sesi 1 adalah waktu paling awal)
        usort($jadwal, function($a, $b) {
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
        }

        Log::info('Jadwal seminar proposal berhasil digenerate', [
            'jadwal' => $jadwal
        ]);

        return redirect()->route('jadwal-sempro.index')->with('success', 'Jadwal seminar proposal berhasil digenerate!');
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
}
