<?php

namespace App\Http\Controllers\Dosen\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarProposal;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\Revisi;
use App\Models\Tahap;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalSemproController extends Controller
{
    public function showBerandaJadwalPage(): View
    {
        $periodeAktif = Periode::where('aktif_sempro', 1)->first();

        $jmlBelumNilaiDospeng1 = Proposal::where('periode_id', operator: $periodeAktif->id)
            ->where('penguji_sempro_1_id', auth("dosen")->id())
            ->whereNull('status_sempro_penguji_1_id')
            ->select('tahap_id')
            ->groupBy('tahap_id')
            ->selectRaw('tahap_id, count(*) as jumlah')
            ->get();

        $jmlBelumNilaiDospeng2 = Proposal::where('periode_id', operator: $periodeAktif->id)
            ->where('penguji_sempro_2_id', auth("dosen")->id())
            ->whereNull('status_sempro_penguji_2_id')
            ->select('tahap_id')
            ->groupBy('tahap_id')
            ->selectRaw('tahap_id, count(*) as jumlah')
            ->get();

        $jmlRevisiBelumDicek = Revisi::join('proposal', 'proposal.id', '=', 'revisi.proposal_id')
            ->where('revisi.dosen_id', auth("dosen")->id())
            ->where('revisi.jenis_revisi', "sempro")
            ->where('revisi.status', 'pending')
            ->where('proposal.periode_id', $periodeAktif->id)
            ->groupBy('proposal.tahap_id')
            ->selectRaw('proposal.tahap_id, count(*) as jumlah')
            ->get();

        $listTahap = Tahap::all()->map(function ($item) use ($jmlBelumNilaiDospeng1, $jmlBelumNilaiDospeng2, $jmlRevisiBelumDicek) {
            $jmlDospeng1 = $jmlBelumNilaiDospeng1->firstWhere('tahap_id', $item->id)->jumlah ?? 0;
            $jmlDospeng2 = $jmlBelumNilaiDospeng2->firstWhere('tahap_id', $item->id)->jumlah ?? 0;
            $jmlBelumRevisi = $jmlRevisiBelumDicek->firstWhere('tahap_id', $item->id)->jumlah ?? 0;

            $item->jumlahBelumNilai = $jmlDospeng1 + $jmlDospeng2;
            $item->jumlahBelumRevisi = $jmlBelumRevisi;

            return $item;
        });

        return view("dosen.seminar-proposal.beranda-jadwal", compact('listTahap'));
    }

    public function showJadwalPage(Request $request, int $tahapId, ?int $periodeId = null): View
    {
        $tahap = Tahap::findOrFail($tahapId);
        $listPeriode = Periode::all();
        $idDosen = auth("dosen")->id();

        $periodeId = $periodeId ?? $listPeriode->firstWhere('aktif_sempro', true)?->id;

        $jadwalSeminarProposalD3 = JadwalSeminarProposal::whereHas('proposal', function ($query) use ($idDosen, $tahapId, $periodeId) {
            $query->where(function ($q) use ($idDosen) {
                $q->where('dosen_pembimbing_1_id', $idDosen)
                    ->orWhere('penguji_sempro_1_id', $idDosen)
                    ->orWhere('penguji_sempro_2_id', $idDosen);

            })
                ->where('prodi_id', 1)
                ->where('tahap_id', $tahapId)
                ->where('periode_id', $periodeId);
        })
            ->with('proposal.proposalMahasiswas')
            ->get();

        $belumNilaiAsDospeng1D3 = Proposal::where('penguji_sempro_1_id', $idDosen)
            ->where("prodi_id", 1)
            ->where("tahap_id", $tahapId)
            ->where("periode_id", $periodeId)
            ->whereNull('status_sempro_penguji_1_id')
            ->get();

        $belumNilaiAsDospeng2D3 = Proposal::where('penguji_sempro_2_id', $idDosen)
            ->where("prodi_id", 1)
            ->where("tahap_id", $tahapId)
            ->where("periode_id", $periodeId)
            ->whereNull('status_sempro_penguji_2_id')
            ->get();

        $revisiBelumCekAsDosPeng1D3 = Revisi::whereHas('proposal', function($q) use($tahapId, $periodeId, $idDosen) {
            $q->where("prodi_id", 1)
                ->where("tahap_id", $tahapId)
                ->where("periode_id", $periodeId)
                ->where("penguji_sempro_1_id", $idDosen);
        })
            ->where("jenis_revisi", "sempro")
            ->where("status", "pending")
            ->get();

        $revisiBelumCekAsDosPeng2D3 = Revisi::whereHas('proposal', function($q) use($tahapId, $periodeId, $idDosen) {
            $q->where("prodi_id", 1)
                ->where("tahap_id", $tahapId)
                ->where("periode_id", $periodeId)
                ->where("penguji_sempro_2_id", $idDosen);
        })
            ->where("jenis_revisi", "sempro")
            ->where("status", "pending")
            ->get();

        $jadwalSeminarProposalD3->map(function ($item) use ($belumNilaiAsDospeng1D3, $belumNilaiAsDospeng2D3, $revisiBelumCekAsDosPeng1D3, $revisiBelumCekAsDosPeng2D3) {
            $semproBelumNilaiAsDospeng1 = $belumNilaiAsDospeng1D3->firstWhere("id", $item->proposal?->id);
            $semproBelumNilaiAsDospeng2 = $belumNilaiAsDospeng2D3->firstWhere("id", $item->proposal?->id);
            $belumCekRevisiAsDospeng1 = $revisiBelumCekAsDosPeng1D3->firstWhere("proposal_id", $item->proposal?->id);
            $belumCekRevisiAsDospeng2 = $revisiBelumCekAsDosPeng2D3->firstWhere("proposal_id", $item->proposal?->id);

            if (!is_null($semproBelumNilaiAsDospeng1) || !is_null($semproBelumNilaiAsDospeng2)) {
                $item->belumDinilai = true;
            } else {
                $item->belumDinilai = false;
            }

            if (!is_null($belumCekRevisiAsDospeng1) || !is_null($belumCekRevisiAsDospeng2)) {
                $item->belumCekRevisi = true;
            } else {
                $item->belumCekRevisi = false;
            }

            return $item;
        });

        $jadwalSeminarProposalD4 = JadwalSeminarProposal::whereHas('proposal', function ($query) use ($idDosen, $tahapId, $periodeId) {
            $query->where(function ($q) use ($idDosen) {
                $q->where('dosen_pembimbing_1_id', $idDosen)
                    ->orWhere('penguji_sempro_1_id', $idDosen)
                    ->orWhere('penguji_sempro_2_id', $idDosen);

            })
                ->where('prodi_id', 2)
                ->where('tahap_id', $tahapId)
                ->where('periode_id', $periodeId);
        })
            ->with('proposal.proposalMahasiswas')
            ->get();

        $belumNilaiAsDospeng1D4 = Proposal::where('penguji_sempro_1_id', $idDosen)
            ->where("prodi_id", 2)
            ->where("tahap_id", $tahapId)
            ->where("periode_id", $periodeId)
            ->whereNull('status_sempro_penguji_1_id')
            ->get();

        $belumNilaiAsDospeng2D4 = Proposal::where('penguji_sempro_2_id', $idDosen)
            ->where("prodi_id", 2)
            ->where("tahap_id", $tahapId)
            ->where("periode_id", $periodeId)
            ->whereNull('status_sempro_penguji_2_id')
            ->get();

        $revisiBelumCekAsDosPeng1D4 = Revisi::whereHas('proposal', function($q) use($tahapId, $periodeId, $idDosen) {
            $q->where("prodi_id", 2)
                ->where("tahap_id", $tahapId)
                ->where("periode_id", $periodeId)
                ->where("penguji_sempro_1_id", $idDosen);
        })
            ->where("jenis_revisi", "sempro")
            ->where("status", "pending")
            ->get();

        $revisiBelumCekAsDosPeng2D4 = Revisi::whereHas('proposal', function($q) use($tahapId, $periodeId, $idDosen) {
            $q->where("prodi_id", 2)
                ->where("tahap_id", $tahapId)
                ->where("periode_id", $periodeId)
                ->where("penguji_sempro_2_id", $idDosen);
        })
            ->where("jenis_revisi", "sempro")
            ->where("status", "pending")
            ->get();

        $jadwalSeminarProposalD4->map(function ($item) use ($belumNilaiAsDospeng1D4, $belumNilaiAsDospeng2D4, $revisiBelumCekAsDosPeng1D4, $revisiBelumCekAsDosPeng2D4) {
            $semproBelumNilaiAsDospeng1 = $belumNilaiAsDospeng1D4->firstWhere("id", $item->proposal?->id);
            $semproBelumNilaiAsDospeng2 = $belumNilaiAsDospeng2D4->firstWhere("id", $item->proposal?->id);
            $belumCekRevisiAsDospeng1 = $revisiBelumCekAsDosPeng1D4->firstWhere("proposal_id", $item->proposal?->id);
            $belumCekRevisiAsDospeng2 = $revisiBelumCekAsDosPeng2D4->firstWhere("proposal_id", $item->proposal?->id);

            if (!is_null($semproBelumNilaiAsDospeng1) || !is_null($semproBelumNilaiAsDospeng2)) {
                $item->belumDinilai = true;
            } else {
                $item->belumDinilai = false;
            }

            if (!is_null($belumCekRevisiAsDospeng1) || !is_null($belumCekRevisiAsDospeng2)) {
                $item->belumCekRevisi = true;
            } else {
                $item->belumCekRevisi = false;
            }

            return $item;
        });

        return view(
            "dosen.seminar-proposal.jadwal",
            compact('tahap', 'listPeriode', 'jadwalSeminarProposalD3', 'jadwalSeminarProposalD4', 'periodeId')
        );
    }
}
