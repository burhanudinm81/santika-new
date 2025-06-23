<?php

namespace App\Http\Controllers\Dosen\PermohonanJudul;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;

class PermohonanJudulController extends Controller
{
    public function showPermohonanPage()
    {
        $listPermohonanD4 = ProposalDosenMahasiswa::with(['mahasiswa', 'proposal', 'statusProposalMahasiswa'])
            ->where('dosen_id', auth('dosen')->user()->id)
            ->whereRelation('mahasiswa', 'prodi_id', 2)
            ->where('status_proposal_mahasiswa_id', 3)
            ->get();

        $listPermohonanD3 = ProposalDosenMahasiswa::with(['mahasiswa', 'proposal', 'statusProposalMahasiswa'])
            ->where('dosen_id', auth('dosen')->user()->id)
            ->whereRelation('mahasiswa', 'prodi_id', 1)
            ->get();
        $groupedPermohonanD3 = $listPermohonanD3->groupBy('proposal_id');

        return view('dosen.permohonan-judul', compact(['groupedPermohonanD3', 'listPermohonanD4']));
    }

    public function showDetailPermohonanPage($proposalId)
    {
        $permohonanProposalMahasiswa = ProposalDosenMahasiswa::with(['proposal', 'mahasiswa', 'statusProposalMahasiswa'])
            ->where('proposal_id', $proposalId)
            ->get();


        return view('dosen.detail-permohonan-judul', compact('permohonanProposalMahasiswa'));
    }

    public function updatePermohonan(Request $request)
    {
        $proposalId = $request->proposal_id;
        $confirmationStatusId = $request->confirmation_status_id;

        $proposal = Proposal::findOrFail($proposalId);

        if($proposal->prodi_id == 1){
            $proposalMahasiswa = ProposalDosenMahasiswa::where('proposal_id', $proposalId)->where('status_proposal_mahasiswa_id', 3)->get();
            if(count($proposalMahasiswa) > 0){
                foreach($proposalMahasiswa as $item){
                    $item->update(['status_proposal_mahasiswa_id' => $confirmationStatusId]);
                }
            }
        }else{
            $proposalMahasiswa = ProposalDosenMahasiswa::where('proposal_id', $proposalId)->where('status_proposal_mahasiswa_id', 3)->first();
            $proposalMahasiswa->update(['status_proposal_mahasiswa_id' => $confirmationStatusId]);
        }

        return redirect()->back()->with('success', 'Pengajuan Judul Berhasil Diupdate');
    }
}
