<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prodi::create([
            'id' => 1,
            "prodi" => "D3 Teknik Telekomunikasi"
        ]);

        Prodi::create([
            'id' => 2,
            "prodi" => "D4 Jaringan Telekomunikasi Digital"
        ]);
    }
}
