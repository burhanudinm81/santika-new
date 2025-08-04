<?php

namespace App\Http\Controllers\Mahasiswa\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarProposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalSemproController extends Controller
{
    public function showJadwalPage(): View
    {
        $proposalId = ProposalDosenMahasiswa::where('mahasiswa_id', auth("mahasiswa")->id())
            ->latest()
            ->value('proposal_id');

        $jadwalSeminarProposal = JadwalSeminarProposal::where('proposal_id', $proposalId)
            ->with('proposal.dosenPembimbing1')
            ->first();

        return view("mahasiswa.seminar-proposal.jadwal", compact('jadwalSeminarProposal'));
    }
}
