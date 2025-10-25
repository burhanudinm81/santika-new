<?php

namespace App\Http\Controllers\Panitia\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Http\Requests\BukaPendaftaranRequest;
use App\Models\Panitia;
use App\Models\PendaftaranSeminarProposal;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\Notifikasi;
use App\Models\Revisi;
use App\Models\Tahap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeminarProposalController extends Controller
{
    public function showBerandaPendaftaranPage()
    {
        // ambil semua data tahap dan periode
        $listPeriode = Periode::all();
        $listTahap = Tahap::all();

        $periodeAktif = $listPeriode->firstWhere('aktif_sempro', true);
        $tahapAktif = $listTahap->firstWhere('aktif_sempro', true);

        $data = PendaftaranSeminarProposal::where('status_daftar_sempro_id', 3)
            ->whereHas('proposal', function ($query) use ($periodeAktif) {
                $query->where('periode_id', $periodeAktif->id);
            })
            ->join('proposal', 'pendaftaran_seminar_proposal.proposal_id', '=', 'proposal.id')
            ->select('proposal.tahap_id')
            ->groupBy('proposal.tahap_id')
            ->selectRaw('proposal.tahap_id, count(*) as jumlah')
            ->get();

        $listTahap = $listTahap->map(function ($tahap) use ($data) {
            $tahap->jumlahBelumVerifikasi = $data->firstWhere('tahap_id', $tahap->id)->jumlah ?? 0;
            return $tahap;
        });

        // menampilkan halaman beranda pendaftaran sempro
        return view('panitia.seminar-proposal.beranda-pendaftaran', compact('listPeriode', 'listTahap', 'periodeAktif', 'tahapAktif'));
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

        // Ambil Proposal
        $proposal = Proposal::find($pendaftaranSempro->proposal_id);

        // Jika Jenis Judul Mitra
        if ($proposal->jenis_judul_id == 2) {
            // jika status verifikasi semua diterima, maka status sempro di update menjadi diterima
            if ($statusProposal == 1 && $statusLembarKonsultasi == 1 && $statusLembarKerjasama == 1 && $statusBuktiCekPlagiasi == 1) {
                $pendaftaranSempro->update([
                    'status_daftar_sempro_id' => 1
                ]);

                // Notifikasi::create([
                //     'keterangan' => "Pendaftaran Seminar Proposal Anda Diterima",
                //     'mahasiswa_id' => null,
                // ]);
            } // jika status verifikasi semua ditolak, maka status sempro di update menjadi ditolak
            else if ($pendaftaranSempro->status_file_proposal == 0 && $pendaftaranSempro->status_lembar_konsultasi == 0 && $pendaftaranSempro->status_lembar_kerjasama_mitra == 0 && $pendaftaranSempro->status_bukti_cek_plagiasi == 0) {
                $pendaftaranSempro->update([
                    'status_daftar_sempro_id' => 2
                ]);
            }
        } else if ($proposal->jenis_judul_id == 1 || $proposal->jenis_judul_id == 3) {
            // Jika jenis judul bukan mitra

            // jika status verifikasi semua diterima (kecual lembar kerja sama mitra), maka status sempro di update menjadi diterima
            if ($statusProposal == 1 && $statusLembarKonsultasi == 1 && $statusBuktiCekPlagiasi == 1) {
                $pendaftaranSempro->update([
                    'status_daftar_sempro_id' => 1
                ]);
            } // jika status verifikasi semua ditolak (kecuali lembar kerja sama mitra), maka status sempro di update menjadi ditolak
            else if ($pendaftaranSempro->status_file_proposal == 0 && $pendaftaranSempro->status_lembar_konsultasi == 0 && $pendaftaranSempro->status_bukti_cek_plagiasi == 0) {
                $pendaftaranSempro->update([
                    'status_daftar_sempro_id' => 2
                ]);
            }
        }

        // kembali ke halaman pendaftaran sempro dengan pesan sukses
        return redirect()->back()->with('success', 'Verifikasi Pendaftaran Sempro berhasil diupdate');
    }

    public function showTahapRekapNilai()
    {
        // ambil semua tahap
        $listTahap = Tahap::all();

        // Menghitung jumlah peserta Seminar Proposal dikelompokkan berdasarkan jadwal
        $prodiPanitia = Panitia::where('dosen_id', auth('dosen')->user()->id)->first()->prodi_id;
        $periodeAktif = Periode::where('aktif_sempro', true)->first();

        $jumlahPesertaSempro = Proposal::where("periode_id", $periodeAktif->id)
            ->where('prodi_id', $prodiPanitia)
            ->whereHas('pendaftaranSempro', function ($query) {
                $query->where('status_daftar_sempro_id', 1); // Hanya yang diterima
            })
            ->groupBy('tahap_id')
            ->selectRaw('tahap_id, count(*) as jumlah')
            ->get();

        $listTahap = $listTahap->map(function ($tahap) use ($jumlahPesertaSempro) {
            $tahap->jumlahPeserta = $jumlahPesertaSempro->firstWhere('tahap_id', $tahap->id)->jumlah ?? 0;
            return $tahap;
        });

        return view('panitia.seminar-proposal.tahap-rekap-nilai', compact('listTahap', 'periodeAktif'));
    }

    public function showBerandaRekapNilai($tahapId)
    {
        $tahapInfo = Tahap::find($tahapId);

        // ambil semua data periode, untuk opsi dropdown
        $periodeInfo = Periode::all();

        // ambil data dosen yang menjadi panitia, berdasarkan id dosen yang saat ini sedang login
        $dosenPanitiaInfo = Panitia::where('dosen_id', auth('dosen')->user()->id)->first();

        $periodeAktif = Periode::where('aktif_sempro', true)->first();
        $visibilitasNilai = $tahapInfo->visibilitasNilai()->where('periode_id', $periodeAktif->id)
            ->where('jenis_nilai_seminar', 1) // 1 = Seminar Proposal
            ->first()
            ->visibilitas ?? false;

        return view(
            'panitia.seminar-proposal.beranda-rekap-nilai',
            compact(['tahapInfo', 'periodeInfo', 'dosenPanitiaInfo', 'periodeAktif', 'visibilitasNilai'])
        );
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

        $revisiTotal = Revisi::where('proposal_id', $proposalId)
            ->where('jenis_revisi', 'sempro')
            ->get();

        foreach ($revisiTotal as $revisi) {
            $revisi->update([
                'status' => $request->input('status_revisi')
            ]);
        }

        return redirect()->back()->with('success', 'Status Revisi Berhasil Diupdate');
    }

    public function bukaPendaftaran(BukaPendaftaranRequest $request)
    {
        $data = $request->validated();

        $result = DB::transaction(function () use ($data) {
            $periode = Periode::findOrFail($data['periode_id']);
            $tahap = Tahap::findOrFail($data['tahap_id']);

            // Menutup Pendaftaran Periode dan Tahap sebelumnya
            // Menonaktifkan periode dan tahap sebelumnya
            Periode::where('aktif_sempro', true)
                ->update(['aktif_sempro' => false]);

            Tahap::where('aktif_sempro', true)
                ->update(["aktif_sempro" => false]);

            // Mengaktifkan Periode dan Tahap Tertentu
            $periode->aktif_sempro = true;
            $periode->save();

            $tahap->aktif_sempro = true;
            $tahap->save();

            Notifikasi::create([
                'keterangan' => "Pendaftaran Seminar Proposal Periode $periode->tahun Tahap $tahap->tahap Telah Dibuka"
            ]);

            return [
                'tahun' => $periode->tahun,
                'tahap' => $tahap->tahap,
            ];
        });

        return back()->with([
            'success' => sprintf("Berhasil membuka Pendaftaran Seminar Proposal Periode %s, Tahap %s!", $result['tahun'], $result['tahap'])
        ]);
    }

    public function tutupPendaftaran(BukaPendaftaranRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $periode = Periode::findOrFail($data['periode_id']);
            $tahap = Tahap::findOrFail($data['tahap_id']);

            Periode::where('aktif_sempro', true)
                ->update(['aktif_sempro' => false]);

            Tahap::where('aktif_sempro', true)
                ->update(["aktif_sempro" => false]);

            Notifikasi::create([
                'keterangan' => "Pendaftaran Seminar Proposal Periode $periode->tahun Tahap $tahap->tahap Telah Ditutup"
            ]);
        });

        return back()->with([
            'success' => "Berhasil menutup Pendaftaran Seminar Proposal"
        ]);
    }
}
