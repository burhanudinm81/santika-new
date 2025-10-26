<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiD3 = Prodi::firstWhere("prodi", "D3 Teknik Telekomunikasi");
        $prodiD4 = Prodi::firstWhere("prodi", "D4 Jaringan Telekomunikasi Digital");
        $periode2025 = Periode::firstWhere("tahun", "2024/2025");

        // Mahasiswa D4
        Mahasiswa::create([
            "nim" => "2141160140",
            "nama" => "Muhammad Burhanudin",
            "password" => Hash::make("burhan123"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4G",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2141160091",
            "nama" => "Dwiki Raditya Krisdyanto",
            "password" => Hash::make("dwiki123"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4D",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2141160016",
            "nama" => "Tapta Arif Saputra",
            "password" => Hash::make("tapta123"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4F",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2141160041",
            "nama" => "Dewi Vista Oktaviani Napitupulu",
            "password" => Hash::make("dewi1234"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4C",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2141160111",
            "nama" => "Bafian Atha Fiddin",
            "password" => Hash::make("bafian123"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4C",
            "angkatan" => 2021
        ]);

        // Mahasiswa D3
        Mahasiswa::create([
            "nim" => "2141720091",
            "nama" => "Samsul Kopling",
            "password" => Hash::make("samsul123"),
            "prodi_id" => $prodiD3->id,
            "periode_id" => $periode2025->id,
            "kelas" => "3G",
            "angkatan" => 2022
        ]);

        Mahasiswa::create([
            "nim" => "2141720092",
            "nama" => "Udin Perseneleng",
            "password" => Hash::make("udin1234"),
            "prodi_id" => $prodiD3->id,
            "periode_id" => $periode2025->id,
            "kelas" => "3G",
            "angkatan" => 2022
        ]);

        Mahasiswa::create([
            "nim" => "2141720093",
            "nama" => "Marc Marquez",
            "password" => Hash::make("marc1234"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4H",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2141720094",
            "nama" => "Pecco Bagnaia",
            "password" => Hash::make("pecco123"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4H",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2141720095",
            "nama" => "Jorge Martin",
            "password" => Hash::make("jorge123"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4H",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2141720096",
            "nama" => "Alex Marques",
            "password" => Hash::make("alex1234"),
            "prodi_id" => $prodiD4->id,
            "periode_id" => $periode2025->id,
            "kelas" => "4H",
            "angkatan" => 2021
        ]);

        Mahasiswa::create([
            "nim" => "2241140141",
            "nama" => "Jolenta",
            "password" => Hash::make("rahasia2"),
            "prodi_id" => $prodiD3->id,
            "periode_id" => $periode2025->id,
            "kelas" => "3F",
            "angkatan" => 2022
        ]);

        Mahasiswa::create([
            "nim" => "2241140142",
            "nama" => "Thierry Nketiah",
            "password" => Hash::make("rahasia2"),
            "prodi_id" => $prodiD3->id,
            "periode_id" => $periode2025->id,
            "kelas" => "3F",
            "angkatan" => 2022
        ]);
    }
}
