<?php

namespace App\Http\Controllers\Dosen\PermohonanJudul;

use App\Http\Controllers\Controller;
use App\Models\KuotaDosen;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use App\Models\StatusPendaftaranSeminar;
use Illuminate\Http\Request;

class PermohonanJudulController extends Controller
{
    public function showPermohonanPage()
    {
        // ambil list data permohonan dari mahasiswa D4
        $listPermohonanD4 = ProposalDosenMahasiswa::with(['mahasiswa', 'proposal', 'statusProposalMahasiswa'])
            ->where('dosen_id', auth('dosen')->user()->id)
            ->whereRelation('mahasiswa', 'prodi_id', 2)
            // ->where('status_proposal_mahasiswa_id', 3)
            ->get();


        // ambil list data permohonan dari mahasiswa D3
        $listPermohonanD3 = ProposalDosenMahasiswa::with(['mahasiswa', 'proposal', 'statusProposalMahasiswa'])
            ->where('dosen_id', auth('dosen')->user()->id)
            ->whereRelation('mahasiswa', 'prodi_id', 1)
            ->get();
        // meng-group data permohonan D3 sesuai proposal_id
        $groupedPermohonanD3 = $listPermohonanD3->groupBy('proposal_id');

        // dd($groupedPermohonanD3);

        // ambil kuota pembimbing dari dosen
        $kuotaPembimbing = KuotaDosen::where('dosen_id', auth('dosen')->user()->id)->first();

        return view('dosen.permohonan-judul', compact(['groupedPermohonanD3', 'listPermohonanD4', 'kuotaPembimbing']));
    }

    public function showDetailPermohonanPage($proposalId)
    {
        // ambil data permohonan dari proposal_id
        $permohonanProposalMahasiswa = ProposalDosenMahasiswa::with(['proposal', 'mahasiswa', 'statusProposalMahasiswa'])
            ->where('proposal_id', $proposalId)
            ->get();

        $prodiMahasiswa = $permohonanProposalMahasiswa->first()->mahasiswa->prodi_id;

        if ($prodiMahasiswa == 1) {
            // Jika Prodi D3 ambil kuota pembimbing 1 D3
            $kuotaPembimbing1 = KuotaDosen::select(['id', 'dosen_id', 'kuota_pembimbing_1_D3'])
                ->where('dosen_id', auth('dosen')->user()->id)
                ->first()
                ->kuota_pembimbing_1_D3;
        } elseif($prodiMahasiswa == 2){
            // Jika Prodi D4 ambil kuota pembimbing 1 D4
            $kuotaPembimbing1 = KuotaDosen::select(['id', 'dosen_id', 'kuota_pembimbing_1_D4'])
                ->where('dosen_id', auth('dosen')->user()->id)
                ->first()
                ->kuota_pembimbing_1_D4;
        } else{
            return redirect()->back()->withErrors(['prodi' => 'Prodi yang anda masukkan tidak valid']);
        }

        return view(
            'dosen.detail-permohonan-judul', 
            compact('permohonanProposalMahasiswa', 'kuotaPembimbing1')
        );
    }

    public function updatePermohonan(Request $request)
    {
        // ambil proposal_id dari request
        $proposalId = $request->proposal_id;
        // ambil status dari request
        $confirmationStatusId = $request->confirmation_status_id;

        // cari dan ambil proposal berdasarkan proposal_id
        $proposal = Proposal::findOrFail($proposalId);

        // jika prodi_id = 1, cari dan ambil proposal mahasiswa D3 berdasarkan proposal_id
        if ($proposal->prodi_id == 1) {
            $proposalMahasiswa = ProposalDosenMahasiswa::with('dosen')->where('proposal_id', $proposalId)->where('status_proposal_mahasiswa_id', 3)->get();
            // jika ada proposal mahasiswa D3 berdasarkan proposal_id
            if (count($proposalMahasiswa) > 0) {
                // update status_proposal_mahasiswa_id (di masing-masing mahasiswa)
                foreach ($proposalMahasiswa as $item) {
                    $item->update(['status_proposal_mahasiswa_id' => $confirmationStatusId]);
                }
            }
        } elseif ($proposal->prodi_id == 2) {
            // jika prodi_id = 2, cari dan ambil proposal mahasiswa D4 berdasarkan proposal_id
            $proposalMahasiswa = ProposalDosenMahasiswa::with('dosen')->where('proposal_id', $proposalId)->where('status_proposal_mahasiswa_id', 3)->first();
            // update status_proposal_mahasiswa_id (di mahasiswa D4)
            $proposalMahasiswa->update(attributes: ['status_proposal_mahasiswa_id' => $confirmationStatusId]);
        }

        $dataStatus = StatusPendaftaranSeminar::find($confirmationStatusId);

        Notifikasi::create([
            'mahasiswa_id' => $request->input('mahasiswa_id'),
            'keterangan' => sprintf("Pengajuan judul Anda telah %s.", $dataStatus->status),
        ]);

        // Logic Pengurangan Kuota Dosen
        if ($confirmationStatusId == "1") {
            $dosenId = auth('dosen')->user()->id;
            $kuotaDosen = KuotaDosen::firstWhere("dosen_id", $dosenId);

            // Id Prodi D3 = 1, Prodi D4 = 2
            if ($proposal->prodi_id == 1) {
                // Jika Prodi D3, kurangi kuota Pembimbing 1 D3
                $kuotaDosen->update(['kuota_pembimbing_1_D3' => $kuotaDosen->kuota_pembimbing_1_D3 - 1]);
            } else {
                // Jika Prodi D4, kurangi kuota Pembimbing 1 D4
                $kuotaDosen->update(['kuota_pembimbing_1_D4' => $kuotaDosen->kuota_pembimbing_1_D4 - 1]);
            }

            $proposal->update(attributes: [
                'dosen_pembimbing_1_id' => $dosenId,
            ]);
        }

        return redirect()->back()->with('success', 'Pengajuan Judul Berhasil Diupdate');
    }
}
