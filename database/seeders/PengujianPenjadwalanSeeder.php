<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengujianPenjadwalanSeeder extends Seeder
{
    /**
     * FILE INI HANYA UNTUK PENGUJIAN PENJADWALAN BURHAN
     */
    public function run(): void
    {
        $this->call([
            DosenPengujianSeeder::class,
            DosenBidangMinatPengujianSeeder::class,
            MahasiswaPengujianSeeder::class,
            ProposalPengujian::class,
            ProposalDosenMahasiswaPengujian::class
        ]);
    }
}
