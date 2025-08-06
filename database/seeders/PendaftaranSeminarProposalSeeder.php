<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proposal;
use App\Models\PendaftaranSeminarProposal;

class PendaftaranSeminarProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proposals = Proposal::all();

        foreach ($proposals as $proposal) {
            PendaftaranSeminarProposal::create([
                'proposal_id' => $proposal->id,
                'status_daftar_sempro_id' => 1,
                'file_proposal' => fake()->uuid . '.pdf',
                'lembar_konsultasi' => fake()->uuid . '.pdf',
                'lembar_kerjasama_mitra' => fake()->uuid . '.pdf',
                'bukti_cek_plagiasi' => fake()->uuid . '.pdf',
                'status_file_proposal' => true,
                'status_lembar_konsultasi' => true,
                'status_lembar_kerjasama_mitra' => $proposal->jenis_judul_id == 2 ? true : null,
                'status_bukti_cek_plagiasi' => true,
            ]);
        }

        $pendaftaranSempro = PendaftaranSeminarProposal::all();
        $pendaftaranSempro->each(function($item){
            $proposal = Proposal::find($item->proposal_id);
            $proposal->pendaftaran_sempro_id = $item->id;
            $proposal->save();
        });

    }
}
