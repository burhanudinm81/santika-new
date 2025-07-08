<?php

namespace Database\Seeders;

use App\Models\DosenBidangMinat;
use Illuminate\Database\Seeder;

class DosenBidangMinatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($dosen_id = 1; $dosen_id <= 50; $dosen_id++) {
            // Pilih bidang_minat_id pertama secara acak
            $bm1 = rand(1, 3);
            // Pilih bidang_minat_id kedua yang berbeda dengan pertama
            do {
                $bm2 = rand(1, 3);
            } while ($bm2 === $bm1);
            // Data pertama
            DosenBidangMinat::create([
                'dosen_id' => $dosen_id,
                'bidang_minat_id' => $bm1,
                'status_dosen_bidang_minat_id' => 1,
            ]);
            // Data kedua
            DosenBidangMinat::create([
                'dosen_id' => $dosen_id,
                'bidang_minat_id' => $bm2,
                'status_dosen_bidang_minat_id' => 2,
            ]);
            // Data ketiga (jika ingin menambah, harus berbeda dengan bm1 dan bm2)
            $bm3_candidates = array_diff([1,2,3], [$bm1, $bm2]);
            if (!empty($bm3_candidates) && rand(0,1)) {
                $bm3 = array_values($bm3_candidates)[0];
                DosenBidangMinat::create([
                    'dosen_id' => $dosen_id,
                    'bidang_minat_id' => $bm3,
                    'status_dosen_bidang_minat_id' => rand(1,2),
                ]);
            }
        }
    }
}
