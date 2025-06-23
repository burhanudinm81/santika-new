<?php

namespace App\Http\Controllers\Mahasiswa\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AjaxMahasiswaController extends Controller
{
    public function searchMahasiswa(Request $request)
    {
        $query = $request->input('q');

        $mahasiswa = Mahasiswa::where('prodi_id', 1)
            ->where('id', '!=', auth('mahasiswa')->user()->id)
            ->whereNotIn('id', function ($subQuery) {
                $subQuery->select('mahasiswa_id')
                    ->from('proposal_dosen_mahasiswa')
                    ->whereNotNull('mahasiswa_id');
            })
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('nama', 'like', '%' . $query . '%');
            })
            ->limit(20)
            ->get(['id', 'nim', 'nama']);

        return response()->json($mahasiswa);
    }

    public function searchCalonDosenPembimbing(Request $request)
    {

        $query = $request->input('q');

        $dosen = Dosen::where('nama', 'like', '%' . $query . '%')
            ->limit(20)
            ->get(['id', 'nama']);

        return response()->json($dosen);
    }
}
