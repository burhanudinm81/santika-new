<?php

namespace App\Http\Controllers\Mahasiswa\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarHasil;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalSemhasController extends Controller
{
    public function showJadwalPage(): View
    {
        $proposalId = ProposalDosenMahasiswa::where('mahasiswa_id', auth("mahasiswa")->id())
            ->latest()
            ->value('proposal_id');

        $jadwalSeminarHasil = JadwalSeminarHasil::where('proposal_id', $proposalId)
            ->with(['proposal.dosenPembimbing1', 'proposal.dosenPembimbing2'])
            ->first();

        return view("mahasiswa.seminar-hasil.jadwal", compact('jadwalSeminarHasil'));
    }
}
