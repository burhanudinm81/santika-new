<?php

namespace Database\Seeders;

use App\Models\StatusProposalMahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusProposalMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status1 = new StatusProposalMahasiswa();
        $status1->status = "Diterima";
        $status1->save();

        $status2 = new StatusProposalMahasiswa();
        $status2->status = "Ditolak";
        $status2->save();

        $status3 = new StatusProposalMahasiswa();
        $status3->status = "Belum Dicek";
        $status3->save();
    }
}
