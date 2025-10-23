<?php

namespace App\Http\Controllers\Panitia\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Http\Requests\BukaPendaftaranRequest;
use App\Models\NilaiAkhirMahasiswa;
use App\Models\Panitia;
use App\Models\PendaftaranSemhas;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\Revisi;
use App\Models\Tahap;
use Illuminate\Http\Request;

class SeminarHasilPanitiaController extends Controller
{
    public function showBerandaPendaftaranPage()
    {
        // ambil semua data tahap
        $listPeriode = Periode::all();
        $listTahap = Tahap::all();

        $periodeAktif = $listPeriode->firstWhere('aktif_sidang_akhir', true);
        $tahapAktif = $listTahap->firstWhere('aktif_sidang_akhir', true);

        return view(
            'panitia.seminar-hasil.beranda-pendaftaran',
            compact('listPeriode', 'listTahap', 'periodeAktif', 'tahapAktif')
        );
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

    public function bukaPendaftaran(BukaPendaftaranRequest $request)
    {
        $periodeId = (int) $request->periode_id;
        $tahapId = (int) $request->tahap_id;

        $periode = Periode::findOrFail($periodeId);
        $tahap = Tahap::findOrFail($tahapId);

        // Menutup Pendaftaran Periode dan Tahap sebelumnya
        // Menonaktifkan periode dan tahap sebelumnya
        $periodeAktifSidangTA = Periode::where('aktif_sidang_akhir', true)
            ->update(['aktif_sidang_akhir' => false]);

        $tahapAktifSidangTA = Tahap::where('aktif_sidang_akhir', true)
            ->update(["aktif_sidang_akhir" => false]);

        // Mengaktifkan Periode dan Tahap Tertentu
        $periode->aktif_sidang_akhir = true;
        $tahap->aktif_sidang_akhir = true;

        $periode->save();
        $tahap->save();

        return back()->with([
            'success' => "Berhasil membuka Pendaftaran Sidang Ujian Akhir Periode $periode->tahun, Tahap $tahap->tahap!"
        ]);
    }

    public function tutupPendaftaran()
    {
        $periodeAktifSidangTA = Periode::where('aktif_sidang_akhir', true)
            ->update(['aktif_sidang_akhir' => false]);

        $tahapAktifSidangTA = Tahap::where('aktif_sidang_akhir', true)
            ->update(["aktif_sidang_akhir" => false]);

        return back()->with([
            'success' => "Berhasil menutup Pendaftaran Sidang Ujian Akhir!"
        ]);
    }

    public function showTahapRekapNilai()
    {
        // ambil semua tahap
        $listTahap = Tahap::all();

        return view('panitia.seminar-hasil.tahap-rekap-nilai', compact('listTahap'));
    }

    public function showBerandaRekapNilai($tahapId)
    {
        $tahapInfo = Tahap::find($tahapId);

        // ambil semua data periode, untuk opsi dropdown
        $periodeInfo = Periode::all();

        // ambil data dosen yang menjadi panitia, berdasarkan id dosen yang saat ini sedang login
        $dosenPanitiaInfo = Panitia::where('dosen_id', auth('dosen')->user()->id)->first();

        return view('panitia.seminar-hasil.beranda-rekap-nilai', compact(['tahapInfo', 'periodeInfo', 'dosenPanitiaInfo']));
    }

    public function showDetailVerifikasiRevisi($proposalId)
    {
        $proposalInfo = Proposal::find($proposalId);
        $revisi1 = Revisi::where('proposal_id', $proposalInfo->id)
            ->where('dosen_id', $proposalInfo->dosenPengujiSidangTA1->id)
            ->where('jenis_revisi', 'semhas')
            ->first();

        $revisi2 = Revisi::where('proposal_id', $proposalInfo->id)
            ->where('dosen_id', $proposalInfo->dosenPengujiSidangTA2->id)
            ->where('jenis_revisi', 'semhas')
            ->first();

        return view('panitia.seminar-hasil.detail-verifikasi-revisi', compact(['proposalInfo', 'revisi1', 'revisi2']));
    }

    public function updateVerifikasiRevisi(Request $request)
    {
        $proposalId = $request->input('proposal_id');

        $revisiTotal = Revisi::where('proposal_id', $proposalId)
            ->where('jenis_revisi', 'semhas')
            ->get();

        foreach ($revisiTotal as $revisi) {
            $revisi->update([
                'status' => $request->input('status_revisi')
            ]);
        }

        return redirect()->back()->with('success', 'Status Revisi Berhasil Diupdate');
    }

    public function showTahapRekapNilaiAkhir()
    {
        // ambil semua tahap
        $listTahap = Tahap::all();

        return view('panitia.seminar-hasil.tahap-rekap-nilai-akhir', compact('listTahap'));
    }

    public function showBerandaRekapNilaiAkhir($tahapId)
    {
        $tahapInfo = Tahap::find($tahapId);

        // ambil semua data periode, untuk opsi dropdown
        $periodeInfo = Periode::all();

        // ambil data dosen yang menjadi panitia, berdasarkan id dosen yang saat ini sedang login
        $dosenPanitiaInfo = Panitia::where('dosen_id', auth('dosen')->user()->id)->first();

        return view('panitia.seminar-hasil.beranda-rekap-nilai-akhir', compact(['tahapInfo', 'periodeInfo', 'dosenPanitiaInfo']));
    }

    public function showDetailNilai(Request $request, $proposalId)
    {
        $proposalInfo = Proposal::find($proposalId);
        $nilaiAkhir = NilaiAkhirMahasiswa::where('proposal_id', $proposalId)->where('mahasiswa_id', $request->id)->first();

        return view('panitia.seminar-hasil.detail-nilai', compact('proposalInfo', 'nilaiAkhir'));
    }

    public function updateNilai(Request $request, $id)
    {
        $validated = $request->validate([
            'nilai_sikap_pemb1' => 'required|numeric|min:0|max:100',
            'nilai_kemampuan_pemb1' => 'required|numeric|min:0|max:100',
            'nilai_hasilKarya_pemb1' => 'required|numeric|min:0|max:100',
            'nilai_laporan_pemb1' => 'required|numeric|min:0|max:100',

            'nilai_sikap_pemb2' => 'required|numeric|min:0|max:100',
            'nilai_kemampuan_pemb2' => 'required|numeric|min:0|max:100',
            'nilai_hasilKarya_pemb2' => 'required|numeric|min:0|max:100',
            'nilai_laporan_pemb2' => 'required|numeric|min:0|max:100',

            'nilai_penguasaan_materi1' => 'required|numeric|min:0|max:100',
            'nilai_presentasi1' => 'required|numeric|min:0|max:100',
            'nilai_karya_tulis1' => 'required|numeric|min:0|max:100',

            'nilai_penguasaan_materi2' => 'required|numeric|min:0|max:100',
            'nilai_presentasi2' => 'required|numeric|min:0|max:100',
            'nilai_karya_tulis2' => 'required|numeric|min:0|max:100',
        ]);

        $nilaiAkhir = NilaiAkhirMahasiswa::findOrFail($id);

        $avg_dospem1 = (
            $validated['nilai_sikap_pemb1'] +
            $validated['nilai_kemampuan_pemb1'] +
            $validated['nilai_hasilKarya_pemb1'] +
            $validated['nilai_laporan_pemb1']
        ) / 4;

        $avg_dospem2 = (
            $validated['nilai_sikap_pemb2'] +
            $validated['nilai_kemampuan_pemb2'] +
            $validated['nilai_hasilKarya_pemb2'] +
            $validated['nilai_laporan_pemb2']
        ) / 4;

        $avg_penguji1 = (
            $validated['nilai_penguasaan_materi1'] +
            $validated['nilai_presentasi1'] +
            $validated['nilai_karya_tulis1']
        ) / 3;

        $avg_penguji2 = (
            $validated['nilai_penguasaan_materi2'] +
            $validated['nilai_presentasi2'] +
            $validated['nilai_karya_tulis2']
        ) / 3;

        $avg_total_dospem = ($avg_dospem1 + $avg_dospem2) / 2;
        $avg_total_penguji = ($avg_penguji1 + $avg_penguji2) / 2;

        $nilaiAkhir->update([
            'nilai_sikap_pemb1' => $validated['nilai_sikap_pemb1'],
            'nilai_kemampuan_pemb1' => $validated['nilai_kemampuan_pemb1'],
            'nilai_hasilKarya_pemb1' => $validated['nilai_hasilKarya_pemb1'],
            'nilai_laporan_pemb1' => $validated['nilai_laporan_pemb1'],
            'avg_nilai_dospem1' => $avg_dospem1,
            'nilai_sikap_pemb2' => $validated['nilai_sikap_pemb2'],
            'nilai_kemampuan_pemb2' => $validated['nilai_kemampuan_pemb2'],
            'nilai_hasilKarya_pemb2' => $validated['nilai_hasilKarya_pemb2'],
            'nilai_laporan_pemb2' => $validated['nilai_laporan_pemb2'],
            'avg_nilai_dospem2' => $avg_dospem2,
            'nilai_penguasaan_materi1' => $validated['nilai_penguasaan_materi1'],
            'nilai_presentasi1' => $validated['nilai_presentasi1'],
            'nilai_karya_tulis1' => $validated['nilai_karya_tulis1'],
            'avg_nilai_penguji1' => $avg_penguji1,
            'nilai_penguasaan_materi2' => $validated['nilai_penguasaan_materi2'],
            'nilai_presentasi2' => $validated['nilai_presentasi2'],
            'nilai_karya_tulis2' => $validated['nilai_karya_tulis2'],
            'avg_nilai_penguji2' => $avg_penguji2,
            'avg_nilai_totalDospem' => $avg_total_dospem,
            'avg_nilai_totalPenguji' => $avg_total_penguji,
        ]);

        return redirect()->back()->with('success', 'Nilai Akhir Berhasil Diupdate');
    }
}
