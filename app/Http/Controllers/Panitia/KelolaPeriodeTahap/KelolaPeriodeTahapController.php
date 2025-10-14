<?php

namespace App\Http\Controllers\Panitia\KelolaPeriodeTahap;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeriodeRequest;
use App\Http\Requests\StoreTahapRequest;
use App\Http\Requests\UpdatePeriodeAktifRequest;
use App\Http\Requests\UpdateTahapAktifRequest;
use App\Models\Periode;
use App\Models\Tahap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelolaPeriodeTahapController extends Controller
{
    public function showPengaturanPeriodeTahap(): View
    {
        $daftarPeriode = Periode::orderByDesc('tahun')->get();
        $daftarTahap = Tahap::orderBy('tahap')->get();

        $periodeAktif = $daftarPeriode->firstWhere('aktif_sempro', true);
        $tahapAktifSempro = $daftarTahap->firstWhere('aktif_sempro', true);
        $tahapAktifSidangTA = $daftarTahap->firstWhere('aktif_sidang_akhir', true);

        return view('panitia.pengaturan-seminar.index', compact('daftarPeriode', 'daftarTahap', 'periodeAktif', 'tahapAktifSempro', 'tahapAktifSidangTA'));
    }
    public function tambahTahap(StoreTahapRequest $request): RedirectResponse
    {
        $tahap = $request->tahap;
        Tahap::create([
            "tahap" => $tahap,
            "aktif_sempro" => false,
            "aktif_sidang_akhir" => false
        ]);

        return back()->with([
            "success" => "Berhasil Menambah Tahap $tahap!"
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

    public function gantiPeriodeAktif(UpdatePeriodeAktifRequest $request): RedirectResponse
    {
        // Nonaktifkan semua periode
        Periode::query()->update(['aktif_sempro' => false, 'aktif_sidang_akhir' => false]);

        // Aktifkan periode yang dipilih
        $periode = Periode::findOrFail($request->periode_id);
        $periode->update([
            'aktif_sempro' => true,
            'aktif_sidang_akhir' => true,
        ]);

        return back()->with([
            'success' => "Berhasil mengganti periode aktif ke $periode->tahun!"
        ]);
    }

    public function aturTahapSemproAktif(UpdateTahapAktifRequest $request): RedirectResponse
    {
        // Nonaktifkan semua tahap
        Tahap::query()->update(['aktif_sempro' => false]);

        // Aktifkan tahap yang dipilih
        $tahap = Tahap::findOrFail($request->tahap_id);
        $tahap->update(['aktif_sempro' => true]);

        return back()->with([
            'success' => "Berhasil mengaktifkan Seminar Proposal Tahap $tahap->tahap!"
        ]);
    }

    public function aturTahapSidangTAAktif(UpdateTahapAktifRequest $request): RedirectResponse
    {
        // Nonaktifkan semua tahap
        Tahap::query()->update(['aktif_sidang_akhir' => false]);

        // Aktifkan tahap yang dipilih
        $tahap = Tahap::findOrFail($request->tahap_id);
        $tahap->update(['aktif_sidang_akhir' => true]);

        return back()->with([
            'success' => "Berhasil mengaktifkan Sidang Tugas Akhir Tahap $tahap->tahap!"
        ]);
    }

    public function nonaktifkanTahapSempro(): RedirectResponse
    {
        // Nonaktifkan semua tahap
        Tahap::query()->update(['aktif_sempro' => false]);

        return back()->with([
            'success' => "Berhasil menonaktifkan tahap Seminar Proposal!"
        ]);
    }

    public function nonaktifkanTahapSidangTA(): RedirectResponse
    {
        // Nonaktifkan semua tahap
        Tahap::query()->update(['aktif_sidang_akhir' => false]);

        return back()->with([
            'success' => "Berhasil menonaktifkan tahap Sidang Tugas Akhir!"
        ]);
    }

    public function hapusTahap(UpdateTahapAktifRequest $request): RedirectResponse
    {
        $tahap = Tahap::findOrFail($request->tahap_id);
        $tahap->delete();

        return back()->with([
            'success' => "Berhasil menghapus Tahap $tahap->tahap!"
        ]);
    }
}
