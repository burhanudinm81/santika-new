<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\KuotaDosen;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testSembarang(): void
    {
        $kuotaQuery = KuotaDosen::query()
            ->whereHas('dosen', function ($dosenQuery) {

                // if (!empty($searchQuery)) {
                //     $dosenQuery->where('nama', 'like', '%' . $searchQuery . '%');
                // }

                $dosenQuery->whereHas('panitia', function ($panitiaQuery) {
                    $panitiaQuery->where('prodi_id', 1);
                });

                // $dosenQuery->where('prodi_id', 1);
            })
            ->with('dosen');

        $kuotaCollection = $kuotaQuery->get();

        self::assertTrue(true);
        Log::info($kuotaCollection->toJson(JSON_PRETTY_PRINT));
    }
}
