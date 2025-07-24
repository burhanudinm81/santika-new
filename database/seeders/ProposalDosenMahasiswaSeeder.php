<?php

namespace Database\Seeders;

use App\Models\ProposalDosenMahasiswa;
use App\Models\Proposal;
use Illuminate\Database\Seeder;

class ProposalDosenMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Untuk mahasiswa dengan id 1-200 (Mahasiswa D3)
        $id = 1;
        for ($proposal_id = 1; $proposal_id <= 100; $proposal_id++) {
            for ($i = 0; $i < 2; $i++) {
                $mahasiswa_id = ($proposal_id - 1) * 2 + $i + 1;
                $proposal = Proposal::find($proposal_id);
                if (!$proposal) continue;
                ProposalDosenMahasiswa::create([
                    'id' => $id,
                    'proposal_id' => $proposal_id,
                    'mahasiswa_id' => $mahasiswa_id,
                    'dosen_id' => $proposal->dosen_pembimbing_1_id,
                    'status_proposal_mahasiswa_id' => 1
                ]);
                $id++;
            }
        }
        // Untuk mahasiswa dengan id 201-300 (Mahasiswa D4)
        for ($proposal_id = 101; $proposal_id <= 200; $proposal_id++) {
            $mahasiswa_id = $proposal_id + 100;
            $proposal = Proposal::find($proposal_id);
            if (!$proposal) continue;
            ProposalDosenMahasiswa::create([
                'id' => $id,
                'proposal_id' => $proposal_id,
                'mahasiswa_id' => $mahasiswa_id,
                'dosen_id' => $proposal->dosen_pembimbing_1_id,
                'status_proposal_mahasiswa_id' => 1
            ]);
            $id++;
        }

        // Untuk mahasiswa dengan id 301-316 (Mahasiswa D3)
        for ($proposal_id = 201; $proposal_id <= 208; $proposal_id++) {
            for ($i = 0; $i < 2; $i++) {
                $mahasiswa_id = ($proposal_id - 1) + 100 + $i + 1;
                $proposal = Proposal::find($proposal_id);
                if (!$proposal) continue;
                ProposalDosenMahasiswa::create([
                    'id' => $id,
                    'proposal_id' => $proposal_id,
                    'mahasiswa_id' => $mahasiswa_id,
                    'dosen_id' => $proposal->dosen_pembimbing_1_id,
                    'status_proposal_mahasiswa_id' => 1
                ]);
                $id++;
            }
        }

        // Untuk mahasiswa dengan id 317-324 (Mahasiswa D4)
        for ($proposal_id = 209; $proposal_id <= 216; $proposal_id++) {
            $mahasiswa_id = $proposal_id + 108;
            $proposal = Proposal::find($proposal_id);
            if (!$proposal) continue;
            ProposalDosenMahasiswa::create([
                'id' => $id,
                'proposal_id' => $proposal_id,
                'mahasiswa_id' => $mahasiswa_id,
                'dosen_id' => $proposal->dosen_pembimbing_1_id,
                'status_proposal_mahasiswa_id' => 1
            ]);
            $id++;
        }
    }
}
