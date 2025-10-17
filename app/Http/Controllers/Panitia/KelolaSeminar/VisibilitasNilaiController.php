<?php

namespace App\Http\Controllers\Panitia\KelolaSeminar;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisibilitasNilaiRequest;
use App\Models\VisibilitasNilai;
use Illuminate\Http\Request;

class VisibilitasNilaiController extends Controller
{
    public function publishNilai(VisibilitasNilaiRequest $request)
    {
        $visibilitasNilai = VisibilitasNilai::where('tahap_id', $request->tahap_id)
            ->where('periode_id', $request->periode_id)
            ->where('jenis_nilai_seminar', $request->jenis_nilai_seminar)
            ->first();

        if($visibilitasNilai) {
            $visibilitasNilai->visibilitas = true;
            $visibilitasNilai->save();
        } else {
            VisibilitasNilai::create([
                'tahap_id' => $request->tahap_id,
                'periode_id' => $request->periode_id,
                'jenis_nilai_seminar' => $request->jenis_nilai_seminar,
                'visibilitas' => true,
            ]);
        }

        return back()->with('success', 'Berhasil mempublikasikan nilai seminar.');
    }

    public function hideNilai(VisibilitasNilaiRequest $request)
    {
        $visibilitasNilai = VisibilitasNilai::where('tahap_id', $request->tahap_id)
            ->where('periode_id', $request->periode_id)
            ->where('jenis_nilai_seminar', $request->jenis_nilai_seminar)
            ->first();

        if($visibilitasNilai) {
            $visibilitasNilai->visibilitas = false;
            $visibilitasNilai->save();
        } else {
            VisibilitasNilai::create([
                'tahap_id' => $request->tahap_id,
                'periode_id' => $request->periode_id,
                'jenis_nilai_seminar' => $request->jenis_nilai_seminar,
                'visibilitas' => false,
            ]);
        }

        return back()->with('success', 'Berhasil menyembunyikan nilai seminar.');
    }
}
