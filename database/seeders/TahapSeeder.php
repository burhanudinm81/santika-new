<?php

namespace Database\Seeders;

use App\Models\Tahap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tahap::create([
            "tahap" => 1
        ]);

        Tahap::create([
            "tahap" => 2
        ]);

        Tahap::create([
            "tahap" => 3
        ]);

        Tahap::create([
            "tahap" => 4
        ]);
    }
}
