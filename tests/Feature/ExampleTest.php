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
        $listProposal = Proposal::all();

        [$proposalD3, $proposalD4] = $listProposal->partition(function ($item) {
            return $item->id <= 100 || ($item->id > 200 && $item->id <= 208);
        });

        $proposalD3->each(function ($item) {
            $mahasiswaIds = ProposalDosenMahasiswa::where('proposal_id', $item->id)
                ->pluck('mahasiswa_id');

            Log::info("Mahasiswa ID: ");
            Log::info(json_encode($mahasiswaIds, JSON_PRETTY_PRINT));
        });

        $proposalD4->each(function ($item) {
            $mahasiswaId = ProposalDosenMahasiswa::where('proposal_id', $item->id)
                ->first()->mahasiswa_id;

            Log::info("Mahasiswa ID: $mahasiswaId");
        });

        self::assertTrue(true);
    }
}
