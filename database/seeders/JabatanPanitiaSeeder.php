<?php

namespace Database\Seeders;

use App\Models\JabatanPanitia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanPanitiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanPanitia1 = new JabatanPanitia();
        $jabatanPanitia1->jabatan = "Ketua Pelaksana";
        $jabatanPanitia1->save();

        $jabatanPanitia2 = new JabatanPanitia();
        $jabatanPanitia2->jabatan = "Anggota Pelaksana 1";
        $jabatanPanitia2->save();

        $jabatanPanitia3 = new JabatanPanitia();
        $jabatanPanitia3->jabatan = "Anggota Pelaksana 2";
        $jabatanPanitia3->save();

        $jabatanPanitia4 = new JabatanPanitia();
        $jabatanPanitia4->jabatan = "Anggota Pelaksana 3";
        $jabatanPanitia4->save();
    }
}
