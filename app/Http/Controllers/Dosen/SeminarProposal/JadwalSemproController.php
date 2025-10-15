<?php

namespace App\Http\Controllers\Dosen\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarProposal;
use App\Models\Periode;
use App\Models\Proposal;
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

        $listTahap = Tahap::all()->map(function($item) use ($jmlBelumNilaiDospeng1, $jmlBelumNilaiDospeng2){
            $jmlDospeng1 = $jmlBelumNilaiDospeng1->firstWhere('tahap_id', $item->id)->jumlah ?? 0;
            $jmlDospeng2 = $jmlBelumNilaiDospeng2->firstWhere('tahap_id', $item->id)->jumlah ?? 0;

            $item->jumlahBelumNilai = $jmlDospeng1 + $jmlDospeng2;
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
            $query->where(function($q) use ($idDosen) {
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

        $jadwalSeminarProposalD4 = JadwalSeminarProposal::whereHas('proposal', function ($query) use ($idDosen, $tahapId, $periodeId) {
            $query->where(function($q) use ($idDosen) {
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

        return view(
            "dosen.seminar-proposal.jadwal", 
            compact('tahap', 'listPeriode', 'jadwalSeminarProposalD3', 'jadwalSeminarProposalD4', 'periodeId')
        );
    }
}
