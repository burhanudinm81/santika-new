<?php

namespace App\Http\Controllers\Panitia\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\Panitia;
use App\Models\PendaftaranSemhas;
use App\Models\Periode;
use App\Models\Tahap;
use Illuminate\Http\Request;

class SeminarHasilPanitiaController extends Controller
{
    public function showBerandaPendaftaranPage()
    {
        // ambil semua data tahap
        $listTahap = Tahap::all();

        return view('panitia.seminar-hasil.beranda-pendaftaran', compact('listTahap'));
    }

    public function showDetailPendaftaranPage($tahapId)
    {
        $tahapInfo = Tahap::find($tahapId);

        // ambil semua data periode, untuk opsi dropdown
        $periodeInfo = Periode::all();

        // ambil data dosen yang menjadi panitia, berdasarkan id dosen yang saat ini sedang login
        $dosenPanitiaInfo = Panitia::where('dosen_id', auth('dosen')->user()->id)->first();

        // menampilkan halaman detail pendaftaran sempro
        return view('panitia.seminar-hasil.detail-pendaftaran', compact(['tahapInfo', 'periodeInfo', 'dosenPanitiaInfo']));
    }

    public function showVerifikasiPendaftaran($pendaftaranId)
    {

        // ambil data pendaftaran sempro berdasarkan id, dengan menyertakan relasi ke tabel dosen, mahasiswa, bidang_minat, dan status daftar sempro
        $pendaftaranSemhasInfo = PendaftaranSemhas::with([
            'proposal.proposalMahasiswas.dosen',
            'proposal.proposalMahasiswas.mahasiswa',
            'proposal.bidangMinat',
            'statusDaftarSeminar'
        ])->where('id', $pendaftaranId)->first();

        // menampilkan halaman verifikasi pendaftaran sempro
        return view('panitia.seminar-hasil.verifikasi-pendaftaran', compact(['pendaftaranSemhasInfo']));
    }

    public function updateVerifikasiPendaftaran(Request $request, $pendaftaranId)
    {
        $statusRekomDospem = (int) $request->input('statusRekomDospem');
        $statusProposalSemhas = (int) $request->input('statusProposalSemhas');
        $statusDraftJurnal = (int) $request->input('statusDraftJurnal');
        $statusBebasTanggunganPKL = (int) $request->input('statusBebasTanggunganPkl');
        $statusSKLA = (int) $request->input('statusSKLA');

        // ambil data pendaftaran sempro berdasarkan id
        $pendaftaranSemhas = PendaftaranSemhas::find($pendaftaranId);

        $pendaftaranSemhas->update([
            'status_file_rekom_dosen' =>  $statusRekomDospem,
            'status_file_proposal_semhas' => $statusProposalSemhas,
            'status_file_draft_jurnal' =>  $statusDraftJurnal,
            'status_file_bebas_tanggungan_pkl' => $statusBebasTanggunganPKL,
            'status_file_skla' => $statusSKLA
        ]);

        // jika status verifikasi semua diterima, maka status sempro di update menjadi diterima
        if ($statusRekomDospem == 1 && $statusProposalSemhas == 1 && $statusDraftJurnal == 1 && $statusBebasTanggunganPKL == 1 && $statusSKLA == 1) {
            $pendaftaranSemhas->update([
                'status_daftar_semhas_id' => 1
            ]);
        } else if ($pendaftaranSemhas->status_file_rekom_dospem == 0 && $pendaftaranSemhas->status_file_proposal_semhas == 0 && $pendaftaranSemhas->status_file_draft_jurnal == 0 && $pendaftaranSemhas->status_file_bebas_tanggungan_pkl == 0 && $pendaftaranSemhas->status_skla == 0) {
            $pendaftaranSemhas->update([
                'status_daftar_semhas_id' => 2
            ]);
        }

        // kembali ke halaman pendaftaran sempro dengan pesan sukses
        return redirect()->back()->with('success', 'Verifikasi Pendaftaran semhas berhasil diupdate');
    }
}
