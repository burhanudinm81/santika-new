<?php

namespace App\Http\Controllers\Dosen\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarHasil;
use App\Models\NilaiAkhirMahasiswa;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\Revisi;
use App\Models\Tahap;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalSemhasController extends Controller
{
    public function showBerandaJadwalPage(): View
    {
        $listTahap = Tahap::all();
        $periodeAktif = Periode::where('aktif_sidang_akhir', 1)->first();

        $jmlBelumNilaiSementaraDospeng1 = Proposal::where('periode_semhas_id', $periodeAktif->id)
            ->where('penguji_sidang_ta_1_id', auth("dosen")->id())
            ->whereNull('status_semhas_penguji_1_id')
            ->select('tahap_semhas_id')
            ->groupBy('tahap_semhas_id')
            ->selectRaw('tahap_semhas_id, count(*) as jumlah')
            ->get();

        $jmlBelumNilaiSementaraDospeng2 = Proposal::where('periode_semhas_id', $periodeAktif->id)
            ->where('penguji_sidang_ta_2_id', auth("dosen")->id())
            ->whereNull('status_semhas_penguji_2_id')
            ->select('tahap_semhas_id')
            ->groupBy('tahap_semhas_id')
            ->selectRaw('tahap_semhas_id, count(*) as jumlah')
            ->get();

        $jmlBelumNilaiSementaraDosbing1 = Proposal::where('periode_semhas_id', $periodeAktif->id)
            ->where('dosen_pembimbing_1_id', auth("dosen")->id())
            ->whereNull('status_semhas_dosbing_1_id')
            ->select('tahap_semhas_id')
            ->groupBy('tahap_semhas_id')
            ->selectRaw('tahap_semhas_id, count(*) as jumlah')
            ->get();

        $jmlBelumNilaiSementaraDosbing2 = Proposal::where('periode_semhas_id', $periodeAktif->id)
            ->where('dosen_pembimbing_2_id', auth("dosen")->id())
            ->whereNull('status_semhas_dosbing_2_id')
            ->select('tahap_semhas_id')
            ->groupBy('tahap_semhas_id')
            ->selectRaw('tahap_semhas_id, count(*) as jumlah')
            ->get();

        $jmlRevisiBelumDicek = Revisi::join('proposal', 'proposal.id', '=', 'revisi.proposal_id')
            ->where('revisi.dosen_id', auth("dosen")->id())
            ->where('revisi.jenis_revisi', "semhas")
            ->where('revisi.status', 'pending')
            ->where('proposal.periode_semhas_id', $periodeAktif->id)
            ->groupBy('proposal.tahap_semhas_id')
            ->selectRaw('proposal.tahap_semhas_id, count(*) as jumlah')
            ->get();

        // dd($jmlBelumNilaiSementaraDospeng1, $jmlBelumNilaiSementaraDospeng2, $jmlBelumNilaiSementaraDosbing1, $jmlBelumNilaiSementaraDosbing2);

        $listTahap = Tahap::all()->map(function ($item) use ($jmlBelumNilaiSementaraDospeng1, $jmlBelumNilaiSementaraDospeng2, $jmlBelumNilaiSementaraDosbing1, $jmlBelumNilaiSementaraDosbing2, $jmlRevisiBelumDicek) {
            $jmlSementaraDospeng1 = $jmlBelumNilaiSementaraDospeng1->firstWhere('tahap_semhas_id', $item->id)->jumlah ?? 0;
            $jmlSementaraDospeng2 = $jmlBelumNilaiSementaraDospeng2->firstWhere('tahap_semhas_id', $item->id)->jumlah ?? 0;
            $jmlSementaraDosbing1 = $jmlBelumNilaiSementaraDosbing1->firstWhere('tahap_semhas_id', $item->id)->jumlah ?? 0;
            $jmlSementaraDosbing2 = $jmlBelumNilaiSementaraDosbing2->firstWhere('tahap_semhas_id', $item->id)->jumlah ?? 0;

            $jmlBelumRevisi = $jmlRevisiBelumDicek->firstWhere('tahap_semhas_id', $item->id)->jumlah ?? 0;

            $item->jumlahBelumNilaiSementara = $jmlSementaraDospeng1 + $jmlSementaraDospeng2 + $jmlSementaraDosbing1 + $jmlSementaraDosbing2;
            $item->jumlahBelumRevisi = $jmlBelumRevisi;

            return $item;
        });

        return view("dosen.seminar-hasil.beranda-jadwal", compact('listTahap'));
    }

    public function showJadwalPage(Request $request, int $tahapId, ?int $periodeId = 1): View
    {
        $tahap = Tahap::findOrFail($tahapId);
        $listPeriode = Periode::all();
        $idDosen = auth("dosen")->id();

        $jadwalSeminarHasilD3 = JadwalSeminarHasil::whereHas('proposal', function ($query) use ($idDosen, $tahapId, $periodeId) {
            $query->where(function ($q) use ($idDosen) {
                $q->where('dosen_pembimbing_1_id', $idDosen)
                    ->orWhere('dosen_pembimbing_2_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_1_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_2_id', $idDosen);

            })
                ->where('prodi_id', 1)
                ->where('tahap_semhas_id', $tahapId)
                ->where('periode_semhas_id', $periodeId);
        })
            ->with('proposal.proposalMahasiswas')
            ->get();

        $belumNilaiSementaraAsDospeng1D3 = Proposal::where('penguji_sidang_ta_1_id', $idDosen)
            ->where("prodi_id", 1)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_penguji_1_id')
            ->get();

        $belumNilaiSementaraAsDospeng2D3 = Proposal::where('penguji_sidang_ta_2_id', $idDosen)
            ->where("prodi_id", 1)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_penguji_2_id')
            ->get();

        $belumNilaiSementaraAsDosbing1D3 = Proposal::where('dosen_pembimbing_1_id', $idDosen)
            ->where("prodi_id", 1)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_dosbing_1_id')
            ->get();

        $belumNilaiSementaraAsDosbing2D3 = Proposal::where('dosen_pembimbing_2_id', $idDosen)
            ->where("prodi_id", 1)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_dosbing_2_id')
            ->get();

        $sudahNilaiAkhirAsDospeng1 = NilaiAkhirMahasiswa::where("penguji_1_id", auth("dosen")->id())
            ->whereNotNull("nilai_penguasaan_materi1")
            ->whereNotNull("nilai_presentasi1")
            ->whereNotNull("nilai_karya_tulis1")
            ->get();
        
        $sudahNilaiAkhirAsDospeng2 = NilaiAkhirMahasiswa::where("penguji_2_id", auth("dosen")->id())
            ->whereNotNull("nilai_penguasaan_materi2")
            ->whereNotNull("nilai_presentasi2")
            ->whereNotNull("nilai_karya_tulis2")
            ->get();

        $sudahNilaiAkhirAsDospem1 = NilaiAkhirMahasiswa::where("pembimbing_1_id", auth("dosen")->id())
            ->whereNotNull("nilai_sikap_pemb1")
            ->whereNotNull("nilai_kemampuan_pemb1")
            ->whereNotNull("nilai_hasilKarya_pemb1")
            ->whereNotNull("nilai_laporan_pemb1")
            ->get();
        
        $sudahNilaiAkhirAsDospem2 = NilaiAkhirMahasiswa::where("pembimbing_2_id", auth("dosen")->id())
            ->whereNotNull("nilai_sikap_pemb2")
            ->whereNotNull("nilai_kemampuan_pemb2")
            ->whereNotNull("nilai_hasilKarya_pemb2")
            ->whereNotNull("nilai_laporan_pemb2")
            ->get();

        $jadwalSeminarHasilD3->map(function ($item) use ($belumNilaiSementaraAsDospeng1D3, $belumNilaiSementaraAsDospeng2D3, $belumNilaiSementaraAsDosbing1D3, $belumNilaiSementaraAsDosbing2D3, $sudahNilaiAkhirAsDospeng1, $sudahNilaiAkhirAsDospeng2, $sudahNilaiAkhirAsDospem1, $sudahNilaiAkhirAsDospem2) {
            $semhasBelumNilaiAsDospeng1 = $belumNilaiSementaraAsDospeng1D3->firstWhere("id", $item->proposal?->id);
            $semhasBelumNilaiAsDospeng2 = $belumNilaiSementaraAsDospeng2D3->firstWhere("id", $item->proposal?->id);
            $semhasBelumNilaiAsDosbing1 = $belumNilaiSementaraAsDosbing1D3->firstWhere("id", $item->proposal?->id);
            $semhasBelumNilaiAsDosbing2 = $belumNilaiSementaraAsDosbing2D3->firstWhere("id", $item->proposal?->id);

            $semhasSudahNilaiAkhirAsDospeng1 = $sudahNilaiAkhirAsDospeng1->firstWhere("proposal_id", $item->proposal?->id);
            $semhasSudahNilaiAkhirAsDospeng2 = $sudahNilaiAkhirAsDospeng2->firstWhere("proposal_id", $item->proposal?->id);
            $semhasSudahNilaiAkhirAsDospem1 = $sudahNilaiAkhirAsDospem1->firstWhere("proposal_id", $item->proposal?->id);
            $semhasSudahNilaiAkhirAsDospem2 = $sudahNilaiAkhirAsDospem2->firstWhere("proposal_id", $item->proposal?->id);

            if (
                !is_null($semhasBelumNilaiAsDospeng1) || 
                !is_null($semhasBelumNilaiAsDospeng2) ||
                !is_null($semhasBelumNilaiAsDosbing1) ||
                !is_null($semhasBelumNilaiAsDosbing2)
            ) {
                $item->belumNilaiSementara = true;
            } else {
                $item->belumNilaiSementara = false;
            }

            if(
                !is_null($semhasSudahNilaiAkhirAsDospeng1) ||
                !is_null($semhasSudahNilaiAkhirAsDospeng2) ||
                !is_null($semhasSudahNilaiAkhirAsDospem1) ||
                !is_null($semhasSudahNilaiAkhirAsDospem2)
            ) {
                $item->sudahNilaiAkhir = true;
            } else {
                $item->sudahNilaiAkhir = false;
            }

            return $item;
        });

        $jadwalSeminarHasilD4 = JadwalSeminarHasil::whereHas('proposal', function ($query) use ($idDosen, $tahapId, $periodeId) {
            $query->where(function ($q) use ($idDosen) {
                $q->where('dosen_pembimbing_1_id', $idDosen)
                    ->orWhere('dosen_pembimbing_2_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_1_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_2_id', $idDosen);

            })
                ->where('prodi_id', 2)
                ->where('tahap_semhas_id', $tahapId)
                ->where('periode_semhas_id', $periodeId);
        })
            ->with('proposal.proposalMahasiswas')
            ->get();

        $belumNilaiSementaraAsDospeng1D4 = Proposal::where('penguji_sidang_ta_1_id', $idDosen)
            ->where("prodi_id", 2)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_penguji_1_id')
            ->get();

        $belumNilaiSementaraAsDospeng2D4 = Proposal::where('penguji_sidang_ta_2_id', $idDosen)
            ->where("prodi_id", 2)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_penguji_2_id')
            ->get();

        $belumNilaiSementaraAsDosbing1D4 = Proposal::where('dosen_pembimbing_1_id', $idDosen)
            ->where("prodi_id", 2)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_dosbing_1_id')
            ->get();

        $belumNilaiSementaraAsDosbing2D4 = Proposal::where('dosen_pembimbing_2_id', $idDosen)
            ->where("prodi_id", 2)
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->whereNull('status_semhas_dosbing_2_id')
            ->get();

         $jadwalSeminarHasilD4->map(function ($item) use ($belumNilaiSementaraAsDospeng1D4, $belumNilaiSementaraAsDospeng2D4, $belumNilaiSementaraAsDosbing1D4, $belumNilaiSementaraAsDosbing2D4, $sudahNilaiAkhirAsDospeng1, $sudahNilaiAkhirAsDospeng2, $sudahNilaiAkhirAsDospem1, $sudahNilaiAkhirAsDospem2) {
            $semhasBelumNilaiAsDospeng1 = $belumNilaiSementaraAsDospeng1D4->firstWhere("id", $item->proposal?->id);
            $semhasBelumNilaiAsDospeng2 = $belumNilaiSementaraAsDospeng2D4->firstWhere("id", $item->proposal?->id);
            $semhasBelumNilaiAsDosbing1 = $belumNilaiSementaraAsDosbing1D4->firstWhere("id", $item->proposal?->id);
            $semhasBelumNilaiAsDosbing2 = $belumNilaiSementaraAsDosbing2D4->firstWhere("id", $item->proposal?->id);

            $semhasSudahNilaiAkhirAsDospeng1 = $sudahNilaiAkhirAsDospeng1->firstWhere("proposal_id", $item->proposal?->id);
            $semhasSudahNilaiAkhirAsDospeng2 = $sudahNilaiAkhirAsDospeng2->firstWhere("proposal_id", $item->proposal?->id);
            $semhasSudahNilaiAkhirAsDospem1 = $sudahNilaiAkhirAsDospem1->firstWhere("proposal_id", $item->proposal?->id);
            $semhasSudahNilaiAkhirAsDospem2 = $sudahNilaiAkhirAsDospem2->firstWhere("proposal_id", $item->proposal?->id);

            if (
                !is_null($semhasBelumNilaiAsDospeng1) || 
                !is_null($semhasBelumNilaiAsDospeng2) ||
                !is_null($semhasBelumNilaiAsDosbing1) ||
                !is_null($semhasBelumNilaiAsDosbing2)
            ) {
                $item->belumNilaiSementara = true;
            } else {
                $item->belumNilaiSementara = false;
            }

            if(
                !is_null($semhasSudahNilaiAkhirAsDospeng1) ||
                !is_null($semhasSudahNilaiAkhirAsDospeng2) ||
                !is_null($semhasSudahNilaiAkhirAsDospem1) ||
                !is_null($semhasSudahNilaiAkhirAsDospem2)
            ) {
                $item->sudahNilaiAkhir = true;
            } else {
                $item->sudahNilaiAkhir = false;
            }

            return $item;
        });

        return view(
            "dosen.seminar-hasil.jadwal",
            compact('tahap', 'listPeriode', 'jadwalSeminarHasilD3', 'jadwalSeminarHasilD4', 'periodeId')
        );
    }
}
