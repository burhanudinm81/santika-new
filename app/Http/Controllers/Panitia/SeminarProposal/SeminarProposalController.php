<?php

namespace App\Http\Controllers\Panitia\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Models\Panitia;
use App\Models\PendaftaranSeminarProposal;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\Revisi;
use App\Models\Tahap;
use Illuminate\Http\Request;

class SeminarProposalController extends Controller
{
    public function showBerandaPendaftaranPage()
    {
        // ambil semua data tahap
        $listTahap = Tahap::all();

        // menampilkan halaman beranda pendaftaran sempro
        return view('panitia.seminar-proposal.beranda-pendaftaran', compact('listTahap'));
    }

    public function showDetailPendaftaranPage($tahapId)
    {
        // ambil data tahap berdasarkan id
        $tahapInfo = Tahap::find($tahapId);

        // ambil semua data periode, untuk opsi dropdown
        $periodeInfo = Periode::all();

        // ambil data dosen yang menjadi panitia, berdasarkan id dosen yang saat ini sedang login
        $dosenPanitiaInfo = Panitia::where('dosen_id', auth('dosen')->user()->id)->first();

        // menampilkan halaman detail pendaftaran sempro
        return view('panitia.seminar-proposal.detail-pendaftaran', compact(['tahapInfo', 'periodeInfo', 'dosenPanitiaInfo']));
    }

    public function showVerifikasiPendaftaran($pendaftaranId)
    {

        // ambil data pendaftaran sempro berdasarkan id, dengan menyertakan relasi ke tabel dosen, mahasiswa, bidang_minat, dan status daftar sempro
        $pendaftaranSemproInfo = PendaftaranSeminarProposal::with([
            'proposal.proposalMahasiswas.dosen',
            'proposal.proposalMahasiswas.mahasiswa',
            'proposal.bidangMinat',
            'statusDaftarSempro'
        ])->where('id', $pendaftaranId)->first();

        // menampilkan halaman verifikasi pendaftaran sempro
        return view('panitia.seminar-proposal.verifikasi-pendaftaran', compact(['pendaftaranSemproInfo']));
    }

    public function updateVerifikasiPendaftaran(Request $request, $pendaftaranId)
    {
        // ambil input status verifikasi dari form, serta di ganti tipe datanya menjadi integer
        $statusProposal = (int) $request->input('statusProposal');
        $statusLembarKonsultasi = (int) $request->input('statusLembarKonsultasi');
        $statusLembarKerjasama = (int) $request->input('statusLembarKerjasama');
        $statusBuktiCekPlagiasi = (int) $request->input('statusBuktiCekPlagiasi');

        // ambil data pendaftaran sempro berdasarkan id
        $pendaftaranSempro = PendaftaranSeminarProposal::find($pendaftaranId);

        // update data verifikasi status file pendaftaran sempro
        $pendaftaranSempro->update([
            'status_file_proposal' => $statusProposal,
            'status_lembar_konsultasi' => $statusLembarKonsultasi,
            'status_lembar_kerjasama_mitra' => $statusLembarKerjasama,
            'status_bukti_cek_plagiasi' => $statusBuktiCekPlagiasi
        ]);

        // jika status verifikasi semua diterima, maka status sempro di update menjadi diterima
        if ($statusProposal == 1 && $statusLembarKonsultasi == 1 && $statusLembarKerjasama == 1 && $statusBuktiCekPlagiasi == 1) {
            $pendaftaranSempro->update([
                'status_daftar_sempro_id' => 1
            ]);
        } // jika status verifikasi semua ditolak, maka status sempro di update menjadi ditolak
        else if ($pendaftaranSempro->status_file_proposal == 0 && $pendaftaranSempro->status_lembar_konsultasi == 0 && $pendaftaranSempro->status_lembar_kerjasama_mitra == 0 && $pendaftaranSempro->status_bukti_cek_plagiasi == 0) {
            $pendaftaranSempro->update([
                'status_daftar_sempro_id' => 2
            ]);
        }

        // kembali ke halaman pendaftaran sempro dengan pesan sukses
        return redirect()->back()->with('success', 'Verifikasi Pendaftaran Sempro berhasil diupdate');
    }

    public function showTahapRekapNilai()
    {
        // ambil semua tahap
        $listTahap = Tahap::all();

        return view('panitia.seminar-proposal.tahap-rekap-nilai', compact('listTahap'));
    }

    public function showBerandaRekapNilai($tahapId)
    {
        $tahapInfo = Tahap::find($tahapId);

        // ambil semua data periode, untuk opsi dropdown
        $periodeInfo = Periode::all();

        // ambil data dosen yang menjadi panitia, berdasarkan id dosen yang saat ini sedang login
        $dosenPanitiaInfo = Panitia::where('dosen_id', auth('dosen')->user()->id)->first();

        return view('panitia.seminar-proposal.beranda-rekap-nilai', compact(['tahapInfo', 'periodeInfo', 'dosenPanitiaInfo']));
    }

    public function showDetailVerifikasiRevisi($proposalId)
    {
        $proposalInfo = Proposal::find($proposalId);
        $revisi1 = Revisi::where('proposal_id', $proposalInfo->id)
            ->where('dosen_id', $proposalInfo->dosenPengujiSempro1->id)
            ->first();
        $revisi2 = Revisi::where('proposal_id', $proposalInfo->id)
            ->where('dosen_id', $proposalInfo->dosenPengujiSempro2->id)
            ->first();

        return view('panitia.seminar-proposal.detail-verifikasi-revisi', compact(['proposalInfo', 'revisi1', 'revisi2']));
    }

    public function updateVerifikasiRevisi(Request $request)
    {
        $proposalId = $request->input('proposal_id');

        $revisiTotal = Revisi::where('proposal_id', $proposalId)->get();

        foreach ($revisiTotal as $revisi) {
            $revisi->update([
                'status' => $request->input('status_revisi')
            ]);
        }

        return redirect()->back()->with('success', 'Status Revisi Berhasil Diupdate');
    }
}
