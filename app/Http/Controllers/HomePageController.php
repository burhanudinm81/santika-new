<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LogBook;
use App\Models\Mahasiswa;
use App\Models\Panitia;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use App\Models\PendaftaranSeminarProposal;
use App\Models\Notifikasi;
use App\Models\PendaftaranSemhas;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\Revisi;
use App\Models\Tahap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Carbon\Carbon;

class HomePageController extends Controller
{
    protected function getChart()
    {
        $prodis = Prodi::get();
        $dataChart = [];

        foreach ($prodis as $prodi) {
            $totalMahasiswa = Mahasiswa::where('prodi_id', $prodi->id)->count();

            $belumSempro = PendaftaranSeminarProposal::whereHas('proposal', function ($q) use ($prodi) {
                $q->where('prodi_id', $prodi->id);
            })->where('status_daftar_sempro_id', 3)->count();

            $sudahSempro = PendaftaranSeminarProposal::whereHas('proposal', function ($q) use ($prodi) {
                $q->where('prodi_id', $prodi->id);
            })->where('status_daftar_sempro_id', 1)->count();

            $belumSidang = PendaftaranSemhas::whereHas('proposal', function ($q) use ($prodi) {
                $q->where('prodi_id', $prodi->id);
            })->where('status_daftar_semhas_id', 3)->count();

            $sudahSidang = PendaftaranSemhas::whereHas('proposal', function ($q) use ($prodi) {
                $q->where('prodi_id', $prodi->id);
            })->where('status_daftar_semhas_id', 1)->count();

            $dataChart[] = [
                'prodi' => $prodi->prodi,
                'slug' => Str::slug($prodi->prodi, '_'),
                'sempro' => [
                    'belum' => $belumSempro,
                    'sudah' => $sudahSempro,
                ],
                'sidang' => [
                    'belum' => $belumSidang,
                    'sudah' => $sudahSidang,
                ],
                'totalMahasiswa' => $totalMahasiswa
            ];
        }

        return $dataChart;
    }

    public function adminProdi(): View
    {
        return view("admin-prodi.dashboard", [
            'dataChart' => $this->getChart(),
        ]);
    }
    public function mahasiswa(Request $request): View
    {
        $today = Carbon::today();

        $id = Auth::id();

        $riwayatPengajuanJudul = ProposalDosenMahasiswa::join('proposal', 'proposal.id', '=', 'proposal_dosen_mahasiswa.proposal_id')
            ->where('proposal_dosen_mahasiswa.mahasiswa_id', $id)
            ->whereIn('proposal_dosen_mahasiswa.status_proposal_mahasiswa_id', [1, 2])
            ->whereRaw('? BETWEEN DATE(proposal_dosen_mahasiswa.updated_at) AND DATE(DATE_ADD(proposal_dosen_mahasiswa.updated_at, INTERVAL 7 DAY))', [$today])
            ->select('proposal_dosen_mahasiswa.*', 'proposal.judul')
            ->get();

        $notifikasi = Notifikasi::where(function ($q) use ($id) {
            $q->whereNull('mahasiswa_id')->orWhere('mahasiswa_id', $id);
        })->whereNull('dosen_id')->whereRaw('? BETWEEN DATE(updated_at) AND DATE(DATE_ADD(updated_at, INTERVAL 7 DAY))', [$today])
            ->latest()
            ->take(5)
            ->get();

        $forceChangePassword = Hash::check(
            $request->user("mahasiswa")->NIM,
            $request->user("mahasiswa")->password
        );

        return view("mahasiswa.dashboard", [
            "forceChangePassword" => $forceChangePassword,
            'riwayatPengajuanJudul' => $riwayatPengajuanJudul,
            'notifikasi' => $notifikasi,
            'dataChart' => $this->getChart(),
        ]);
    }

    public function dosen(Request $request): View
    {
        $forceChangePassword = Hash::check(
            $request->user("dosen")->NIDN,
            $request->user("dosen")->password
        );

        $isPanitia = false; // Defaultnya false

        // Mengambil ID Dosen
        $dosenId = Auth::guard('dosen')->id();
        // Cek ke database apakah ID dosen ada di tabel panitia
        $isPanitia = Panitia::where('dosen_id', $dosenId)->exists();

        $today = Carbon::today();
        $notifikasi = Notifikasi::whereNull('tipe')->where('dosen_id', $dosenId)->whereRaw('? BETWEEN DATE(updated_at) AND DATE(DATE_ADD(updated_at, INTERVAL 7 DAY))', [$today])
            ->latest()
            ->take(5)
            ->get();

        // jumlah permohonan judul yang belum diverifikasi/dicek
        $unverifiedPermohonanJudulCount = ProposalDosenMahasiswa::with(['mahasiswa', 'proposal', 'statusProposalMahasiswa'])
            ->where('dosen_id', auth('dosen')->user()->id)
            ->where('status_proposal_mahasiswa_id', 3)
            ->count();

        // Periode Aktif
        $periodeAktif = Periode::firstWhere("aktif_sempro", true);

        // Jumlah Sempro yang belum diberi status kelulusan (belum dinilai)
        $jmlBelumNilaiSempro1 = Proposal::where('periode_id', operator: $periodeAktif->id)
                ->where('penguji_sempro_1_id', auth("dosen")->id())
                ->whereNull('status_sempro_penguji_1_id')
                ->count();

        $jmlBelumNilaiSempro2 = Proposal::where('periode_id', operator: $periodeAktif->id)
                ->where('penguji_sempro_2_id', auth("dosen")->id())
                ->whereNull('status_sempro_penguji_2_id')
                ->count();

        $jmlBelumNilaSempro = $jmlBelumNilaiSempro1 + $jmlBelumNilaiSempro2;

        $jmlRevisiBelumDicek = Revisi::join('proposal', 'proposal.id', '=', 'revisi.proposal_id')
            ->where('revisi.dosen_id', auth("dosen")->id())
            ->where('revisi.jenis_revisi', "sempro")
            ->where('revisi.status', 'pending')
            ->where('proposal.periode_id', $periodeAktif->id)
            ->count();

        $jmlLogbookBelumDicek = LogBook::where("dosen_id", auth("dosen")->id())
            ->where("status_logbook_id", 1)
            ->select("mahasiswa_id")
            ->distinct()
            ->get()
            ->count();

        return view("dosen.dashboard", [
            "forceChangePassword" => $forceChangePassword,
            "isPanitia" => $isPanitia,
            'dataChart' => $this->getChart(),
            'notifikasi' => $notifikasi,
            'unverifiedPermohonanJudulCount' => $unverifiedPermohonanJudulCount,
            "jumlahBelumNilaiSempro" => $jmlBelumNilaSempro,
            "jumlahRevisiBelumDicek" => $jmlRevisiBelumDicek,
            "jumlahLogbookBelumDicek" => $jmlLogbookBelumDicek
        ]);
    }

    public function panitia(Request $request): View
    {
        $forceChangePassword = Hash::check(
            $request->user("dosen")->NIDN,
            $request->user("dosen")->password
        );

        $today = Carbon::today();
        $notifikasi = Notifikasi::where('tipe', 'panitia')->where('dosen_id', Auth::guard('dosen')->id())->whereRaw('? BETWEEN DATE(updated_at) AND DATE(DATE_ADD(updated_at, INTERVAL 7 DAY))', [$today])
            ->latest()
            ->take(5)
            ->get();

        $periodeAktif = Periode::firstWhere("aktif_sempro", true);
        $prodiPanitiaId = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        // Jumlah Proposal yg lulus tanpa revisi untuk D3 yang belum punya dosen pembimbing 2
        $jmlProposalD3LulusTanpaRevisi = Proposal::where('prodi_id', 1)
            ->where('periode_id', $periodeAktif->id)
            ->where('status_sempro_proposal_id', 1)
            ->whereNull('dosen_pembimbing_2_id')
            ->count();

        // Jumlah Proposal yg lulus dengan revisi untuk D3 yang belum punya dosen pembimbing 2
        $jmlProposalD3LulusDenganRevisi = Proposal::where('prodi_id', 1)
            ->where('periode_id', $periodeAktif->id)
            ->where('status_sempro_proposal_id', 2)
            ->whereNull('dosen_pembimbing_2_id')
            ->whereHas('revisi', function ($query) {
                $query->where("jenis_revisi", "sempro")
                    ->where("status", "diterima");
            })
            ->count();

        // Jumlah Proposal yg lulus tanpa revisi untuk D4 yang belum punya dosen pembimbing 2
        $jmlProposalD4LulusTanpaRevisi = Proposal::where('prodi_id', 2)
            ->where('periode_id', $periodeAktif->id)
            ->where('status_sempro_proposal_id', 1)
            ->whereNull('dosen_pembimbing_2_id')
            ->count();

        // Jumlah Proposal yg lulus dengan revisi untuk D4 yang belum punya dosen pembimbing 2
        $jmlProposalD4LulusDenganRevisi = Proposal::where('prodi_id', 2)
            ->where('periode_id', $periodeAktif->id)
            ->where('status_sempro_proposal_id', 2)
            ->whereNull('dosen_pembimbing_2_id')
            ->whereHas('revisi', function ($query) {
                $query->where("jenis_revisi", "sempro")
                    ->where("status", "diterima");
            })
            ->count();

        $mhsD3BelumPunyaDosbing2 = $jmlProposalD3LulusTanpaRevisi + $jmlProposalD3LulusDenganRevisi;
        $mhsD4BelumPunyaDosbing2 = $jmlProposalD4LulusTanpaRevisi + $jmlProposalD4LulusDenganRevisi;


        $pendingSempro = PendaftaranSeminarProposal::where(function ($q) use ($periodeAktif) {
            $q->whereHas('proposal', function ($p) use ($periodeAktif) {
                $p->where('periode_id', $periodeAktif->id);
            });
        })->where('status_daftar_sempro_id', 3)
            ->count();

        $pendingSemhas = PendaftaranSemhas::where(function ($q) use ($periodeAktif) {
            $q->whereHas('proposal', function ($p) use ($periodeAktif) {
                $p->where('periode_id', $periodeAktif->id);
            });
        })->where('status_daftar_semhas_id', 3)
            ->count();

        return view("panitia.dashboard", [
            "forceChangePassword" => $forceChangePassword,
            'dataChart' => $this->getChart(),
            'notifikasi' => $notifikasi,
            'pendingSempro' => $pendingSempro,
            'pendingSemhas' => $pendingSemhas,
            'prodiPanitiaId' => $prodiPanitiaId,
            'mhsD3BelumPunyaDosbing2' => $mhsD3BelumPunyaDosbing2,
            'mhsD4BelumPunyaDosbing2' => $mhsD4BelumPunyaDosbing2
        ]);
    }
}
