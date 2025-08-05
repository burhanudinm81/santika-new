<?php

namespace Database\Seeders;

use App\Models\DosenBidangMinat;
use App\Models\Proposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForJadwalPendaftaranSeminarHasilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proposal::all()->each(function ($proposal) {
            if ($proposal->id <= 216) {
                // Mengisi periode_semhas_id dan tahap_semhas_id
                $proposal->periode_semhas_id = $proposal->periode_id;
                $proposal->tahap_semhas_id = $proposal->tahap_id;

                // Cari dosen pembimbing 2 yang bidang minatnya sama dengan proposal
                $dosenPembimbing2 = DosenBidangMinat::where('bidang_minat_id', $proposal->bidang_minat_id)
                    ->where('dosen_id', '!=', $proposal->dosen_pembimbing_1_id)
                    ->inRandomOrder()
                    ->first();
                if ($dosenPembimbing2) {
                    $proposal->dosen_pembimbing_2_id = $dosenPembimbing2->dosen_id;
                }

                // Simpan perubahan pada proposal
                $proposal->save();

                // Buat pendaftaran seminar hasil
                $proposal->pendaftaranSemhas()->create([
                    'status_daftar_semhas_id' => 1,
                    'file_rekom_dospem' => fake()->sentence(),
                    'file_proposal_semhas' => fake()->sentence(),
                    'file_draft_jurnal' => fake()->sentence(),
                    'file_IA_mitra' => $proposal->jenis_judul_id == 2 ? fake()->sentence() : null,
                    'file_bebas_tanggungan_pkl' => fake()->sentence(),
                    'file_skla' => fake()->sentence(),
                    'status_file_rekom_dosen' => true,
                    'status_file_proposal_semhas' => true,
                    'status_file_draft_jurnal' => true,
                    'status_file_bebas_tanggungan_pkl' => true,
                    'status_file_skla' => true,
                ]);
            }
        });
    }
}
