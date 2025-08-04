<?php

namespace App\Http\Controllers\Dosen\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\Revisi;
use App\Models\StatusProposal;
use Illuminate\Http\Request;

class PenilaianSemproController extends Controller
{
    public function showPenilaianBaseOnMahasiswa($proposal_id)
    {

        $prevRevisi = null;

        $proposal = Proposal::findOrFail($proposal_id);
        $listMahasiswa = $proposal->proposalMahasiswas()->with(['dosen', 'mahasiswa'])->get();

        $listStatusPenilaian = StatusProposal::all();
        // dd($listMahasiswa[1]->mahasiswa->nama);

        $prevRevisi = Revisi::where('proposal_id', $proposal_id)->get();

        if (count($prevRevisi) > 0) {
            $prevRevisi = Revisi::with('dosen')->where('proposal_id', $proposal_id)->where('dosen_id', auth('dosen')->user()->id)->first();
        } else {
            $prevRevisi = null;
        }

        return view('dosen.penilaian.sempro.penilaian-sempro', compact([
            'proposal',
            'listMahasiswa',
            'listStatusPenilaian',
            'prevRevisi'
        ]));
    }

    public function updatePenilaian(Request $request)
    {
        // ambil value dari request
        $proposalId = $request->input('proposal_id');
        $dosenId = $request->input('dosen_id');
        $statusPenilaian = $request->input('status_penilaian');
        $catatanRevisi = $request->input('catatan_revisi');

        // cek apakah revisi yang dibuat dosen saat ini sebelumnya sudah dibuat
        $prevRevisi = Revisi::where('proposal_id', $proposalId)->where('dosen_id', $dosenId)->first();
        // dd($prevRevisi);

        if ($prevRevisi == null) { //  jika null, artinya revisi belum dibuat
            // buat data revisi baru
            Revisi::create([
                'proposal_id' => $proposalId,
                'dosen_id' => $dosenId,
                'catatan_revisi' => $catatanRevisi,
            ]);
        } else {
            // update revisi sebelumnya yang sudah dibuat
            $prevRevisi->update([
                'catatan_revisi' => $catatanRevisi,
            ]);
        }

        // cek dosen yang sekarang mengisi revisi itu sebagai dospem 1 atau 2
        $levelDospem = 0;
        $proposalInfo = Proposal::findOrFail($proposalId);

        if ($proposalInfo->penguji_sempro_1_id == auth('dosen')->user()->id) { // pengecekan apakah dosen yang sekarang mengisi revisi itu adalah dospem 1
            $levelDospem = 1;
        } else if ($proposalInfo->penguji_sempro_2_id == auth('dosen')->user()->id) { // pengecekan apakah dosen yang sekarang mengisi revisi itu adalah dospem 2
            $levelDospem = 2;
        }

        if ($levelDospem != 0) { // update status penilaian sempro berdasarkan dosen penguji (penguji 1 atau 2)
            if ($levelDospem == 1) {
                $proposalInfo->update([
                    'penguji_sempro_1_id' => auth('dosen')->user()->id,
                    'status_sempro_penguji_1_id' => $statusPenilaian,
                ]);
            } else if ($levelDospem == 2) {
                $proposalInfo->update([
                    'penguji_sempro_2_id' => auth('dosen')->user()->id,
                    'status_sempro_penguji_2_id' => $statusPenilaian,
                ]);
            }
        }

        if ($proposalInfo->status_sempro_penguji_1_id != null && $proposalInfo->status_sempro_penguji_2_id != null) {
            if ($proposalInfo->status_sempro_penguji_1_id == 3 || $proposalInfo->status_sempro_penguji_2_id == 3) {
                $proposalInfo->update(['status_sempro_proposal_id' => 3]);
            } else if ($proposalInfo->status_sempro_penguji_1_id == 2 || $proposalInfo->status_sempro_penguji_2_id == 2) {
                $proposalInfo->update(['status_sempro_proposal_id' => 2]);
            } else if ($proposalInfo->status_sempro_penguji_1_id == 1 || $proposalInfo->status_sempro_penguji_2_id == 1) {
                $proposalInfo->update(['status_sempro_proposal_id' => 1]);
            }
        }

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
    }
}
