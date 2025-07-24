<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaD3ForJadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasList = ['3A', '3B', '3C', '3D', '3E', '3F', '3G'];
        for ($id = 1; $id <= 200; $id++) {
            Mahasiswa::create([
                'id' => $id,
                'nim' => strval(20220000 + $id),
                'nama' => 'Mahasiswa ' . $id,
                'password' => Hash::make('password123'),
                'prodi_id' => 1,
                'periode_id' => 1,
                'kelas' => $kelasList[array_rand($kelasList)],
                'angkatan' => 2022,
            ]);
        }

        // Mahasiswa Untuk Tahap 4
        for ($id = 301; $id <= 316; $id++) {
            Mahasiswa::create([
                'id' => $id,
                'nim' => strval(20220000 + $id),
                'nama' => 'Mahasiswa ' . $id,
                'password' => Hash::make('password123'),
                'prodi_id' => 1,
                'periode_id' => 1,
                'kelas' => $kelasList[array_rand($kelasList)],
                'angkatan' => 2022,
            ]);
        }
    }
}
