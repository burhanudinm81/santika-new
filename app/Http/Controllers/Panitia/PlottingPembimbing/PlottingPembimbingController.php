<?php

namespace App\Http\Controllers\Panitia\PlottingPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\KuotaDosen;
use App\Models\Periode;
use App\Models\Proposal;
use Illuminate\Http\Request;

class PlottingPembimbingController extends Controller
{
    // Membuka halaman plotting pembimbing
    public function index()
    {
        $periodeAktif = Periode::where('aktif_sempro', 1)->first();

        $listProposalD3 = Proposal::where('prodi_id', 1)
            ->where('periode_id', $periodeAktif->id)
            ->where(function ($query) {
                $query->where('status_sempro_proposal_id', 1)           // Status proposal yang diterima tanpa revisi
                    ->orWhere('status_sempro_proposal_id', 2);        // Status proposal yang diterima dengan revisi
            })
            ->with(['proposalMahasiswas.mahasiswa', 'dosenPembimbing1', 'dosenPembimbing2'])
            ->get();

        $listProposalD4 = Proposal::where('prodi_id', 2)
            ->where('periode_id', $periodeAktif->id)
            ->where(function ($query) {
                $query->where('status_sempro_proposal_id', 1)           // Status proposal yang diterima tanpa revisi
                    ->orWhere('status_sempro_proposal_id', 2);        // Status proposal yang diterima dengan revisi
            })
            ->with(['proposalMahasiswas.mahasiswa', 'dosenPembimbing1', 'dosenPembimbing2'])
            ->get();

        $asDosbing2CountD3 = Proposal::where('prodi_id', 1)
            ->where('periode_id', $periodeAktif->id)
            ->whereNotNull('dosen_pembimbing_2_id')
            ->groupBy('dosen_pembimbing_2_id')
            ->select('dosen_pembimbing_2_id', \DB::raw('count(*) as count'))
            ->pluck('count', 'dosen_pembimbing_2_id')
            ->toArray();
        $asDosbing2CountD4 = Proposal::where('prodi_id', 2)
            ->where('periode_id', $periodeAktif->id)
            ->whereNotNull('dosen_pembimbing_2_id')
            ->groupBy('dosen_pembimbing_2_id')
            ->select('dosen_pembimbing_2_id', \DB::raw('count(*) as count'))
            ->pluck('count', 'dosen_pembimbing_2_id')
            ->toArray();

        $listDosen = Dosen::all()->map(function($dosen) use ($asDosbing2CountD3, $asDosbing2CountD4){
            $dosen->dosbing2_count_d3 = $asDosbing2CountD3[$dosen->id] ?? 0;
            $dosen->dosbing2_count_d4 = $asDosbing2CountD4[$dosen->id] ?? 0;
            return $dosen;
        });

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

        if ($dosenPembimbing1Id != $proposal->dosen_pembimbing_1_id) {
            // Mengubah Dosen Pembimbing 1
            $proposal->dosen_pembimbing_1_id = $dosenPembimbing1Id;

            if ($prodiId == 1) {
                if ($kuotaDosenPembimbing1->kuota_pembimbing_1_D3 <= 0) {
                    return back()->withErrors(['error' => 'Kuota pembimbing D3 untuk dosen ini sudah habis.']);
                } else {
                    // Mengurangi Kuota Dosen Pembimbing 1 D3
                    $kuotaDosenPembimbing1->kuota_pembimbing_1_D3--;
                }
            } elseif ($prodiId == 2) {
                if ($kuotaDosenPembimbing1->kuota_pembimbing_1_D4 <= 0) {
                    return back()->withErrors(['error' => 'Kuota pembimbing D4 untuk dosen ini sudah habis.']);
                } else {
                    // Mengurangi Kuota Dosen Pembimbing 1 D4
                    $kuotaDosenPembimbing1->kuota_pembimbing_1_D4--;
                }
            }
        }

        if ($dosenPembimbing2Id != $proposal->dosen_pembimbing_2_id) {
            // Mengubah Dosen Pembimbing 2
            $proposal->dosen_pembimbing_2_id = $dosenPembimbing2Id;

        }

        $kuotaDosenPembimbing1->save();
        $proposal->save();

        return back()->with([
            "success" => "Berhasil menyimpan perubahan!"
        ]);
    }
}
