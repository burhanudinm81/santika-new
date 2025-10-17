<?php

use App\Http\Controllers\AdminProdiController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen\SeminarProposal\JadwalSemproController as JadwalSemproDosenController;
use App\Http\Controllers\Dosen\SeminarHasil\JadwalSemhasController as JadwalSemhasDosenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dosen\Bimbingan\BimbinganController;
use App\Http\Controllers\KuotaDosenController;
use App\Http\Controllers\Dosen\PermohonanJudul\PermohonanJudulController;
use App\Http\Controllers\Dosen\SeminarHasil\PenilaianSemhasController;
use App\Http\Controllers\Dosen\SeminarProposal\PenilaianSemproController;
use App\Http\Controllers\Mahasiswa\Ajax\AjaxMahasiswaController;
use App\Http\Controllers\Mahasiswa\InformasiDosen\DaftarDosenPembimbingController;
use App\Http\Controllers\Mahasiswa\Logbook\LogbookController;
use App\Http\Controllers\Mahasiswa\PengajuanJudul\PengajuanJudulController;
use App\Http\Controllers\Mahasiswa\SeminarHasil\SeminarHasilController;
use App\Http\Controllers\Mahasiswa\SeminarProposal\SeminarProposalController;
use App\Http\Controllers\Mahasiswa\SeminarProposal\JadwalSemproController as JadwalSemproMahasiswaController;
use App\Http\Controllers\Mahasiswa\SeminarHasil\JadwalSemhasController as JadwalSemhasMahasiswaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaD3Controller;
use App\Http\Controllers\MahasiswaD4Controller;
use App\Http\Controllers\Panitia\Ajax\AjaxPendaftaranSemproController;
use App\Http\Controllers\Panitia\KelolaSeminar\KelolaPeriodeTahapController;
use App\Http\Controllers\Panitia\KelolaSeminar\VisibilitasNilaiController;
use App\Http\Controllers\Panitia\PlottingPembimbing\PlottingPembimbingController;
use App\Http\Controllers\Panitia\SeminarHasil\JadwalSemhasController as JadwalSemhasPanitiaController;
use App\Http\Controllers\Panitia\SeminarHasil\SeminarHasilPanitiaController;
use App\Http\Controllers\Panitia\SeminarProposal\JadwalSemproController as JadwalSemproPanitiaController;
use App\Http\Controllers\Panitia\SeminarProposal\SeminarProposalController as SeminarProposalPanitiaController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\PengujianPenjadwalanAG;
use App\Http\Controllers\PrivateFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenProfileController;
use App\Http\Controllers\Panitia\Ajax\AjaxRekapNilaiSemhasController;
use App\Http\Controllers\Panitia\Ajax\AjaxRekapNilaiSemproController;

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

    Route::controller(AdminProdiController::class)->group(function () {
        // Route untuk memuat halaman profil Admin Prodi
        Route::get("/admin-prodi/profile", "showProfile")->name("admin-prodi.profile");

        // Route untuk mengupdate email Admin Prodi
        Route::patch("/admin-prodi/profile/edit-email", "updateEmail")
            ->name("admin-prodi.profile.edit-email");

        // Route untuk mengupdate password Admin Prodi
        Route::patch("/admin-prodi/profile/change-password", "updatePassword")
            ->name("admin-prodi.profile.change-password");
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

        // Route untuk menghapus Data Mahasiswa D3 TT
        Route::delete("/admin-prodi/mahasiswa/d3/delete", "deleteMahasiswa")
            ->name("admin-prodi.mahasiswa.d3.delete");

        // Route untuk mengganti password Mahasiswa D3 TT
        Route::patch("/admin-prodi/mahasiswa/d3/change-password", "adminChangePasswordMahasiswa")
            ->name("admin-prodi.mahasiswa.d3.change-password");
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

        // Route untuk menghapus Data Mahasiswa D4 JTD
        Route::delete("/admin-prodi/mahasiswa/d4/delete", "deleteMahasiswa")
            ->name("admin-prodi.mahasiswa.d4.delete");

        // Route untuk mengganti password Mahasiswa D4 JTD
        Route::patch("/admin-prodi/mahasiswa/d4/change-password", "adminChangePasswordMahasiswa")
            ->name("admin-prodi.mahasiswa.d4.change-password");
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

        // Route untuk menghapus dosen
        Route::delete("/admin-prodi/dosen/delete", "deleteDosen")
            ->name("admin-prodi.dosen.delete");

        // Route untuk mengganti password dosen
        Route::patch("/admin-prodi/dosen/change-password", "adminChangePasswordDosen")
            ->name("admin-prodi.dosen.change-password");
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
        Route::get('/mahasiswa/seminar-proposal/hasil-sempro', 'showHasilSempro')->name('mahasiswa.seminar-proposal.hasil-sempro');
        Route::get('/mahasiswa/seminar-proposal/revisi', 'showUploadRevisi')->name('mahasiswa.seminar-proposal.revisi');
        Route::post('/mahasiswa/seminar-proposal/revisi-store', 'storeUploadRevisi')->name('mahasiswa.seminar-proposal.revisi-store');
        Route::get('/mahasiswa/seminar-proposal/riwayat', 'riwayat')->name('mahasiswa.seminar-proposal.riwayat');
    });

    Route::controller(SeminarHasilController::class)->group(function () {
        Route::get('/mahasiswa/seminar-hasil/daftar-semhas', 'showPendaftaranPage')->name('mahasiswa.seminar-hasil.daftar-semhas');
        Route::post('/mahasiswa/seminar-hasil/daftar-semhas-store', 'storePendaftaran')->name('mahasiswa.seminar-hasil.daftar-semhas-store');
        Route::get('/mahasiswa/seminar-hasil/hasil-semhas-sementara', 'showHasilSementaraSemhas')->name('mahasiswa.seminar-hasil.hasil-semhas-sementara');
        Route::get('/mahasiswa/seminar-hasil/revisi', 'showUploadRevisi')->name('mahasiswa.seminar-hasil.revisi');
        Route::post('/mahasiswa/seminar-hasil/revisi-store', 'storeUploadRevisi')->name('mahasiswa.seminar-hasil.revisi-store');
        Route::get('/mahasiswa/seminar-hasil/riwayat', 'riwayat')->name('mahasiswa.seminar-hasil.riwayat');
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

    Route::controller(DaftarDosenPembimbingController::class)->group(function () {
        // Route untuk menampilkan daftar dosen pembimbing
        Route::get('/mahasiswa/informasi-dosen/daftar-dosen-pembimbing', "index")->name("mahasiswa.informasi-dosen.daftar-dosen-pembimbing");
    });

    Route::controller(JadwalSemhasMahasiswaController::class)->group(function () {
        Route::get('/mahasiswa/seminar-hasil/jadwal', 'showJadwalPage')->name('mahasiswa.seminar-hasil.jadwal');
    });

    Route::controller(PrivateFileController::class)->group(function () {
        Route::get("/revisi-sempro/lembarRevisi/Mhs/{id}", "serveRevisiLembarRevisiSempro")
            ->name('revisi-lembarRevisi-sempro-mhs.show');

        Route::get('/revisi-proposal-sempro/Mhs/{id}', 'serveRevisiProposalSempro')
            ->name('revisi-proposal-sempro-mhs.show');
    });

    Route::get('/mahasiswa/profile', [MahasiswaController::class, 'showProfile'])->name('mahasiswa.profile');
    Route::post('/mahasiswa/profile/edit-email', [MahasiswaController::class, 'updateEmail'])->name('mahasiswa.profile.edit-email');
    Route::post('/mahasiswa/profile/edit-image', [MahasiswaController::class, 'updateFotoProfil'])->name('mahasiswa.profile.edit-image');
    Route::post('/mahasiswa/profile/change-password', [MahasiswaController::class, 'changePassword'])->name('mahasiswa.profile.change-password');

    // Route untuk serving file yang private, dalam bentuk link path
    Route::get('/file-private-mahasiswa/{filepath}', function ($filepath) {
        $path = storage_path('app/private/' . $filepath);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->where('filepath', '.*')->name('file-private-mahasiswa.view');
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
        Route::get("/dosen/seminar-proposal/jadwal/tahap/{tahapId}/periode/{periodeId?}", "showJadwalPage")
            ->name("dosen.seminar-proposal.jadwal");
    });

    Route::controller(JadwalSemhasDosenController::class)->group(function () {
        // Route untuk menampilkan halaman beranda jadwal seminar hasil
        Route::get('/dosen/seminar-hasil/jadwal', 'showBerandaJadwalPage')->name('dosen.seminar-hasil.beranda-jadwal');

        // Route untuk menampilkan halaman jadwal seminar hasil
        Route::get("/dosen/seminar-hasil/jadwal/tahap/{tahapId}/periode/{periodeId?}", "showJadwalPage")
            ->name("dosen.seminar-hasil.jadwal");
    });

    Route::controller(BimbinganController::class)->group(function () {
        Route::get('/dosen/bimbingan/daftar-bimbingan', 'showDaftarBimbingan')->name('dosen.bimbingan.daftar-bimbingan');
        Route::get('/dosen/bimbingan/logbook-mahasiswa/{mahasiswa}', 'showDaftarLogbookMahasiswa')->name('dosen.bimbingan.logbook-mahasiswa');
        Route::get('/dosen/bimbingan/logbook-mahasiswa/{mahasiswa}/detail/{logbook}', 'showDetailLogbook')->name('dosen.bimbingan.detail-logbook-mahasiswa');
        Route::put('/dosen/bimbingan/logbook-mahasiswa/update-verif/logbook', 'updateVerifikasiLogbook')->name('dosen.bimbingan.update-verifikasi-logbook');
        Route::get('/dosen/bimbingan/detail-bimbingan/{mahasiswa}', 'showDetailBimbingan')->name('dosen.bimbingan.detail-bimbingan');
        Route::post("/dosen/bimbingan/accept-all-logbook", "terimaSemuaLogbook")->name("dosen.bimbingan.terima-semua-logbook");
    });

    Route::controller(DosenProfileController::class)->group(function () {
        Route::get('/dosen/profile', 'showProfile')->name('dosen.profile');
        Route::get('/dosen/profile/edit', 'editProfile')->name('dosen.profile.edit');
        Route::post('/dosen/profile/update', 'updateProfile')->name('dosen.profile.update');
        Route::post('/dosen/profile/change-password', 'changePassword')->name('dosen.profile.change-password');
        Route::post('/dosen/profile/edit-image', 'updateFotoProfil')->name('dosen.profile.edit-image');
    });

    Route::controller(PenilaianSemproController::class)->group(function () {
        Route::get('/dosen/penilaian-sempro/{proposal_id}', 'showPenilaianBaseOnMahasiswa')->name('dosen.penilaian-sempro');
        Route::put('/dosen/penilaian-sempro/update', 'updatePenilaian')->name('dosen.penilaian-sempro.update-penilaian');
    });

    Route::controller(PenilaianSemhasController::class)->group(function () {
        Route::get('/dosen/penilaian-semhas/temporary/{proposal_id}', 'showInputPenilaianSementara')->name('dosen.penilaian-semhas-sementara');
        Route::put('/dosen/penilaian-semhas/temporary/update', 'updatePenilaianSementara')->name('dosen.penilaian-semhas.update-penilaian-sementara');
        Route::get('/dosen/penilaian-semhas/akhir/{proposal_id}', 'showInputPenilaianAkhir')->name('dosen.penilaian-semhas-akhir');
        Route::put('/dosen/penilaian-semhas/akhir/update', 'updatePenilaianAkhir')->name('dosen.penilaian-semhas.update-penilaian-akhir');
    });

    Route::controller(PrivateFileController::class)->group(function () {
        // revisi sempro
        Route::get('/revisi-proposal-sempro/dosen{id}', 'serveRevisiProposalSempro')
            ->name('revisi-proposal-sempro-dosen.show');
        Route::get('/revisi-lembarRevisi-sempro/dosen{id}', 'serveRevisiLembarRevisiSempro')
            ->name('revisi-lembarRevisi-sempro-dosen.show');
        // revisi semhas
        Route::get('/revisi-proposal-semhas/dosen{id}', 'serveRevisiProposalSemhas')
            ->name('revisi-proposal-semhas-dosen.show');
        Route::get('/revisi-lembarRevisi-semhas/dosen{id}', 'serveRevisiLembarRevisiSemhas')
            ->name('revisi-lembarRevisi-semhas-dosen.show');
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
        Route::get('/panitia/seminar-proposal/tahap-rekap-nilai', 'showTahapRekapNilai')->name('panitia.seminar-proposal.tahap-rekap-nilai');
        Route::get('/panitia/seminar-proposal/beranda-rekap-nilai/{tahapId}', 'showBerandaRekapNilai')->name('panitia.seminar-proposal.beranda-rekap-nilai');
        Route::get('/panitia/seminar-proposal/detail-verifikasi-revisi/{proposalId}', 'showDetailVerifikasiRevisi')->name('panitia.seminar-proposal.detail-verifikasi-revisi');
        Route::put('/panitia/seminar-proposal/detail-verifikasi-revisi/update', 'updateVerifikasiRevisi')->name('panitia.seminar-proposal.update-verifikasi-revisi');
        // Route untuk membuka pendaftaran seminar proposal
        Route::post('/panitia/seminar-proposal/buka-pendaftaran', 'bukaPendaftaran')->name('panitia.seminar-proposal.buka-pendaftaran');
        // Route untuk menutup pendaftaran seminar proposal
        Route::get("/panitia/seminar-proposal/tutup-pendaftaran", "tutupPendaftaran")->name('panitia.seminar-proposal.tutup-pendaftaran');
    });

    Route::controller(SeminarHasilPanitiaController::class)->group(function () {
        Route::get('/panitia/seminar-hasil/pendaftaran', 'showBerandaPendaftaranPage')->name('panitia.seminar-hasil.pendaftaran');
        Route::get('/panitia/seminar-hasil/pendaftaran/{tahapId}/detail', 'showDetailPendaftaranPage')->name('panitia.seminar-hasil.pendaftaran-detail');
        Route::get('/panitia/seminar-hasil/pendaftaran/{pendaftaranId}/verifikasi', 'showVerifikasiPendaftaran')->name('panitia.seminar-hasil.verifikasi-daftar');
        Route::put('/panitia/seminar-hasil/pendaftaran/{pendaftaranId}/update-verifikasi', 'updateVerifikasiPendaftaran')->name('panitia.seminar-hasil.update-verifikasi');
        Route::get('/panitia/seminar-hasil/tahap-rekap-nilai', 'showTahapRekapNilai')->name('panitia.seminar-hasil.tahap-rekap-nilai');
        Route::get('/panitia/seminar-hasil/beranda-rekap-nilai/{tahapId}', 'showBerandaRekapNilai')->name('panitia.seminar-hasil.beranda-rekap-nilai');
        Route::get('/panitia/seminar-hasil/detail-verifikasi-revisi/{proposalId}', 'showDetailVerifikasiRevisi')->name('panitia.seminar-hasil.detail-verifikasi-revisi');
        Route::put('/panitia/seminar-hasil/detail-verifikasi-revisi/update', 'updateVerifikasiRevisi')->name('panitia.seminar-hasil.update-verifikasi-revisi');

        // Route unutk membuka pendaftaran sidang ujian akhir
        Route::post('/panitia/seminar-hasil/buka-pendaftaran', 'bukaPendaftaran')->name('panitia.seminar-hasil.buka-pendaftaran');

        // Route untuk menutup pendaftaran sidang ujian akhir
        Route::get("/panitia/seminar-hasil/tutup-pendaftaran", "tutupPendaftaran")->name('panitia.seminar-hasil.tutup-pendaftaran');
    });

    Route::controller(AjaxPendaftaranSemproController::class)->group(function () {
        Route::get('/panitia/ajax/list-pendaftaran-sempro', 'listPendaftaranSempro')->name('panitia.ajax.list-pendaftaran-sempro');
        Route::get('/panitia/ajax/list-pendaftaran-semhas', 'listPendaftaranSemhas')->name('panitia.ajax.list-pendaftaran-semhas');
    });

    Route::controller(AjaxRekapNilaiSemproController::class)->group(function () {
        Route::get('/panitia/ajax/list-rekap-nilai-sempro', 'listRekapNilaiSempro')->name('panitia.ajax.list-rekap-nilai-sempro');
    });

    Route::controller(AjaxRekapNilaiSemhasController::class)->group(function () {
        Route::get('/panitia/ajax/list-rekap-nilai-semhas', 'listRekapNilaiSemhas')->name('panitia.ajax.list-rekap-nilai-semhas');
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

        // revisi sempro
        Route::get('/revisi-proposal-sempro/{id}', 'serveRevisiProposalSempro')
            ->name('revisi-proposal-sempro.show');
        Route::get('/revisi-lembarRevisi-sempro/{id}', 'serveRevisiLembarRevisiSempro')
            ->name('revisi-lembarRevisi-sempro.show');
        // revisi semhas
        Route::get('/revisi-proposal-semhas/{id}', 'serveRevisiProposalSemhas')
            ->name('revisi-proposal-semhas.show');
        Route::get('/revisi-lembarRevisi-semhas/{id}', 'serveRevisiLembarRevisiSemhas')
            ->name('revisi-lembarRevisi-semhas.show');
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
            Route::get('/detail/tahap/{tahap_id}/periode/{periode_id}', 'detail')->name('detail');

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

    Route::controller(JadwalSemhasPanitiaController::class)
        ->prefix('/panitia/jadwal-sidang-akhir')
        ->name('panitia.jadwal-sidang-akhir.')
        ->group(function () {
            // Route untuk menampilkan jadwal sidang akhir
            Route::get('/', 'index')->name('index');

            // Route untuk membuka halaman generate jadwal sidang ujian akhir otomatis
            Route::get('/create', 'create')->name('create');

            // Route untuk mengirim data generate jadwal sidang ujian akhir otomatis
            Route::post('/store', 'store')->name('store');

            // Route untuk menampilkan halaman detail jadwal sidang ujian akhir
            Route::get("/detail/tahap/{tahap_id}/periode/{periode_id}", "detail")->name('detail');

            // Route untuk membuka halaman generate jadwal sidang ujian akhir manual
            Route::get('/create-manual', 'showCreateManualPage')->name('create-manual');

            // Route untuk mendapatkan daftar calon peserta sidang ujian akhir
            Route::get('/calon-peserta', 'getCalonPesertaSemhas')->name('calon-peserta');

            // Route untuk mengirim data generate jadwal sidang ujian akhir manual
            Route::post("/store-manual", "storeManual")->name("store-manual");
        });

    // Route untuk serving file yang private, dalam bentuk link path
    Route::get('/file-private/{filepath}', function ($filepath) {
        $path = storage_path('app/private/' . $filepath);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->where('filepath', '.*')->name('file-private.view');

    Route::controller(KelolaPeriodeTahapController::class)
        ->prefix('/panitia/kelola-periode-tahap')
        ->name('panitia.kelola-periode-tahap.')
        ->group(function () {
            // Route untuk tambah tahap baru
            Route::post("/tambah-tahap", "tambahTahap")->name('tambah-tahap');
            // Route untuk tambah periode
            Route::post('/tambah-periode', 'tambahPeriode')->name('tambah-periode');
            // Route untuk  membuka halaman pengaturan Seminar
            Route::get("/pengaturan-seminar", "showPengaturanPeriodeTahap")->name('pengaturan-seminar');

            // Route untuk mengganti periode aktif
            Route::post('/ganti-periode-aktif', 'gantiPeriodeAktif')->name('ganti-periode-aktif');
            // Route untuk mengganti tahap sempro aktif
            Route::post('/ubah-tahap-sempro-aktif', 'aturTahapSemproAktif')->name('ubah-tahap-sempro-aktif');
            // Route untuk mengganti tahap sidang tugas akhir aktif
            Route::post('/ubah-tahap-sidang-ta-aktif', 'aturTahapSidangTAAktif')->name('ubah-tahap-sidang-ta-aktif');
            // Route untuk menonaktifkan tahap sempro
            Route::get("/nonaktifkan-tahap-sempro", "nonaktifkanTahapSempro")->name("nonaktifkan-tahap-sempro");
            // Route untuk menonaktifkan tahap sidang TA
            Route::get("/nonaktifkan-tahap-sidang-ta", "nonaktifkanTahapSidangTA")->name("nonaktifkan-tahap-sidang-ta");
            // Route untuk menghapus tahap
            Route::delete("/hapus-tahap", "hapusTahap")->name("hapus-tahap");
        });

    Route::controller(VisibilitasNilaiController::class)
        ->prefix('/panitia/kelola-seminar/visibilitas-nilai')
        ->name('panitia.kelola-seminar.visibilitas-nilai.')
        ->group(function () {
            // Route untuk mempublikasikan nilai seminar
            Route::post('/publish', 'publishNilai')->name('publish');
            // Route untuk menyembunyikan nilai seminar
            Route::post('/hide', 'hideNilai')->name('hide');
        });

});

Route::get("/hyper-parameter-tuning", [PengujianPenjadwalanAG::class, "pengujianHyperTuningParameter"]);
