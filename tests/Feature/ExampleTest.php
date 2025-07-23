<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\JadwalSeminarProposal;
use App\Models\KuotaDosen;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testSembarang(): void
    {
        $listProposal = Proposal::whereHas('proposalMahasiswas', function ($query) {
            $query->where("status_proposal_mahasiswa_id", 1);
        })
            ->where("periode_id", 1)
            ->where("tahap_id", 1)
            ->where("prodi_id", 1)
            ->with([
                'proposalMahasiswas' => [
                    'mahasiswa',
                    'dosen'
                ]
            ])
            ->get();

        self::assertTrue(true);
        Log::info("List Proposal:");
        Log::info(json_encode($listProposal, JSON_PRETTY_PRINT));
    }
}
