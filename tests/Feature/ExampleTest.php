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
    //    $proposal = Proposal::orWhere([
    //         ["dosen_pembimbing_1_id", 1],
    //         ["penguji_sempro_1_id", 1],
    //         ["penguji_sempro_2_id", 1],
    //    ])->get();

        $jadwalSeminarProposal = JadwalSeminarProposal::whereHas('proposal', function ($query) {
            $query->where(function($q){
                $q->where('dosen_pembimbing_1_id', 1)
                    ->orWhere('penguji_sempro_1_id', 1)
                    ->orWhere('penguji_sempro_2_id', 1);
            })
                ->where('tahap_id', 2)
                ->where('periode_id', 1)
                ->where('prodi_id', 1);
        })
            ->with('proposal')
            ->get();

        self::assertTrue(true);
        Log::info("Jadwal Seminar Proposal:");
        Log::info(json_encode($jadwalSeminarProposal, JSON_PRETTY_PRINT));
    }
}
