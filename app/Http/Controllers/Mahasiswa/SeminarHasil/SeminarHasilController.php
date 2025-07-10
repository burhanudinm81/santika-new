<?php

namespace App\Http\Controllers\Mahasiswa\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;

class SeminarHasilController extends Controller
{
    public function showPendaftaranPage()
    {
        $infoProposal = Proposal::with('proposalMahasiswas')
            ->whereRelation('proposalMahasiswas', 'mahasiswa_id', auth('mahasiswa')->user()->id)
            ->first();

        $infoMahasiswa = $infoProposal->proposalMahasiswas()->get();


        dd($infoMahasiswa[0]);

        return view('mahasiswa.seminar-hasil.daftar-semhas');
    }
}
