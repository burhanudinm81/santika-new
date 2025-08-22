<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaPengujianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasList = ['4A', '4B', '4C', '4D', '4E', '4F', '4G'];
        for ($id = 1; $id <= 30; $id++) {
            Mahasiswa::create([
                'id' => $id,
                'nim' => strval(21210000 + $id - 200),
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
