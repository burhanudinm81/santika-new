<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaD4ForJadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasList = ['4A', '4B', '4C', '4D', '4E', '4F', '4G'];
        for ($id = 201; $id <= 300; $id++) {
            Mahasiswa::create([
                'id' => $id,
                'nim' => strval(20210000 + $id - 200),
                'nama' => 'Mahasiswa ' . $id,
                'password' => Hash::make('password123'),
                'prodi_id' => 2,
                'periode_id' => 1,
                'kelas' => $kelasList[array_rand($kelasList)],
                'angkatan' => 2021,
            ]);
        }
    }
}
