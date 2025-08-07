<?php

namespace App\Http\Controllers\Panitia\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;

class AjaxRekapNilaiSemhasController extends Controller
{
    // ambil rekap nilai by periode, tahap, dan prodi dosen/panitia
    public function listRekapNilaiSemhas(Request $request)
    {
        $tahapId = $request->input('tahap_id');
        $periodeId = $request->input('periode_id');
        $prodiDosenPanitiaId = $request->input('prodi_panitia_id');

        // filter ke tabel proposal yang pendaftaran_sempro_id != null, status_sempro_proposal_id != null (berarti sudah melakukan sempro dan dinilai penguji)
        $proposalDoneSemhas = Proposal::with(['proposalMahasiswas.mahasiswa', 'statusSemhasTotal'])
            ->where('tahap_id', $tahapId)
            ->where('prodi_id', $prodiDosenPanitiaId)
            ->where('periode_id', $periodeId)
            ->where('pendaftaran_semhas_id', '!=', null)
            ->where('status_semhas_proposal_id', '!=', null)
            ->get();

        return response()->json($proposalDoneSemhas);
    }
}
