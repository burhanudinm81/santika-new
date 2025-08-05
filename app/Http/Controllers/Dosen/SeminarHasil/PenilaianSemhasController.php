<?php

namespace App\Http\Controllers\Dosen\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\Revisi;
use App\Models\StatusProposal;
use Illuminate\Http\Request;

class PenilaianSemhasController extends Controller
{
    public function showInputPenilaianSementara($proposal_id)
    {
        $prevRevisi = null;

        $proposal = Proposal::findOrFail($proposal_id);
        $listMahasiswa = $proposal->proposalMahasiswas()->with(['dosen', 'mahasiswa'])->get();

        $listStatusPenilaian = StatusProposal::all();
        // dd($listMahasiswa[1]->mahasiswa->nama);

        $prevRevisi = Revisi::where('proposal_id', $proposal_id)
            ->where('jenis_revisi', 'semhas')
            ->get();

        if (count($prevRevisi) > 0) {
            $prevRevisi = Revisi::with('dosen')->where('proposal_id', $proposal_id)->where('dosen_id', auth('dosen')->user()->id)->first();
        } else {
            $prevRevisi = null;
        }

        return view('dosen.penilaian.semhas.penilaian-sementara-semhas', compact([
            'proposal',
            'listMahasiswa',
            'listStatusPenilaian',
            'prevRevisi'
        ]));
    }

    public function updatePenilaianSementara(Request $request)
    {
        // ambil value dari request
        $proposalId = $request->input('proposal_id');
        $dosenId = $request->input('dosen_id');
        $statusPenilaianSementara = $request->input('status_penilaian_sementara');
        $catatanRevisiAkhir = $request->input('catatan_revisi_akhir');

        // cek apakah revisi yang dibuat dosen saat ini sebelumnya sudah dibuat
        $prevRevisi = Revisi::where('proposal_id', $proposalId)
            ->where('dosen_id', $dosenId)
            ->where('jenis_revisi', 'semhas')
            ->first();
        // dd($prevRevisi);

        if ($prevRevisi == null) { //  jika null, artinya revisi belum dibuat
            // buat data revisi baru
            Revisi::create([
                'proposal_id' => $proposalId,
                'dosen_id' => $dosenId,
                'catatan_revisi' => $catatanRevisiAkhir,
                'jenis_revisi' => 'semhas',
            ]);
        } else {
            // update revisi sebelumnya yang sudah dibuat
            $prevRevisi->update([
                'catatan_revisi' => $catatanRevisiAkhir,
            ]);
        }

        return redirect()->back()->with('success', 'Penilaian Sementara Semhas berhasil disimpan.');
    }
}
