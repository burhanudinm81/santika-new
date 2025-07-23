<?php

namespace App\Http\Controllers\Dosen\Bimbingan;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function showDaftarBimbingan()
    {
        $listBimbinganD3 = [];
        $listBimbinganD4 = null;


        $proposalD3 = Proposal::where('prodi_id', 1)
            ->where('dosen_pembimbing_1_id', auth('dosen')->user()->id)
            ->orWhere('dosen_pembimbing_2_id', auth('dosen')->user()->id)
            ->get();


        $proposalD4 = Proposal::where('prodi_id', 2)
            ->where('dosen_pembimbing_1_id', auth('dosen')->user()->id)
            ->orWhere('dosen_pembimbing_2_id', auth('dosen')->user()->id)
            ->get();

        foreach ($proposalD3 as $item) {
            $proposalDosenMahasiswa = ProposalDosenMahasiswa::where('proposal_id', $item->id)->get();
            if (count($proposalDosenMahasiswa) > 0) {
                $listBimbinganD3[] = $proposalDosenMahasiswa;
            }
        }


        foreach ($proposalD4 as $item) {
            $proposalDosenMahasiswa = ProposalDosenMahasiswa::where('proposal_id', $item->id)->first();
            if ($proposalDosenMahasiswa) {
                $listBimbinganD4[] = $proposalDosenMahasiswa;
            }
        }

        return view('dosen.bimbingan.daftar-bimbingan', compact(['listBimbinganD3', 'listBimbinganD4']));
    }
}
