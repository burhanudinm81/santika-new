<?php

namespace Database\Seeders;

use App\Models\JenisJudul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisJudulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
       JenisJudul::create([
           "jenis" => "Mandiri"
       ]);
       JenisJudul::create([
           "jenis" => "Mitra"
       ]);
       JenisJudul::create([
           "jenis" => "Rekomendasi"
       ]);
    }
}
