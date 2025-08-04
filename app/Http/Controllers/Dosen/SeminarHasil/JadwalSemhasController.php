<?php

namespace App\Http\Controllers\Dosen\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarHasil;
use App\Models\Periode;
use App\Models\Tahap;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalSemhasController extends Controller
{
    public function showBerandaJadwalPage(): View
    {
        $listTahap = Tahap::all();

        return view("dosen.seminar-hasil.beranda-jadwal", compact('listTahap'));
    }

    public function showJadwalPage(Request $request, int $tahapId): View
    {
        $tahap = Tahap::findOrFail($tahapId);
        $listPeriode = Periode::all();
        $idDosen = auth("dosen")->id();

        $jadwalSeminarHasilD3 = JadwalSeminarHasil::whereHas('proposal', function ($query) use ($idDosen, $tahapId) {
            $query->where(function($q) use ($idDosen) {
                $q->where('dosen_pembimbing_1_id', $idDosen)
                    ->orWhere('dosen_pembimbing_2_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_1_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_2_id', $idDosen);

            })
                ->where('prodi_id', 1)
                ->where('tahap_id', $tahapId)
                ->where('periode_id', 1);
        })
            ->with('proposal.proposalMahasiswas')
            ->get();

        $jadwalSeminarHasilD4 = JadwalSeminarHasil::whereHas('proposal', function ($query) use ($idDosen, $tahapId) {
            $query->where(function($q) use ($idDosen) {
                $q->where('dosen_pembimbing_1_id', $idDosen)
                    ->orWhere('dosen_pembimbing_2_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_1_id', $idDosen)
                    ->orWhere('penguji_sidang_ta_2_id', $idDosen);

            })
                ->where('prodi_id', 2)
                ->where('tahap_id', $tahapId)
                ->where('periode_id', 1);
        })
            ->with('proposal.proposalMahasiswas')
            ->get();

        return view(
            "dosen.seminar-hasil.jadwal", 
            compact('tahap', 'listPeriode', 'jadwalSeminarHasilD3', 'jadwalSeminarHasilD4')
        );
    }
}
