<?php

namespace Database\Seeders;

use App\Models\PendaftaranSemhas;
use App\Models\Proposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomPendaftaranSeminarHasilSeeder extends Seeder
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
            ->whereNotNull("dosen_pembimbing_2_id")
            // ->whereNotBetween("id", [220])             // Aktifkan jika ingin mengecualikan beberapa proposal
            ->get();

        $daftarProposal->each(function($proposal){
            PendaftaranSemhas::create([
                "proposal_id" => $proposal->id,
                "status_daftar_semhas_id" => 1,
                "file_rekom_dospem" => "seminar-hasil/pendaftaran/rekomdosem/rekom-dospem.pdf",
                "file_proposal_semhas" => "seminar-hasil/pendaftaran/proposal-semhas/proposal-semhas.pdf",
                "file_draft_jurnal" => "seminar-hasil/pendaftaran/draft-journal/draft-jurnal.pdf",
                "file_bebas_tanggungan_pkl" => "seminar-hasil/pendaftaran/bebas-tanggungan-pkl/bebas-tanggungan-pkl.pdf",
                "file_skla" => "seminar-hasil/pendaftaran/skla/skla.pdf",
                "status_file_rekom_dosen" => true,
                "status_file_proposal_semhas" => true,
                "status_file_draft_jurnal" => true,
                "status_file_bebas_tanggungan_pkl" => true,
                "status_file_skla" => true
            ]);
        });
    }
}
