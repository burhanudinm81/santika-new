<?php

namespace App\Http\Controllers\Mahasiswa\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\BidangMinat;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;

class SeminarHasilController extends Controller
{
    public function showPendaftaranPage()
    {
        $infoProposal = Proposal::with(['proposalMahasiswas', 'dosenPembimbing1', 'dosenPembimbing2', 'bidangMinat'])
            ->whereRelation('proposalMahasiswas', 'mahasiswa_id', auth('mahasiswa')->user()->id)
            ->first();
        $infoMahasiswaAll = ProposalDosenMahasiswa::with(['dosen', 'mahasiswa'])
            ->where('proposal_id', $infoProposal->id)
            ->get();
        $infoDospem1 = $infoProposal->dosenPembimbing1()->first();
        $infoDospem2 = $infoProposal->dosenPembimbing2()->first();

        $infoBidangMinat = BidangMinat::all();

        return view('mahasiswa.seminar-hasil.daftar-semhas', compact([
            'infoProposal',
            'infoMahasiswaAll',
            'infoDospem1',
            'infoDospem2',
            'infoBidangMinat',
        ]));
    }

    public function storePendaftaran(Request $Request)
    {
        
    }
}
