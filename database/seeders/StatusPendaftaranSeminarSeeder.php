<?php

namespace Database\Seeders;

use App\Models\StatusPendaftaranSeminar;
use App\Models\StatusPendaftaranSeminarProposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPendaftaranSeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status1 = new StatusPendaftaranSeminar();
        $status1->status = "Diterima";
        $status1->save();

        $status2 = new StatusPendaftaranSeminar();
        $status2->status = "Ditolak";
        $status2->save();

        $status3 = new StatusPendaftaranSeminar();
        $status3->status = "Belum Dicek";
        $status3->save();
    }
}
