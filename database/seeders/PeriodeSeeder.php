<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Periode::create([
            "tahun" => "2024/2025",
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);

        Periode::create([
            "tahun" => "2025/2026",
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);
    }
}
