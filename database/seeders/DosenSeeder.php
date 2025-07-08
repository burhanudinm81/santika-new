<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            "nidn" => "20021001001",
            "nama" => "Potocki",
            "nip" => "001122334455667788",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001002",
            "nama" => "Badeni",
            "nip" => "001122334455667789",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001003",
            "nama" => "Nowak",
            "nip" => "001122334455667001",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001004",
            "nama" => "Stark",
            "nip" => "001122334455667002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001005",
            "nama" => "Arnold",
            "nip" => "001122334455667003",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001006",
            "nama" => "Samsul Hadi Cahyono",
            "nip" => "001122334455667004",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001007",
            "nama" => "Kurniawan Agus",
            "nip" => "001122334455667005",
            "password" => Hash::make("password123")
        ]);

    Dosen::create([
            "nidn" => "20021001008",
            "nama" => "Joko Susanto",
            "nip" => "001122334455667006",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001009",
            "nama" => "Budi Aryawan",
            "nip" => "001122334455667007",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            "nidn" => "20021001010",
            "nama" => "Mangtab Pangalilo",
            "nip" => "001122334455667008",
            "password" => Hash::make("password123")
        ]);
    }
}
