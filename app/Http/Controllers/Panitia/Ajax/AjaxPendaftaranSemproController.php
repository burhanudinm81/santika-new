<?php

namespace App\Http\Controllers\Panitia\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranSemhas;
use App\Models\PendaftaranSeminarProposal;
use Illuminate\Http\Request;

class AjaxPendaftaranSemproController extends Controller
{
    //  Mengambil data pendaftaran sempro berdasarkan tahap dan periode
    public function listPendaftaranSempro(Request $request)
    {
        $tahapId = $request->input('tahap_id');
        $periodeId = $request->input('periode_id');
        $prodiDosenPanitiaId = $request->input('prodi_panitia_id');


        $listPendaftaranSempro = PendaftaranSeminarProposal::with('proposal.proposalMahasiswas.mahasiswa')
            ->whereRelation('proposal', 'tahap_id', $tahapId)
            ->whereRelation('proposal', 'prodi_id', $prodiDosenPanitiaId)
            ->whereRelation('proposal', 'periode_id', $periodeId)
            ->get();


        // dd($listPendaftaranSempro);

        return response()->json($listPendaftaranSempro);
    }

    public function listPendaftaranSemhas(Request $request)
    {
        $tahapId = $request->input('tahap_id');
        $periodeId = $request->input('periode_id');
        $prodiDosenPanitiaId = $request->input('prodi_panitia_id');

        $listPendaftaranSemhas = PendaftaranSemhas::with('proposal.proposalMahasiswas.mahasiswa')
            ->whereRelation('proposal', 'tahap_semhas_id', $tahapId)
            ->whereRelation('proposal', 'prodi_id', $prodiDosenPanitiaId)
            ->whereRelation('proposal', 'periode_semhas_id', $periodeId)
            ->get();

        return response()->json($listPendaftaranSemhas);
    }
}
