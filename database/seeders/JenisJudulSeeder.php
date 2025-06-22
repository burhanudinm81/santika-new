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
           "jenis" => "WSN,IoT,Teknologi Pintar"
       ]);
       JenisJudul::create([
           "jenis" => "Protokol,Media, dan Teori Telekomunikasi"
       ]);
       JenisJudul::create([
           "jenis" => "Manajemen dan Keamanan Jaringan"
       ]);
    }
}
