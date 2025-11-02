<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Proposal;
use App\Models\Revisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class CustomIsiNilaiSemproSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->nilaiSamaRata();  
        $this->nilaiBervariasi();
    }

    public function nilaiSamaRata(): void
    {
        $prodiId = 1;       // Ganti dengan prodi_id yang diinginkan
        $tahapId = 1;       // Ganti dengan tahap_id yang diinginkan 
        $periodeId = 1;     // Ganti dengan periode_id yang diinginkan

        Proposal::where("tahap_id", $tahapId)
            ->where("periode_id", $periodeId)
            ->where("prodi_id", $prodiId)
            ->whereNotBetween("id", [218, 219])         // Aktifkan jika ingin mengecualikan beberapa proposal
            ->update([
                "status_sempro_penguji_1_id" => 1,
                "status_sempro_penguji_2_id" => 1,
                "status_sempro_proposal_id" => 1
            ]);
    }

    public function nilaiBervariasi(): void
    {
        $faker = Faker::create("id_ID");

        $prodiId = 2;       // Ganti dengan prodi_id yang diinginkan
        $tahapId = 1;       // Ganti dengan tahap_id yang diinginkan 
        $periodeId = 1;     // Ganti dengan periode_id yang diinginkan

        $daftarProposal = Proposal::where("tahap_id", $tahapId)
            ->where("periode_id", $periodeId)
            ->where("prodi_id", $prodiId)
            ->whereNotBetween("id", [220, 221])             // Aktifkan jika ingin mengecualikan beberapa proposal
            ->get();

        $daftarProposal->each(function($proposal) use ($faker) {
            $nilai = rand(1, 3);

            $proposal->status_sempro_penguji_1_id = $nilai;
            $proposal->status_sempro_penguji_2_id = $nilai;
            $proposal->status_sempro_proposal_id = $nilai;
            $proposal->save();

            if($nilai == 2){
                // Jika nilai Diterima Dengan Revisi -> Buatkan Catatan Revisi
                // Revisi Penguji 1
                Revisi::create([
                    "proposal_id" => $proposal->id,
                    "dosen_id" => $proposal->penguji_sempro_1_id,
                    "jenis_revisi" => "sempro",
                    "catatan_revisi" => $faker->sentence(6),
                    "file_proposal_revisi" => "seminar-proposal/revisi/proposal/proposal-revisi.pdf",
                    "file_lembar_revisi_dosen" => "seminar-proposal/revisi/lembar-revisi-penguji-1/lembar-revisi-penguji-1.pdf",
                    "status" => "diterima"
                ]);

                // Revisi Penguji 2
                Revisi::create([
                    "proposal_id" => $proposal->id,
                    "dosen_id" => $proposal->penguji_sempro_2_id,
                    "jenis_revisi" => "sempro",
                    "catatan_revisi" => $faker->sentence(6),
                    "file_proposal_revisi" => "seminar-proposal/revisi/proposal/proposal-revisi.pdf",
                    "file_lembar_revisi_dosen" => "seminar-proposal/revisi/lembar-revisi-penguji-2/lembar-revisi-penguji-2.pdf",
                    "status" => "diterima"
                ]);
            }
        });
    }
}
