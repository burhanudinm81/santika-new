<?php

namespace App\Http\Controllers\Panitia\PlottingPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\KuotaDosen;
use App\Models\Proposal;
use Illuminate\Http\Request;

class PlottingPembimbingController extends Controller
{
    // Membuka halaman plotting pembimbing
    public function index()
    {
        $listProposalD3 = Proposal::where('prodi_id', 1)
            ->where('periode_id', 1)
            ->where(function ($query) {
                $query->where('status_sempro_proposal_id', 1)           // Status proposal yang diterima tanpa revisi
                    ->orWhere('status_sempro_proposal_id', 2);        // Status proposal yang diterima dengan revisi
            })
            ->with(['proposalMahasiswas.mahasiswa', 'dosenPembimbing1', 'dosenPembimbing2'])
            ->get();

        $listProposalD4 = Proposal::where('prodi_id', 2)
            ->where('periode_id', 1)
            ->where(function ($query) {
                $query->where('status_sempro_proposal_id', 1)           // Status proposal yang diterima tanpa revisi
                    ->orWhere('status_sempro_proposal_id', 2);        // Status proposal yang diterima dengan revisi
            })
            ->with(['proposalMahasiswas.mahasiswa', 'dosenPembimbing1', 'dosenPembimbing2'])
            ->get();

        $listDosen = Dosen::with('kuotaDosen')->get();

        return view('panitia.plotting-pembimbing.index', compact('listProposalD3', 'listProposalD4', 'listDosen'));
    }

    public function update(Request $request)
    {
        $request->validate([
            "prodi_id" => 'required|exists:prodi,id',
            'proposal_id' => 'required|exists:proposal,id',
            'dosen_pembimbing_1_id' => 'required|exists:dosen,id',
            'dosen_pembimbing_2_id' => 'nullable|exists:dosen,id',
        ]);

        $prodiId = $request->input('prodi_id');
        $proposalId = $request->input('proposal_id');
        $dosenPembimbing1Id = $request->input('dosen_pembimbing_1_id');
        $dosenPembimbing2Id = $request->input('dosen_pembimbing_2_id');

        $proposal = Proposal::findOrFail($proposalId);
        $kuotaDosenPembimbing1 = KuotaDosen::firstWhere('dosen_id', $dosenPembimbing1Id);
        $kuotaDosenPembimbing2 = KuotaDosen::firstWhere('dosen_id', $dosenPembimbing2Id);

        if ($dosenPembimbing1Id != $proposal->dosen_pembimbing_1_id) {
            // Mengubah Dosen Pembimbing 1
            $proposal->dosen_pembimbing_1_id = $dosenPembimbing1Id;
            
            if($prodiId == 1) {
                if($kuotaDosenPembimbing1->kuota_pembimbing_1_D3 <= 0){
                    return back()->withErrors(['error' => 'Kuota pembimbing D3 untuk dosen ini sudah habis.']);
                }
                else{
                    // Mengurangi Kuota Dosen Pembimbing 1 D3
                    $kuotaDosenPembimbing1->kuota_pembimbing_1_D3--;
                }
                
            } elseif ($prodiId == 2) {
                if($kuotaDosenPembimbing1->kuota_pembimbing_1_D4 <= 0){
                    return back()->withErrors(['error' => 'Kuota pembimbing D4 untuk dosen ini sudah habis.']);
                }
                else{
                    // Mengurangi Kuota Dosen Pembimbing 1 D4
                    $kuotaDosenPembimbing1->kuota_pembimbing_1_D4--;
                }
            }
        }
        if ($dosenPembimbing2Id != $proposal->dosen_pembimbing_2_id) {
            // Mengubah Dosen Pembimbing 2
            $proposal->dosen_pembimbing_2_id = $dosenPembimbing2Id;

            if($prodiId == 1) {
                if($kuotaDosenPembimbing2->kuota_pembimbing_2_D3 <= 0){
                    return back()->withErrors(['error' => 'Kuota pembimbing D3 untuk dosen ini sudah habis.']);
                }
                else{
                    // Mengurangi Kuota Dosen Pembimbing 1 D3
                    $kuotaDosenPembimbing2->kuota_pembimbing_2_D3--;
                }
                
            } elseif ($prodiId == 2) {
                if($kuotaDosenPembimbing2->kuota_pembimbing_2_D4 <= 0){
                    return back()->withErrors(['error' => 'Kuota pembimbing D4 untuk dosen ini sudah habis.']);
                }
                else{
                    // Mengurangi Kuota Dosen Pembimbing 1 D4
                    $kuotaDosenPembimbing2->kuota_pembimbing_2_D4--;
                }
            }
        }

        $kuotaDosenPembimbing1->save();
        $kuotaDosenPembimbing2->save();
        $proposal->save();

        return back()->with([
            "success" => "Berhasil menyimpan perubahan!"
        ]);
    }
}
