<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            ProdiSeeder::class,
            JabatanPanitiaSeeder::class,
            BidangMinatSeeder::class,
            JenisJudulSeeder::class,
            TahapSeeder::class,
            PeriodeSeeder::class,
            DosenSeeder::class,
            KuotaDosenSeeder::class,
            AdminProdiSeeder::class,
            MahasiswaSeeder::class,
            PanitiaSeeder::class
        ]);
    }
}
