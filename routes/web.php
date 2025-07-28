<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen\SeminarProposal\JadwalSemproController as JadwalSemproDosenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dosen\Bimbingan\BimbinganController;
use App\Http\Controllers\KuotaDosenController;
use App\Http\Controllers\Dosen\PermohonanJudul\PermohonanJudulController;
use App\Http\Controllers\Mahasiswa\Ajax\AjaxMahasiswaController;
use App\Http\Controllers\Mahasiswa\InformasiDosen\DaftarDosenPembimbingController;
use App\Http\Controllers\Mahasiswa\Logbook\LogbookController;
use App\Http\Controllers\Mahasiswa\PengajuanJudul\PengajuanJudulController;
use App\Http\Controllers\Mahasiswa\SeminarHasil\SeminarHasilController;
use App\Http\Controllers\Mahasiswa\SeminarProposal\SeminarProposalController;
use App\Http\Controllers\Mahasiswa\SeminarProposal\JadwalSemproController as JadwalSemproMahasiswaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaD3Controller;
use App\Http\Controllers\MahasiswaD4Controller;
use App\Http\Controllers\Panitia\Ajax\AjaxPendaftaranSemproController;
use App\Http\Controllers\Panitia\PlottingPembimbing\PlottingPembimbingController;
use App\Http\Controllers\Panitia\SeminarHasil\SeminarHasilPanitiaController;
use App\Http\Controllers\Panitia\SeminarProposal\JadwalSemproController as JadwalSemproPanitiaController;
use App\Http\Controllers\Panitia\SeminarProposal\SeminarProposalController as SeminarProposalPanitiaController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\PrivateFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenProfileController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route testing
Route::get("/info-session", function (Request $request) {
    dd($request->session()->all());
});

// Route untuk me-redirect request ke path "/"
Route::get("/", function () {
    // Jika ada session "role", redirect ke halaman sesuai role
    if (session()->has("role")) {
        if (session()->get("role") === "admin-prodi") {
            return redirect()->route("admin-prodi.home");
        } elseif (session()->get("role") === "mahasiswa") {
            return redirect()->route("mahasiswa.home");
        } elseif (session()->get("role") === "dosen") {
            return redirect()->route("dosen.home");
        }
    }

    return redirect("/login");
});

/**
 * Route yang hanya bisa diakses oleh Guest (Pengguna yang tidak terautentikasi)
 */
Route::middleware("guest:admin-prodi,mahasiswa,dosen")->group(function () {



    Route::controller(LoginController::class)->group(function () {
        // Route untuk menampilkan halaman login
        Route::get("/login", "showLoginPage")->name("login");

        // Route untuk memproses informasi login
        Route::post("/login", "handleLogin")->name("login.auth");
    });
});

/**
 * Route yang memerlukan pengguna untuk terautentikasi,
 * Entah sebagai Admin Prodi, Mahasiswa, atau Dosen
 */
Route::middleware('auth:admin-prodi,mahasiswa,dosen')->group(function () {
    // Route untuk Logout
    Route::get("/logout", LogoutController::class)->name("logout");

    // Route untuk menampilkan form ganti password
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])
        ->name('password.change.form');

    // Route untuk ganti password
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])
        ->name('password.change.submit');
});

/**
 * Route untuk user yang terautentikasi sebagai Admin Prodi
 */
Route::middleware(["auth:admin-prodi", "auth.session"])->group(function () {
    Route::controller(HomePageController::class)->group(function () {
        // Route untuk memuat halaman awal user Admin Prodi
        Route::get("/admin-prodi/home", "adminProdi")
            ->name("admin-prodi.home");
    });

    Route::controller(DashboardController::class)->group(function () {
        // Route untuk menampilkan Dashboard Admin Prodi
        Route::get("/admin-prodi/dashboard", "showDashboardPage")
            ->name("admin-prodi.dashboard");
    });

    Route::controller(MahasiswaD3Controller::class)->group(function () {
        // Route untuk menampilkan Halaman Mahasiswa D3 TT
        Route::get("/admin-prodi/mahasiswa/d3/page", "showMahasiswaPage")
            ->name("admin-prodi.mahasiswa.d3.page");

        // Route untuk mengambil Data Semua Mahasiswa D3 TT
        Route::get("/admin-prodi/mahasiswa/d3", "showAllMahasiswa")
            ->name("admin-prodi.mahasiswa.d3");

        // Route untuk pencarian Data Mahasiswa D3 TT berdasarkan nama atau NIM
        Route::get("/admin-prodi/mahasiswa/d3/search", "searchMahasiswa")
            ->name("admin-prodi.mahasiswa.d3.search");

        // Route untuk impor data Mahasiswa D3 TT menggunakan data Excel
        Route::post("/admin-prodi/mahasiswa/d3/import", "importMahasiswa")
            ->name("admin-prodi.mahasiswa.d3.import");
    });

    Route::controller(MahasiswaD4Controller::class)->group(function () {
        // Route untuk menampilkan Halaman Mahasiswa D4 JTD
        Route::get("/admin-prodi/mahasiswa/d4/page", "showMahasiswaPage")
            ->name("admin-prodi.mahasiswa.d4.page");

        // Route untuk mengambil Data Semua Mahasiswa D4 JTD
        Route::get("/admin-prodi/mahasiswa/d4", "showAllMahasiswa")
            ->name("admin-prodi.mahasiswa.d4");

        // Route untuk pencarian Data Mahasiswa D4 JTD berdasarkan nama atau NIM
        Route::get("/admin-prodi/mahasiswa/d4/search", "searchMahasiswa")
            ->name("admin-prodi.mahasiswa.d4.search");

        // Route untuk impor data Mahasiswa D4 JTD menggunakan data Excel
        Route::post("/admin-prodi/mahasiswa/d4/import", "importMahasiswa")
            ->name("admin-prodi.mahasiswa.d4.import");
    });

    Route::controller(DosenController::class)->group(function () {
        // Route menampilkan halaman data Dosen
        Route::get("/admin-prodi/dosen/page", "showDataDosenPage")
            ->name("admin-prodi.dosen.page");

        // Route untuk mengambil Data Semua Dosen
        Route::get("/admin-prodi/dosen", "showAllDataDosen")
            ->name("admin-prodi.dosen");

        // Route untuk pencarian Data Mahasiswa Dosen berdasarkan NIDN, NIP, atau nama
        Route::get("/admin-prodi/dosen/search", "searchDataDosen")
            ->name("admin-prodi.dosen.search");

        // Route untuk impor data Dosen menggunakan data Excel
        Route::post("/admin-prodi/dosen/import", "importDosen")
            ->name("admin-prodi.dosen.import");
    });

    Route::controller(PanitiaController::class)->group(function () {
        // Route untuk menampilkan Halaman Daftar Panitia Tugas Akhir D3 dan D4
        Route::get("/admin-prodi/panitia-tugas-akhir", "showPanitia")
            ->name("admin-prodi.panitia-tugas-akhir");

        // Route untuk menampilkan Halaman Tambah Panitia Tugas Akhir
        Route::get("/admin-prodi/panitia-tugas-akhir/{prodi}/tambah", "createPanitia")
            ->name("admin-prodi.panitia-tugas-akhir.halaman-tambah");

        // Route untuk Mengirim Data Edit Panitia Tugas Akhir
        Route::post("/admin-prodi/panitia-tugas-akhir/{prodi}", "store")
            ->name("admin-prodi.panitia-tugas-akhir.tambah");

        // Route untuk menampilkan Halaman Edit Panitia Tugas Akhir
        Route::get('/admin-prodi/panitia-tugas-akhir/{prodi}/edit', 'edit')
            ->name('admin-prodi.panitia-tugas-akhir.edit');

        // Route untuk mengirim data Edit Panitia Tugas Akhir
        Route::put('/admin-prodi/panitia-tugas-akhir/{prodi}', 'update')
            ->name('admin-prodi.panitia-tugas-akhir.update');
    });
});

/**
 * Route untuk user yang terautentikasi sebagai Mahasiswa
 */
Route::middleware(["auth:mahasiswa", "auth.session", "password.changed"])->group(function () {

    Route::controller(HomePageController::class)->group(function () {
        // Route untuk memuat halaman awal user Mahasiswa
        Route::get("/mahasiswa/home", "mahasiswa")
            ->name("mahasiswa.home");
    });

    Route::controller(PengajuanJudulController::class)->group(function () {
        Route::get('/mahasiswa/pengajuan-judul', 'showPengajuanPage')->name('mahasiswa.pengajuan-judul');
        Route::post('/mahasiswa/pengajuan-judul/store', 'storePengajuanJudul')->name('mahasiswa.pengajuan-judul-store');
        Route::get('/mahasiswa/pengajuan-judul/riwayat', 'showRiwayatPengajuanPage')->name('mahasiswa.pengajuan-judul-riwayat');
    });

    Route::controller(SeminarProposalController::class)->group(function () {
        Route::get('/mahasiswa/seminar-proposal/pendaftaran', 'showPendaftaranPage')->name('mahasiswa.seminar-proposal.pendaftaran');
        Route::post('/mahasiswa/seminar-proposal/pendaftaran-store', 'storePendaftaran')->name('mahasiswa.seminar-proposal.pendaftaran-store');
    });

    Route::controller(SeminarHasilController::class)->group(function () {
        Route::get('/mahasiswa/seminar-hasil/daftar-semhas', 'showPendaftaranPage')->name('mahasiswa.seminar-hasil.daftar-semhas');
        Route::post('/mahasiswa/seminar-hasil/daftar-semhas-store', 'storePendaftaran')->name('mahasiswa.seminar-hasil.daftar-semhas-store');
    });

    Route::controller(LogbookController::class)->group(function () {
        Route::get('/mahasiswa/logbook/beranda/{roleDospem}', 'showBeranda')->name('mahasiswa.logbook.beranda');
        Route::get('/mahasiswa/logbook/tambah-baru/{roleDospem}', 'showTambahLogbookPage')->name('mahasiswa.logbook.tambah-baru');
        Route::get('/mahasiswa/logbook/detail/{logbook}', 'showDetailLogbook')->name('mahasiswa.logbook.detail');
        Route::post('/mahasiswa/logbook/store', 'storeLogbook')->name('mahasiswa.logbook.store');
        Route::delete('/mahasiswa/logbook/{logbook}/delete', 'deleteLogbook')->name('mahasiswa.logbook.delete');
    });

    Route::controller(AjaxMahasiswaController::class)->group(function () {
        Route::get('/mahasiswa/ajax/search-mahasiswa', 'searchMahasiswa');
        Route::get('/mahasiswa/ajax/search-calonDosen', 'searchCalonDosenPembimbing');
    });

    Route::controller(JadwalSemproMahasiswaController::class)->group(function () {
        Route::get('/mahasiswa/seminar-proposal/jadwal', 'showJadwalPage')->name('mahasiswa.seminar-proposal.jadwal');
    });

    Route::controller(DosenController::class)->group(function () {
        Route::get('/mahasiswa/informasi-dosen/daftar-dosen', 'daftarDosen')->name('mahasiswa.informasi-dosen.daftar-dosen');
        Route::get('/mahasiswa/informasi-dosen/profil-dosen/{id}', 'profilDosen')->name('mahasiswa.informasi-dosen.profil-dosen');
    });

    Route::controller(DaftarDosenPembimbingController::class)->group(function(){
        // Route untuk menampilkan daftar dosen pembimbing
        Route::get('/mahasiswa/informasi-dosen/daftar-dosen-pembimbing', "index")->name("mahasiswa.informasi-dosen.daftar-dosen-pembimbing");
    });

    Route::get('/mahasiswa/profile', [MahasiswaController::class, 'showProfile'])->name('mahasiswa.profile');
    Route::post('/mahasiswa/profile/edit-email', [MahasiswaController::class, 'updateEmail'])->name('mahasiswa.profile.edit-email');
    Route::post('/mahasiswa/profile/edit-image', [MahasiswaController::class, 'updateFotoProfil'])->name('mahasiswa.profile.edit-image');
    Route::post('/mahasiswa/profile/change-password', [MahasiswaController::class, 'changePassword'])->name('mahasiswa.profile.change-password');
});

/**
 * Route untuk user terautentikasi sebagai Dosen
 */
Route::middleware(["auth:dosen", "auth.session", "password.changed"])->group(function () {
    Route::controller(HomePageController::class)->group(function () {
        // Route untuk memuat halaman awal user Dosen
        Route::get("/dosen/home", "dosen")
            ->name("dosen.home");
    });

    Route::controller(PrivateFileController::class)->group(function () {
        Route::get('/blok-diagram/{id}', 'serveBlokDiagramSistem')
            ->name('blok.diagram.show');
    });

    Route::controller(PermohonanJudulController::class)->group(function () {
        Route::get('/dosen/permohonan-judul', 'showPermohonanPage')->name('dosen.permohonan-judul');
        Route::get('/dosen/permohonan-judul/{proposalId}/detail', 'showDetailPermohonanPage')->name('dosen.permohonan-judul-detail');
        Route::post('/dosen/permohonan-judul/update-status', 'updatePermohonan')->name('dosen.permohonan-judul-update');
    });

    Route::controller(JadwalSemproDosenController::class)->group(function () {
        // Route untuk menampilkan halaman beranda jadwal seminar proposal
        Route::get('/dosen/seminar-proposal/jadwal', 'showBerandaJadwalPage')->name('dosen.seminar-proposal.beranda-jadwal');

        // Route untuk menampilkan halaman jadwal seminar proposal
        Route::get("/dosen/seminar-proposal/jadwal/{tahapId}", "showJadwalPage")
            ->name("dosen.seminar-proposal.jadwal");
    });

    Route::controller(BimbinganController::class)->group(function () {
        Route::get('/dosen/bimbingan/daftar-bimbingan', 'showDaftarBimbingan')->name('dosen.bimbingan.daftar-bimbingan');
        Route::get('/dosen/bimbingan/logbook-mahasiswa/{mahasiswa}', 'showDaftarLogbookMahasiswa')->name('dosen.bimbingan.logbook-mahasiswa');
        Route::get('/dosen/bimbingan/logbook-mahasiswa/{mahasiswa}/detail/{logbook}', 'showDetailLogbook')->name('dosen.bimbingan.detail-logbook-mahasiswa');
        Route::put('/dosen/bimbingan/logbook-mahasiswa/update-verif/logbook', 'updateVerifikasiLogbook')->name('dosen.bimbingan.update-verifikasi-logbook');
        Route::get('/dosen/bimbingan/detail-bimbingan/{mahasiswa}', 'showDetailBimbingan')->name('dosen.bimbingan.detail-bimbingan');
    });

    Route::controller(DosenProfileController::class)->group(function () {
        Route::get('/dosen/profile', 'showProfile')->name('dosen.profile');
        Route::get('/dosen/profile/edit', 'editProfile')->name('dosen.profile.edit');
        Route::post('/dosen/profile/update', 'updateProfile')->name('dosen.profile.update');
        Route::post('/dosen/profile/change-password', 'changePassword')->name('dosen.profile.change-password');
        Route::post('/dosen/profile/edit-image', 'updateFotoProfil')->name('dosen.profile.edit-image');
    });
});

/**
 * Route untuk user Panitia
 */
Route::middleware(["auth:dosen", "auth.session", "password.changed", "is.panitia"])->group(function () {
    Route::controller(HomePageController::class)->group(function () {
        // Route untuk memuat halaman awal user Panitia
        Route::get("/panitia/home", "panitia")
            ->name("panitia.home");
    });

    Route::controller(DashboardController::class)->group(function () {
        // Route untuk menampilkan Dashboard Panitia
        Route::get("/panitia/dashboard", "showDashboardPage")
            ->name("panitia.dashboard");
    });

    Route::controller(KuotaDosenController::class)->group(function () {
        // Route untuk menampilkan halaman kuota dosen
        Route::get("/panitia/kuota-dosen/page", "showKuotaDosenPage")
            ->name("panitia.kuota-dosen.page");

        // Route untuk mengambil data kuota (dengan filter & search)
        Route::get('/panitia/kuota-dosen', 'getData');

        // Route untuk mengupdate kuota seorang dosen
        // {kuota_dosen} adalah ID dari record di tabel kuota_dosen
        Route::put('/panitia/kuota-dosen/{kuota_dosen}', 'update')
            ->name("panitia.kuota-dosen.update");

        // Route untuk Reset Kuota Dosen
        Route::post('/panitia/kuota-dosen/reset', 'resetKuotaDosen')
            ->name("panitia.kuota-dosen.reset");
    });

    Route::controller(SeminarProposalPanitiaController::class)->group(function () {
        Route::get('/panitia/seminar-proposal/pendaftaran', 'showBerandaPendaftaranPage')->name('panitia.seminar-proposal.pendaftaran');
        Route::get('/panitia/seminar-proposal/pendaftaran/{tahapId}/detail', 'showDetailPendaftaranPage')->name('panitia.seminar-proposal.pendaftaran-detail');
        Route::get('/panitia/seminar-proposal/pendaftaran/{pendaftaranId}/verifikasi', 'showVerifikasiPendaftaran')->name('panitia.seminar-proposal.verifikasi-daftar');
        Route::put('/panitia/seminar-proposal/pendaftaran/{pendaftaranId}/update-verifikasi', 'updateVerifikasiPendaftaran')->name('panitia.seminar-proposal.update-verifikasi');
    });

    Route::controller(SeminarHasilPanitiaController::class)->group(function () {
        Route::get('/panitia/seminar-hasil/pendaftaran', 'showBerandaPendaftaranPage')->name('panitia.seminar-hasil.pendaftaran');
        Route::get('/panitia/seminar-hasil/pendaftaran/{tahapId}/detail', 'showDetailPendaftaranPage')->name('panitia.seminar-hasil.pendaftaran-detail');
        Route::get('/panitia/seminar-hasil/pendaftaran/{pendaftaranId}/verifikasi', 'showVerifikasiPendaftaran')->name('panitia.seminar-hasil.verifikasi-daftar');
        Route::put('/panitia/seminar-hasil/pendaftaran/{pendaftaranId}/update-verifikasi', 'updateVerifikasiPendaftaran')->name('panitia.seminar-hasil.update-verifikasi');
    });

    Route::controller(AjaxPendaftaranSemproController::class)->group(function () {
        Route::get('/panitia/ajax/list-pendaftaran-sempro', 'listPendaftaranSempro')->name('panitia.ajax.list-pendaftaran-sempro');
        Route::get('/panitia/ajax/list-pendaftaran-semhas', 'listPendaftaranSemhas')->name('panitia.ajax.list-pendaftaran-semhas');
    });

    Route::controller(PrivateFileController::class)->group(function () {
        // sempro
        Route::get('/proposal-sempro/{id}', 'serveProposalSemproFile')
            ->name('proposal-sempro.show');
        Route::get('/lembar-konsul/{id}', 'serveLembarKonsulSemproFile')
            ->name('lembar-konsul.show');
        Route::get('/lembar-kerjasama-mitra/{id}', 'serveLembarKerjsamaMitraSemproFile')
            ->name('lembar-kerjasama-mitra.show');
        Route::get('/bukti-cek-plagiasi/{id}', 'serveBuktiCekPlagiasiSemproFile')
            ->name('bukti-cek-plagiasi.show');

        // semhas
        Route::get('/surat-rekom-dosen/{id}', 'serveSuratRekomDospemFile')
            ->name('surat-rekom.show');
        Route::get('/proposal-semhas/{id}', 'serveProposalSemhasFile')
            ->name('proposal-semhas.show');
        Route::get('/draft-jurnal/{id}', 'serveDraftJurnalFile')
            ->name('draft-jurnal.show');
        Route::get('/ia-mitra/{id}', 'serveIAMitraFile')
            ->name('ia-mitra.show');
        Route::get('/bebas-pkl/{id}', 'serveBebasTanggunganPklFile')
            ->name('bebas-pkl.show');
        Route::get('/skla/{id}', 'serveSKLAFile')
            ->name('skla.show');
    });

    Route::controller(JadwalSemproPanitiaController::class)
        ->prefix('/panitia/jadwal-sempro')
        ->name('jadwal-sempro.')
        ->group(function () {
            // -- Generate Jadwal Otomatis
            // Route untuk mengakses halaman beranda jadwal sempro
            Route::get('/', 'index')->name('index');

            // Route untuk Membuka Halaman Generate Jadwal Otomatis
            Route::get('/create', 'create')->name('create');

            // Route untuk generate jadwal otomatis
            Route::post('/store', 'store')->name('store');

            // Route::get('/edit/{id}', 'edit')->name('edit');
            // Route::put('/update/{id}', 'update')->name('update');
            // Route::delete('/delete/{id}', 'delete')->name('delete');

            //  Route untuk melihat detail jadwal sempro
            Route::get('/detail/{tahap_id}/{periode_id}', 'detail')->name('detail');

            // -- Buat Jadwal Manual --
            // Route untuk membuka halaman generate jadwal manual
            Route::get('/create-manual', 'showCreateManualPage')->name('create-manual');

            // Route untuk mendapatkan daftar calon peserta sempro
            Route::get("/calon-peserta", 'getCalonPesertaSempro')->name('calon-peserta');

            // Route untuk mengirim data jadwal manual
            Route::post("/store-manual", "storeManual")->name("store-manual");
        });

    Route::controller(PlottingPembimbingController::class)->group(function () {
        // Route untuk membuka halaman plotting pembimbing
        Route::get('/panitia/plotting-pembimbing', 'index')->name('panitia.plotting-pembimbing.index');

        // Route untuk mengedit pembimbing
        Route::post('/panitia/plotting-pembimbing/update', 'update')->name('panitia.plotting-pembimbing.update');
    });
});
