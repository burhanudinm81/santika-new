<?php

namespace Database\Seeders;

use App\Models\Tahap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tahap::create([
            "tahap" => "1",
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);

        Tahap::create([
            "tahap" => "2",
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);

        Tahap::create([
            "tahap" => "3",
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);

        Tahap::create([
            "tahap" => "4",
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);
    }
}
