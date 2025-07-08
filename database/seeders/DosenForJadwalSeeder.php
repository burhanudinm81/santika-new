<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DosenForJadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($id = 1; $id <= 50; $id++) {
            Dosen::create([
                'id' => $id,
                'nama' => 'Dosen ' . $id,
                'password' => Hash::make('password123'),
                'nidn' => strval(10000000 + $id),
                'nip' => strval(20000000 + $id),
            ]);
        }
    }
}
