<?php

namespace Database\Seeders;

use App\Models\DosenBidangMinat;
use App\Models\Proposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomPlotDosenPembimbing2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiId = 2;       // Ganti dengan prodi_id yang diinginkan
        $tahapId = 1;       // Ganti dengan tahap_id yang diinginkan 
        $periodeId = 1;     // Ganti dengan periode_id yang diinginkan

        $daftarProposal = Proposal::where("tahap_id", $tahapId)
            ->where("periode_id", $periodeId)
            ->where("prodi_id", $prodiId)
            ->whereNot("status_sempro_penguji_1_id", 3)
            ->whereNot("status_sempro_penguji_2_id", 3)
            ->whereNotBetween("id", [220])             // Aktifkan jika ingin mengecualikan beberapa proposal
            ->get();

        $daftarProposal->each(function ($proposal) {
            $dosenPembimbing2 = DosenBidangMinat::where('bidang_minat_id', $proposal->bidang_minat_id)
                ->where('dosen_id', '!=', $proposal->dosen_pembimbing_1_id)
                ->inRandomOrder()
                ->first();

            $proposal->dosen_pembimbing_2_id = $dosenPembimbing2->dosen_id;
            $proposal->save();
        });
    }
}
