<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PanitiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dosen untuk Panitia D3
        $dosenPotocki = Dosen::firstWhere('nama', 'Potocki');
        $dosenBadeni = Dosen::firstWhere('nama', 'Badeni');
        $dosenStark = Dosen::firstWhere('nama', 'Stark');
        $dosenArnold = Dosen::firstWhere('nama', 'Arnold');
        
        // Dosen untuk Panitia D4
        $dosenSamsul = Dosen::firstWhere('nidn', '20021001006');
        $dosenAgus = Dosen::firstWhere('nidn', '20021001007');
        $dosenJoko = Dosen::firstWhere('nidn', '20021001008');
        $dosenBudi = Dosen::firstWhere('nidn', '20021001009');

        // Id Prodi
        $prodiD3Id = Prodi::firstWhere("prodi", "D3 Teknik Telekomunikasi")->id;
        $prodiD4Id = Prodi::firstWhere("prodi", "D4 Jaringan Telekomunikasi Digital")->id;

        // Jabatan Panitia
        $ketuaPelaksanaId = 1;
        $anggotaPelaksana1 = 2;
        $anggotaPelaksana2 = 3;
        $anggotaPelaksana3 = 4;

        // Panitia D3
        $dosenPotocki->panitia()->create([
            'prodi_id' => $prodiD3Id,
            'jabatan_panitia_id' => $ketuaPelaksanaId,
        ]);
        $dosenBadeni->panitia()->create([
            'prodi_id' => $prodiD3Id,
            'jabatan_panitia_id' => $anggotaPelaksana1,
        ]);
        $dosenStark->panitia()->create([
            'prodi_id' => $prodiD3Id,
            'jabatan_panitia_id' => $anggotaPelaksana2,
        ]);
        $dosenArnold->panitia()->create([
            'prodi_id' => $prodiD3Id,
            'jabatan_panitia_id' => $anggotaPelaksana3,
        ]);

        // Panitia D4
        $dosenSamsul->panitia()->create([
            'prodi_id' => $prodiD4Id,
            'jabatan_panitia_id' => $ketuaPelaksanaId,
        ]);
        $dosenAgus->panitia()->create([
            'prodi_id' => $prodiD4Id,
            'jabatan_panitia_id' => $anggotaPelaksana1,
        ]);
        $dosenJoko->panitia()->create([
            'prodi_id' => $prodiD4Id,
            'jabatan_panitia_id' => $anggotaPelaksana2,
        ]);
        $dosenBudi->panitia()->create([
            'prodi_id' => $prodiD4Id,
            'jabatan_panitia_id' => $anggotaPelaksana3,
        ]);
    }
}
