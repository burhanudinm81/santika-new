<?php

namespace Database\Seeders;

use App\Models\NilaiAkhirMahasiswa;
use App\Models\Proposal;
use App\Models\Revisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CustomIsiNilaiTugasAkhirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pick One

        // $this->nilaiSamaRata();
        $this->nilaiBervariasi();
    }

    public function nilaiSamaRata(): void
    {
        $prodiId = 2;       // Ganti dengan prodi_id yang diinginkan
        $tahapId = 1;       // Ganti dengan tahap_id yang diinginkan 
        $periodeId = 1;     // Ganti dengan periode_id yang diinginkan

        $daftarProposal = Proposal::whereHas('pendaftaranSemhas', function ($query) {
            $query->where('status_daftar_semhas_id', 1);
        })
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->where("prodi_id", $prodiId)
            ->whereNotNull("dosen_pembimbing_1_id")
            ->whereNotNull("dosen_pembimbing_2_id")
            ->whereNotNull("penguji_sidang_ta_1_id")
            ->whereNotNull("penguji_sidang_ta_2_id")
            // ->whereNotBetween("id", [218, 219])         // Aktifkan jika ingin mengecualikan beberapa proposal
            ->with("proposalMahasiswas.mahasiswa")
            ->get();

        DB::transaction(function ()  use($daftarProposal) {
            $daftarProposal->each(function ($proposal) {
                $proposal->update([
                    "status_semhas_penguji_1_id" => 1,
                    "status_semhas_penguji_2_id" => 1,
                    "status_semhas_dosbing_1_id" => 1,
                    "status_semhas_dosbing_2_id" => 1,
                    "status_semhas_proposal_id" => 1
                ]);

                // Nilai Pembimbing 1
                $nilaiSikapPemb1 = rand(90, 99);
                $nilaiKemampuanPemb1 = rand(90, 99);
                $nilaiHasilKaryaPemb1 = rand(90, 99);
                $nilaiLaporanPemb1 = rand(90, 99);
                $avgNilaiDospem1 = ($nilaiSikapPemb1 + $nilaiKemampuanPemb1 + $nilaiHasilKaryaPemb1 + $nilaiLaporanPemb1) / 4;

                // Nilai Pembimbing 2
                $nilaiSikapPemb2 = rand(90, 99);
                $nilaiKemampuanPemb2 = rand(90, 99);
                $nilaiHasilKaryaPemb2 = rand(90, 99);
                $nilaiLaporanPemb2 = rand(90, 99);
                $avgNilaiDospem2 = ($nilaiSikapPemb2 + $nilaiKemampuanPemb2 + $nilaiHasilKaryaPemb2 + $nilaiLaporanPemb2) / 4;

                // Nilai Penguji 1
                $nilaiPenguasaanMateriPeng1 = rand(90, 99);
                $nilaiPresentasiPeng1 = rand(90, 99);
                $nilaiKaryaTulisPeng1 = rand(90, 99);
                $avgNilaiPenguji1 = ($nilaiPenguasaanMateriPeng1 + $nilaiPresentasiPeng1 + $nilaiKaryaTulisPeng1) / 3;

                // Nilai Penguji 2
                $nilaiPenguasaanMateriPeng2 = rand(90, 99);
                $nilaiPresentasiPeng2 = rand(90, 99);
                $nilaiKaryaTulisPeng2 = rand(90, 99);
                $avgNilaiPenguji2 = ($nilaiPenguasaanMateriPeng2 + $nilaiPresentasiPeng2 + $nilaiKaryaTulisPeng2) / 3;

                // Nilai Total Pembimbing dan Nilai Total Penguji
                $nilaiTotalPembimbing = ($avgNilaiDospem1 + $avgNilaiDospem2) / 2;
                $nilaiTotalPenguji = ($avgNilaiPenguji1 + $avgNilaiPenguji2) / 2;

                NilaiAkhirMahasiswa::create([
                    "proposal_id" => $proposal->id,
                    "mahasiswa_id" => $proposal->proposalMahasiswas[0]->mahasiswa->id,
                    "pembimbing_1_id" => $proposal->dosen_pembimbing_1_id,
                    "pembimbing_2_id" => $proposal->dosen_pembimbing_2_id,
                    "penguji_1_id" => $proposal->penguji_sidang_ta_1_id,
                    "penguji_2_id" => $proposal->penguji_sidang_ta_2_id,

                    // Nilai Pembimbing 1
                    "nilai_sikap_pemb1" => $nilaiSikapPemb1,
                    "nilai_kemampuan_pemb1" => $nilaiKemampuanPemb1,
                    "nilai_hasilKarya_pemb1" => $nilaiHasilKaryaPemb1,
                    "nilai_laporan_pemb1" => $nilaiLaporanPemb1,
                    "avg_nilai_dospem1" => $avgNilaiDospem1,

                    // Nilai Pembimbing 2
                    "nilai_sikap_pemb2" => $nilaiSikapPemb2,
                    "nilai_kemampuan_pemb2" => $nilaiKemampuanPemb2,
                    "nilai_hasilKarya_pemb2" => $nilaiHasilKaryaPemb2,
                    "nilai_laporan_pemb2" => $nilaiLaporanPemb2,
                    "avg_nilai_dospem2" => $avgNilaiDospem2,

                    // Nilai Penguji 1
                    "nilai_penguasaan_materi1" => $nilaiPenguasaanMateriPeng1,
                    "nilai_presentasi1" => $nilaiPresentasiPeng1,
                    "nilai_karya_tulis1" => $nilaiKaryaTulisPeng1,
                    "avg_nilai_penguji1" => $avgNilaiPenguji1,

                    // Nilai Penguji 2
                    "nilai_penguasaan_materi2" => $nilaiPenguasaanMateriPeng2,
                    "nilai_presentasi2" => $nilaiPresentasiPeng2,
                    "nilai_karya_tulis2" => $nilaiKaryaTulisPeng2,
                    "avg_nilai_penguji2" => $avgNilaiPenguji2,

                    // Nilai Total Pembimbing
                    "avg_nilai_totalDospem" => $nilaiTotalPembimbing,

                    // Nilai Total Penguji
                    "avg_nilai_totalPenguji" => $nilaiTotalPenguji
                ]);

                if (isset($proposal->proposalMahasiswas[1])) {
                    NilaiAkhirMahasiswa::create([
                        "proposal_id" => $proposal->id,
                        "mahasiswa_id" => $proposal->proposalMahasiswas[1]->mahasiswa->id,
                        "pembimbing_1_id" => $proposal->dosen_pembimbing_1_id,
                        "pembimbing_2_id" => $proposal->dosen_pembimbing_2_id,
                        "penguji_1_id" => $proposal->penguji_sidang_ta_1_id,
                        "penguji_2_id" => $proposal->penguji_sidang_ta_2_id,

                        // Nilai Pembimbing 1
                        "nilai_sikap_pemb1" => $nilaiSikapPemb1,
                        "nilai_kemampuan_pemb1" => $nilaiKemampuanPemb1,
                        "nilai_hasilKarya_pemb1" => $nilaiHasilKaryaPemb1,
                        "nilai_laporan_pemb1" => $nilaiLaporanPemb1,
                        "avg_nilai_dospem1" => $avgNilaiDospem1,

                        // Nilai Pembimbing 2
                        "nilai_sikap_pemb2" => $nilaiSikapPemb2,
                        "nilai_kemampuan_pemb2" => $nilaiKemampuanPemb2,
                        "nilai_hasilKarya_pemb2" => $nilaiHasilKaryaPemb2,
                        "nilai_laporan_pemb2" => $nilaiLaporanPemb2,
                        "avg_nilai_dospem2" => $avgNilaiDospem2,

                        // Nilai Penguji 1
                        "nilai_penguasaan_materi1" => $nilaiPenguasaanMateriPeng1,
                        "nilai_presentasi1" => $nilaiPresentasiPeng1,
                        "nilai_karya_tulis1" => $nilaiKaryaTulisPeng1,
                        "avg_nilai_penguji1" => $avgNilaiPenguji1,

                        // Nilai Penguji 2
                        "nilai_penguasaan_materi2" => $nilaiPenguasaanMateriPeng2,
                        "nilai_presentasi2" => $nilaiPresentasiPeng2,
                        "nilai_karya_tulis2" => $nilaiKaryaTulisPeng2,
                        "avg_nilai_penguji2" => $avgNilaiPenguji2,

                        // Nilai Total Pembimbing
                        "avg_nilai_totalDospem" => $nilaiTotalPembimbing,

                        // Nilai Total Penguji
                        "avg_nilai_totalPenguji" => $nilaiTotalPenguji
                    ]);
                }
            });
        });
    }

    public function nilaiBervariasi(): void
    {
        $faker = Faker::create("id_ID");

        $prodiId = 1;       // Ganti dengan prodi_id yang diinginkan
        $tahapId = 2;       // Ganti dengan tahap_id yang diinginkan 
        $periodeId = 1;     // Ganti dengan periode_id yang diinginkan

        $daftarProposal = Proposal::whereHas('pendaftaranSemhas', function ($query) {
            $query->where('status_daftar_semhas_id', 1);
        })
            ->where("tahap_semhas_id", $tahapId)
            ->where("periode_semhas_id", $periodeId)
            ->where("prodi_id", $prodiId)
            ->whereNotNull("dosen_pembimbing_1_id")
            ->whereNotNull("dosen_pembimbing_2_id")
            ->whereNotNull("penguji_sidang_ta_1_id")
            ->whereNotNull("penguji_sidang_ta_2_id")
            // ->whereNotBetween("id", [218, 219])         // Aktifkan jika ingin mengecualikan beberapa proposal
            ->with("proposalMahasiswas.mahasiswa")
            ->get();

        DB::transaction(function () use ($daftarProposal, $faker) {
            $daftarProposal->each(function ($proposal) use ($faker) {
                $nilaiSementaraSemhas = rand(1, 3);

                $proposal->update([
                    "status_semhas_penguji_1_id" => $nilaiSementaraSemhas,
                    "status_semhas_penguji_2_id" => $nilaiSementaraSemhas,
                    "status_semhas_dosbing_1_id" => $nilaiSementaraSemhas,
                    "status_semhas_dosbing_2_id" => $nilaiSementaraSemhas,
                    "status_semhas_proposal_id" => $nilaiSementaraSemhas
                ]);

                // Nilai Pembimbing 1
                $nilaiSikapPemb1 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiKemampuanPemb1 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiHasilKaryaPemb1 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(90, 89) : rand(50, 60));
                $nilaiLaporanPemb1 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $avgNilaiDospem1 = ($nilaiSikapPemb1 + $nilaiKemampuanPemb1 + $nilaiHasilKaryaPemb1 + $nilaiLaporanPemb1) / 4;

                // Nilai Pembimbing 2
                $nilaiSikapPemb2 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiKemampuanPemb2 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiHasilKaryaPemb2 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiLaporanPemb2 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $avgNilaiDospem2 = ($nilaiSikapPemb2 + $nilaiKemampuanPemb2 + $nilaiHasilKaryaPemb2 + $nilaiLaporanPemb2) / 4;

                // Nilai Penguji 1
                $nilaiPenguasaanMateriPeng1 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiPresentasiPeng1 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiKaryaTulisPeng1 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $avgNilaiPenguji1 = ($nilaiPenguasaanMateriPeng1 + $nilaiPresentasiPeng1 + $nilaiKaryaTulisPeng1) / 3;

                // Nilai Penguji 2
                $nilaiPenguasaanMateriPeng2 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiPresentasiPeng2 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $nilaiKaryaTulisPeng2 = $nilaiSementaraSemhas == 1 ? rand(90, 99) : ($nilaiSementaraSemhas == 2 ? rand(80, 89) : rand(50, 60));
                $avgNilaiPenguji2 = ($nilaiPenguasaanMateriPeng2 + $nilaiPresentasiPeng2 + $nilaiKaryaTulisPeng2) / 3;

                // Nilai Total Pembimbing dan Nilai Total Penguji
                $nilaiTotalPembimbing = ($avgNilaiDospem1 + $avgNilaiDospem2) / 2;
                $nilaiTotalPenguji = ($avgNilaiPenguji1 + $avgNilaiPenguji2) / 2;

                NilaiAkhirMahasiswa::create([
                    "proposal_id" => $proposal->id,
                    "mahasiswa_id" => $proposal->proposalMahasiswas[0]->mahasiswa->id,
                    "pembimbing_1_id" => $proposal->dosen_pembimbing_1_id,
                    "pembimbing_2_id" => $proposal->dosen_pembimbing_2_id,
                    "penguji_1_id" => $proposal->penguji_sidang_ta_1_id,
                    "penguji_2_id" => $proposal->penguji_sidang_ta_2_id,

                    // Nilai Pembimbing 1
                    "nilai_sikap_pemb1" => $nilaiSikapPemb1,
                    "nilai_kemampuan_pemb1" => $nilaiKemampuanPemb1,
                    "nilai_hasilKarya_pemb1" => $nilaiHasilKaryaPemb1,
                    "nilai_laporan_pemb1" => $nilaiLaporanPemb1,
                    "avg_nilai_dospem1" => $avgNilaiDospem1,

                    // Nilai Pembimbing 2
                    "nilai_sikap_pemb2" => $nilaiSikapPemb2,
                    "nilai_kemampuan_pemb2" => $nilaiKemampuanPemb2,
                    "nilai_hasilKarya_pemb2" => $nilaiHasilKaryaPemb2,
                    "nilai_laporan_pemb2" => $nilaiLaporanPemb2,
                    "avg_nilai_dospem2" => $avgNilaiDospem2,

                    // Nilai Penguji 1
                    "nilai_penguasaan_materi1" => $nilaiPenguasaanMateriPeng1,
                    "nilai_presentasi1" => $nilaiPresentasiPeng1,
                    "nilai_karya_tulis1" => $nilaiKaryaTulisPeng1,
                    "avg_nilai_penguji1" => $avgNilaiPenguji1,

                    // Nilai Penguji 2
                    "nilai_penguasaan_materi2" => $nilaiPenguasaanMateriPeng2,
                    "nilai_presentasi2" => $nilaiPresentasiPeng2,
                    "nilai_karya_tulis2" => $nilaiKaryaTulisPeng2,
                    "avg_nilai_penguji2" => $avgNilaiPenguji2,

                    // Nilai Total Pembimbing
                    "avg_nilai_totalDospem" => $nilaiTotalPembimbing,

                    // Nilai Total Penguji
                    "avg_nilai_totalPenguji" => $nilaiTotalPenguji
                ]);

                if (isset($proposal->proposalMahasiswas[1])) {
                    NilaiAkhirMahasiswa::create([
                        "proposal_id" => $proposal->id,
                        "mahasiswa_id" => $proposal->proposalMahasiswas[1]->mahasiswa->id,
                        "pembimbing_1_id" => $proposal->dosen_pembimbing_1_id,
                        "pembimbing_2_id" => $proposal->dosen_pembimbing_2_id,
                        "penguji_1_id" => $proposal->penguji_sidang_ta_1_id,
                        "penguji_2_id" => $proposal->penguji_sidang_ta_2_id,

                        // Nilai Pembimbing 1
                        "nilai_sikap_pemb1" => $nilaiSikapPemb1,
                        "nilai_kemampuan_pemb1" => $nilaiKemampuanPemb1,
                        "nilai_hasilKarya_pemb1" => $nilaiHasilKaryaPemb1,
                        "nilai_laporan_pemb1" => $nilaiLaporanPemb1,
                        "avg_nilai_dospem1" => $avgNilaiDospem1,

                        // Nilai Pembimbing 2
                        "nilai_sikap_pemb2" => $nilaiSikapPemb2,
                        "nilai_kemampuan_pemb2" => $nilaiKemampuanPemb2,
                        "nilai_hasilKarya_pemb2" => $nilaiHasilKaryaPemb2,
                        "nilai_laporan_pemb2" => $nilaiLaporanPemb2,
                        "avg_nilai_dospem2" => $avgNilaiDospem2,

                        // Nilai Penguji 1
                        "nilai_penguasaan_materi1" => $nilaiPenguasaanMateriPeng1,
                        "nilai_presentasi1" => $nilaiPresentasiPeng1,
                        "nilai_karya_tulis1" => $nilaiKaryaTulisPeng1,
                        "avg_nilai_penguji1" => $avgNilaiPenguji1,

                        // Nilai Penguji 2
                        "nilai_penguasaan_materi2" => $nilaiPenguasaanMateriPeng2,
                        "nilai_presentasi2" => $nilaiPresentasiPeng2,
                        "nilai_karya_tulis2" => $nilaiKaryaTulisPeng2,
                        "avg_nilai_penguji2" => $avgNilaiPenguji2,

                        // Nilai Total Pembimbing
                        "avg_nilai_totalDospem" => $nilaiTotalPembimbing,

                        // Nilai Total Penguji
                        "avg_nilai_totalPenguji" => $nilaiTotalPenguji
                    ]);
                }

                if ($nilaiSementaraSemhas == 2) {
                    // Revisi Penguji 1
                    Revisi::create([
                        "proposal_id" => $proposal->id,
                        "dosen_id" => $proposal->penguji_sidang_ta_1_id,
                        "jenis_revisi" => "semhas",
                        "catatan_revisi" => $faker->text(200),
                        "file_proposal_revisi" => "seminar-hasil/revisi/proposal/proposal.pdf",
                        "file_lembar_revisi_dosen" => "seminar-hasil/revisi/lembar-revisi-penguji-1/lembar-revisi-penguji-1.pdf",
                        "status" => "diterima"
                    ]);

                    // Revisi Penguji 2
                    Revisi::create([
                        "proposal_id" => $proposal->id,
                        "dosen_id" => $proposal->penguji_sidang_ta_2_id,
                        "jenis_revisi" => "semhas",
                        "catatan_revisi" => $faker->text(200),
                        "file_proposal_revisi" => "seminar-hasil/revisi/proposal/proposal.pdf",
                        "file_lembar_revisi_dosen" => "seminar-hasil/revisi/lembar-revisi-penguji-2/lembar-revisi-penguji-2.pdf",
                        "status" => "diterima"
                    ]);

                    // Revisi Pembimbing 1
                    Revisi::create([
                        "proposal_id" => $proposal->id,
                        "dosen_id" => $proposal->dosen_pembimbing_1_id,
                        "jenis_revisi" => "semhas",
                        "catatan_revisi" => $faker->text(200),
                        "file_proposal_revisi" => "seminar-hasil/revisi/proposal/proposal.pdf",
                        "file_lembar_revisi_dosen" => "seminar-hasil/revisi/lembar-revisi-pembimbing-1/lembar-revisi-pembimbing-1.pdf",
                        "status" => "diterima"
                    ]);

                    // Revisi Pembimbing 2
                    Revisi::create([
                        "proposal_id" => $proposal->id,
                        "dosen_id" => $proposal->dosen_pembimbing_1_id,
                        "jenis_revisi" => "semhas",
                        "catatan_revisi" => $faker->text(200),
                        "file_proposal_revisi" => "seminar-hasil/revisi/proposal/proposal.pdf",
                        "file_lembar_revisi_dosen" => "seminar-hasil/revisi/lembar-revisi-pembimbing-2/lembar-revisi-pembimbing-2.pdf",
                        "status" => "diterima"
                    ]);
                }
            });
        });
    }
}
