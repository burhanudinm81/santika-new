<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\KuotaDosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KuotaDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allDosen = Dosen::all();
        foreach ($allDosen as $dosen) {
            $kuota = new KuotaDosen();
            $kuota->kuota_pembimbing_1_D3 = 5;
            $kuota->kuota_pembimbing_1_D4 = 5;
            $kuota->kuota_pembimbing_2_D3 = 5;
            $kuota->kuota_pembimbing_2_D4 = 5;

            $kuota->kuota_penguji_sempro_1_D3 = 8;
            $kuota->kuota_penguji_sempro_1_D4 = 8;
            $kuota->kuota_penguji_sempro_2_D3 = 8;
            $kuota->kuota_penguji_sempro_2_D4 = 8;

            $kuota->kuota_penguji_sidang_TA_1_D3 = 8;
            $kuota->kuota_penguji_sidang_TA_1_D4 = 8;
            $kuota->kuota_penguji_sidang_TA_2_D3 = 8;
            $kuota->kuota_penguji_sidang_TA_2_D4 = 8;
            $dosen->kuotaDosen()->save($kuota);
        }
    }
}
