<?php

namespace Database\Seeders;

use App\Models\AdminProdi;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiD3 = Prodi::firstWhere("prodi", "D3 Teknik Telekomunikasi");
        $prodiD4 = Prodi::firstWhere("prodi", "D4 Jaringan Telekomunikasi Digital");

        AdminProdi::create([
            "nama" => "admin-D3",
            "password" => Hash::make("password123"),
            "prodi_id" => $prodiD3->id
        ]);

        AdminProdi::create([
            "nama" => "admin-D4",
            "password" => Hash::make("password456"),
            "prodi_id" => $prodiD4->id
        ]);
    }
}
