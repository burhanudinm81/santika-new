<?php

namespace Database\Seeders;

use App\Models\StatusPendaftaranSeminarProposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPendaftaranSeminarProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status1 = new StatusPendaftaranSeminarProposal();
        $status1->status = "Diterima";
        $status1->save();

        $status2 = new StatusPendaftaranSeminarProposal();
        $status2->status = "Ditolak";
        $status2->save();

        $status3 = new StatusPendaftaranSeminarProposal();
        $status3->status = "Belum Dicek";
        $status3->save();
    }
}
