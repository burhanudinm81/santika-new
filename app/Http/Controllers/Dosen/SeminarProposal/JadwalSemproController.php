<?php

namespace App\Http\Controllers\Dosen\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarProposal;
use App\Models\Periode;
use App\Models\Tahap;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalSemproController extends Controller
{
    public function showBerandaJadwalPage(): View
    {
        $listTahap = Tahap::all();

        return view("dosen.seminar-proposal.beranda-jadwal", compact('listTahap'));
    }

    public function showJadwalPage(Request $request, int $tahapId, ?int $periodeId = 1): View
    {
        $tahap = Tahap::findOrFail($tahapId);
        $listPeriode = Periode::all();
        $idDosen = auth("dosen")->id();

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
