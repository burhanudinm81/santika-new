<?php

namespace App\Http\Controllers\Mahasiswa\InformasiDosen;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DaftarDosenPembimbingController extends Controller
{
    public function index()
    {
        $proposal = null;

        // Mendapatkan Proposal
        $latestProposalDosenMhs = ProposalDosenMahasiswa::where('mahasiswa_id', auth('mahasiswa')->id())
            ->where('status_proposal_mahasiswa_id', 1)
            ->latest()
            ->first();

        if (!is_null($latestProposalDosenMhs)) {
            $proposal = Proposal::with([
                'dosenPembimbing1',
                'dosenPembimbing2'
            ])->find($latestProposalDosenMhs->proposal_id);
        }

        return view("mahasiswa.informasi-dosen.daftar-dosen-pembimbing", compact('proposal'));
    }
}
