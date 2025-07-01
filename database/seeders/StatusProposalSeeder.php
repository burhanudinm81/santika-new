<?php

namespace Database\Seeders;

use App\Models\StatusProposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status1 = new StatusProposal();
        $status1->status = "Diterima tanpa revisi";
        $status1->save();

        $status2 = new StatusProposal();
        $status2->status = "Diterima dengan revisi";
        $status2->save();

        $status3 = new StatusProposal();
        $status3->status = "Ditolak";
        $status3->save();
    }
}
