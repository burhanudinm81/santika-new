<?php

namespace Database\Seeders;

use App\Models\JenisKegiatanLogbook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKegiatanLogbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisKegiatanLogbook::create(["nama_kegiatan" => "Eksperimen"]);
        JenisKegiatanLogbook::create(["nama_kegiatan" => "Survei"]);
        JenisKegiatanLogbook::create(["nama_kegiatan" => "Review Pustaka"]);
        JenisKegiatanLogbook::create(["nama_kegiatan" => "Diskusi Seminar"]);
    }
}
