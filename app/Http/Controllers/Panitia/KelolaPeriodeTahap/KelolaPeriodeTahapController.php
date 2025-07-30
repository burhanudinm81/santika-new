<?php

namespace App\Http\Controllers\Panitia\KelolaPeriodeTahap;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeriodeRequest;
use App\Models\Periode;
use App\Models\Tahap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KelolaPeriodeTahapController extends Controller
{
    public function tambahTahap(): RedirectResponse
    {
        $tahapTerakhir = Tahap::orderByDesc('id')->first()->tahap;
        Tahap::create([
            "tahap" => ++$tahapTerakhir,
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);

        return back()->with([
            "message" => "Berhasil Menambah Tahap $tahapTerakhir!"
        ]);
    }

    public function tambahPeriode(StorePeriodeRequest $request): RedirectResponse
    {
        $periode = $request->periode;
        Periode::create([
            "tahun" => $periode,
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);

        return back()->with([
            "success" => "Berhasil Menambah Periode $periode!"
        ]);
    }
}
