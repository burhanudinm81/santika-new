<?php

namespace Database\Seeders;

use App\Models\StatusLogbook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusLogbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusLogbook::create([
            'id' => 1,
            'status' => "Belum Diverifikasi"
        ]);
        StatusLogbook::create([
            'id' => 2,
            'status' => "Ditolak"
        ]);
        StatusLogbook::create([
            'id' => 3,
            'status' => "Telah Diverifikasi"
        ]);
    }
}
