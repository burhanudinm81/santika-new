<?php

namespace App\Http\Controllers\Mahasiswa\Logbook;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLogbookRequest;
use App\Models\Dosen;
use App\Models\JenisKegiatanLogbook;
use App\Models\LogBook;
use App\Models\Proposal;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function showBeranda($roleDospem)
    {
        // inisiasi variabel awal, di awal diisi kosong/null dulu
        $proposalInfo = null;
        $dospem1Info = null;
        $logbooksDospem1 = null;
        $dospem2Info = null;
        $logbooksDospem2 = null;


        // ambil data proposal yang sudah di acc dosen ketika pengajuan judul
        $proposalInfo = Proposal::with('proposalMahasiswas')
            // cari proposal yang sesuai dengan mahasiswa yang login
            ->whereRelation('proposalMahasiswas', 'mahasiswa_id', auth('mahasiswa')->user()->id)
            // cari proposal yang sudah di acc dosen
            ->whereRelation('proposalMahasiswas', 'status_proposal_mahasiswa_id', 1)
            // cari proposal yang sudah mendaftar seminar proposal
            ->where('pendaftaran_sempro_id', '!=', null)
            ->first();

        if ($proposalInfo != null && $roleDospem == 1) {
            $dospem1Info = $proposalInfo->dosenPembimbing1()->first();
            $logbooksDospem1 = LogBook::with('JenisKegiatanLogbook')->where('mahasiswa_id', auth('mahasiswa')->user()->id)
                ->where('dosen_id', $dospem1Info->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else if ($proposalInfo != null && $roleDospem == 2) {
            $dospem2Info = $proposalInfo->dosenPembimbing2()->first();
            $logbooksDospem2 = LogBook::with('JenisKegiatanLogbook')->where('mahasiswa_id', auth('mahasiswa')->user()->id)
                ->where('dosen_id', $dospem2Info->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('mahasiswa.logbook.beranda-logbook', compact(['roleDospem', 'dospem1Info', 'dospem2Info', 'proposalInfo', 'logbooksDospem1', 'logbooksDospem2']));
    }

    public function showTambahLogbookPage($roleDospem)
    {
        // Cek apakah role dospem adalah 1 atau 2
        if ($roleDospem != 1 && $roleDospem != 2) {
            abort(404); // Jika tidak, tampilkan halaman 404
        }

        // inisiasi variabel awal, di awal diisi kosong/null dulu
        $proposalInfo = null;
        $dospem1Info = null;
        $dospem2Info = null;

        // ambil data proposal yang sudah di acc dosen ketika pengajuan judul
        $proposalInfo = Proposal::with('proposalMahasiswas')
            // cari proposal yang sesuai dengan mahasiswa yang login
            ->whereRelation('proposalMahasiswas', 'mahasiswa_id', auth('mahasiswa')->user()->id)
            // cari proposal yang sudah di acc dosen
            ->whereRelation('proposalMahasiswas', 'status_proposal_mahasiswa_id', 1)
            // cari proposal yang sudah mendaftar seminar proposal
            ->where('pendaftaran_sempro_id', '!=', null)
            ->first();

        if ($proposalInfo != null && $roleDospem == 1) {
            $dospem1Info = $proposalInfo->dosenPembimbing1()->first();
        } else if ($proposalInfo != null && $roleDospem == 2) {
            $dospem2Info = $proposalInfo->dosenPembimbing2()->first();
        }

        // ambil data jenis kegiatan logbook
        $jenisKegiatanLogbook = JenisKegiatanLogbook::all();

        return view('mahasiswa.logbook.tambah-logbook', compact(['roleDospem', 'dospem1Info', 'dospem2Info', 'jenisKegiatanLogbook']));
    }

    public function storeLogbook(StoreLogbookRequest $request)
    {
        $dosenId = (int) $request->dosenPembimbingId;
        $mahasiswaId = (int) $request->mahasiswaId;
        $jenisKegiatanId = (int) $request->validated()['jenisKegiatanId'];
        $namaKegiatan = $request->validated()['namaKegiatan'];
        $tanggalKegiatan = $request->validated()['tanggalKegiatan'];
        $hasilKegiatan = $request->validated()['hasilKegiatan'];
        $statusVerifKegiatan = (int) $request->statusVerifKegiatan;

        LogBook::create([
            'dosen_id'=> $dosenId,
            'mahasiswa_id'=> $mahasiswaId,
            'jenis_kegiatan_id'=> $jenisKegiatanId,
            'nama_kegiatan'=> $namaKegiatan,
            'tanggal_kegiatan'=> $tanggalKegiatan,
            'hasil_kegiatan'=> $hasilKegiatan,
            'status_verifikasi'=> $statusVerifKegiatan,
        ]);

        return redirect()->back()->with('success', 'Logbook berhasil ditambahkan');
    }

    public function showDetailLogbook(LogBook $logbook)
    {
        // Cek apakah logbook milik mahasiswa yang sedang login
        if ($logbook->mahasiswa_id != auth('mahasiswa')->user()->id) {
            abort(403); // Jika tidak, tampilkan halaman 403
        }

        return view('mahasiswa.logbook.detail-logbook', compact('logbook'));
    }

    public function deleteLogbook(LogBook $logbook)
    {
        $logbook->delete();

        return redirect()->back()->with('success', 'Logbook berhasil dihapus');
    }
}
