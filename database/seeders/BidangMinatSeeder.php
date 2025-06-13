<?php

namespace Database\Seeders;

use App\Models\BidangMinat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangMinatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BidangMinat::create([
            "bidang_minat" => "WSN, IoT, Teknologi Pintar"
        ]);

        BidangMinat::create([
            "bidang_minat" => "Protokol, Media, dan Teori Telekomunikasi"
        ]);

        BidangMinat::create([
            "bidang_minat" => "Manajemen dan Keamanan Jaringan"
        ]);
    }
}
