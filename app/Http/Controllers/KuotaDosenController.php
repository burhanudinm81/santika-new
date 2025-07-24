<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KuotaDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class KuotaDosenController extends Controller
{
    public function showKuotaDosenPage(): View
    {
        Log::info("Halaman Kuota Dosen Panitia dijalankan");
        return view("panitia.kuota-dosen");
    }

    /**
     * Mengambil data untuk ditampilkan di tabel via AJAX.
     * Mendukung filter berdasarkan prodi dan pencarian nama.
     */
    public function getData(Request $request)
    {
        // Validasi request untuk memastikan prodi_id ada
        $request->validate([
            'prodi_id' => 'required|exists:prodi,id'
        ]);

        $searchQuery = $request->search;
        $prodiId = $request->prodi_id;

        // Tentukan kolom kuota mana yang akan diambil berdasarkan prodi_id
        $kolomKuota = ($prodiId == 1) ? 'kuota_pembimbing_1_D3' : 'kuota_pembimbing_1_D4';

        $kuotaQuery = KuotaDosen::query()
            ->whereHas('dosen', function ($dosenQuery) use ($searchQuery, $prodiId) {

                if (!empty($searchQuery)) {
                    $dosenQuery->where('nama', 'like', '%' . $searchQuery . '%');
                }
            })
            ->with('dosen');

        $kuotaCollection = $kuotaQuery->get();

        $results = $kuotaCollection->map(function ($kuotaDosen) use ($kolomKuota) {
            return [
                'id' => $kuotaDosen->id,
                'nama' => $kuotaDosen->dosen->nama,
                'kuota' => $kuotaDosen->$kolomKuota,
            ];
        });

        return response()->json($results);
    }

    /**
     * Mengupdate kuota seorang dosen.
     */
    public function update(Request $request, KuotaDosen $kuota_dosen)
    {
        $validator = Validator::make($request->all(), [
            'kuota_d3' => 'nullable|integer|min:0',
            'kuota_d4' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Tentukan kolom mana yang akan diupdate
        if ($request->has('kuota_d3')) {
            $kuota_dosen->kuota_pembimbing_1_D3 = $request->kuota_d3;
        }
        if ($request->has('kuota_d4')) {
            $kuota_dosen->kuota_pembimbing_1_D4 = $request->kuota_d4;
        }

        $kuota_dosen->save();

        return response()->json([
            'success' => true,
            'message' => 'Kuota dosen berhasil diperbarui!'
        ]);
    }

    public function resetKuotaDosen(Request $request)
    {
        $request->validate([
            "prodi_id" => "required|integer|exists:prodi,id",
            "jenis_kuota" => "required|integer|between:1,6",
            "kuota" => "required|integer|min:1|max:255"
        ]);

        $allKuotaDosen = KuotaDosen::all();
        $prodiId = $request->prodi_id;
        $jenisKuota = $request->jenis_kuota;
        $kuota = $request->kuota;

        if ($prodiId == 1) {
            $allKuotaDosen->each(function (KuotaDosen $kuotaDosen, $key) use ($jenisKuota, $kuota) {
                switch ($jenisKuota) {
                    case 1:
                        // Reset Kuota Pembimbing 1 D3
                        $kuotaDosen->kuota_pembimbing_1_D3 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 2:
                        // Reset Kuota Pembimbing 2 D3
                        $kuotaDosen->kuota_pembimbing_2_D3 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 3:
                        // Reset Kuota Penguji Sempro 1 D3
                        $kuotaDosen->kuota_penguji_sempro_1_D3 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 4:
                        // Reset Kuota Penguji Sempro 2 D3
                        $kuotaDosen->kuota_penguji_sempro_2_D3 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 5:
                        // Reset Kuota Penguji Sidang TA 1 D3
                        $kuotaDosen->kuota_penguji_sidang_TA_1_D3 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 6:
                        // Reset Kuota Penguji Sidang TA 2 D3
                        $kuotaDosen->kuota_penguji_sidang_TA_2_D3 = $kuota;
                        $kuotaDosen->save();
                        break;
                }
            });
        } else {
            $allKuotaDosen->each(function (KuotaDosen $kuotaDosen, $key) use ($jenisKuota, $kuota) {
                switch ($jenisKuota) {
                    case 1:
                        // Reset Kuota Pembimbing 1 D4
                        $kuotaDosen->kuota_pembimbing_1_D4 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 2:
                        // Reset Kuota Pembimbing 2 D4
                        $kuotaDosen->kuota_pembimbing_2_D4 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 3:
                        // Reset Kuota Penguji Sempro 1 D4
                        $kuotaDosen->kuota_penguji_sempro_1_D4 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 4:
                        // Reset Kuota Penguji Sempro 2 D4
                        $kuotaDosen->kuota_penguji_sempro_2_D4 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 5:
                        // Reset Kuota Penguji Sidang TA 1 D4
                        $kuotaDosen->kuota_penguji_sidang_TA_1_D4 = $kuota;
                        $kuotaDosen->save();
                        break;
                    case 6:
                        // Reset Kuota Penguji Sidang TA 2 D4
                        $kuotaDosen->kuota_penguji_sidang_TA_2_D4 = $kuota;
                        $kuotaDosen->save();
                        break;
                }
            });
        }

        return redirect()->back()->with(["success" => "Berhasil Mereset Kuota Dosen"]);
    }
}
