<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\KuotaDosenController;
use App\Http\Controllers\Dosen\PermohonanJudul\PermohonanJudulController;
use App\Http\Controllers\Mahasiswa\Ajax\AjaxMahasiswaController;
use App\Http\Controllers\Mahasiswa\PengajuanJudul\PengajuanJudulController;
use App\Http\Controllers\Mahasiswa\SeminarProposal\SeminarProposalController;
use App\Http\Controllers\MahasiswaD3Controller;
use App\Http\Controllers\MahasiswaD4Controller;
use App\Http\Controllers\Panitia\Ajax\AjaxPendaftaranSemproController;
use App\Http\Controllers\Panitia\SeminarProposal\JadwalSemproController;
use App\Http\Controllers\Panitia\SeminarProposal\SeminarProposalController as SeminarProposalPanitiaController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\PrivateFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    if(session()->has("role")) {
        if(session()->get("role") === "admin-prodi") {
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


    Route::controller(AjaxMahasiswaController::class)->group(function () {
        Route::get('/mahasiswa/ajax/search-mahasiswa', 'searchMahasiswa');
        Route::get('/mahasiswa/ajax/search-calonDosen', 'searchCalonDosenPembimbing');
    });
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
        Route::put('/panitia/kuota-dosen/{kuota_dosen}', 'update');
    });

    Route::controller(SeminarProposalPanitiaController::class)->group(function () {
        Route::get('/panitia/seminar-proposal/pendaftaran', 'showBerandaPendaftaranPage')->name('panitia.seminar-proposal.pendaftaran');
        Route::get('/panitia/seminar-proposal/pendaftaran/{tahapId}/detail', 'showDetailPendaftaranPage')->name('panitia.seminar-proposal.pendaftaran-detail');
        Route::get('/panitia/seminar-proposal/pendaftaran/{pendaftaranId}/verifikasi', 'showVerifikasiPendaftaran')->name('panitia.seminar-proposal.verifikasi-daftar');
        Route::put('/panitia/seminar-proposal/pendaftaran/{pendaftaranId}/update-verifikasi', 'updateVerifikasiPendaftaran')->name('panitia.seminar-proposal.update-verifikasi');
    });

    Route::controller(AjaxPendaftaranSemproController::class)->group(function () {
        Route::get('/panitia/ajax/list-pendaftaran-sempro', 'listPendaftaranSempro')->name('panitia.ajax.list-pendaftaran-sempro');
    });

    Route::controller(PrivateFileController::class)->group(function () {
        Route::get('/proposal-sempro/{id}', 'serveProposalSemproFile')
            ->name('proposal-sempro.show');
        Route::get('/lembar-konsul/{id}', 'serveLembarKonsulSemproFile')
            ->name('lembar-konsul.show');
        Route::get('/lembar-kerjasama-mitra/{id}', 'serveLembarKerjsamaMitraSemproFile')
            ->name('lembar-kerjasama-mitra.show');
        Route::get('/bukti-cek-plagiasi/{id}', 'serveBuktiCekPlagiasiSemproFile')
            ->name('bukti-cek-plagiasi.show');
    });

    Route::controller(JadwalSemproController::class)
        ->prefix('/panitia/jadwal-sempro')
        ->name('jadwal-sempro.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            // Route::get('/edit/{id}', 'edit')->name('edit');
            // Route::put('/update/{id}', 'update')->name('update');
            // Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/detail/{tahap_id}/{periode_id}', 'detail')->name('detail');
        });
});
