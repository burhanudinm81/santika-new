<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Panitia;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function showDashboardPage(Request $request): View
    {
        $belumSempro = ProposalDosenMahasiswa::where('status_proposal_mahasiswa_id', 3)->count();
        $sudahSempro = ProposalDosenMahasiswa::where('status_proposal_mahasiswa_id', 1)->count();

        // Jika request datang dari user dengan role mahasiswa tampilkan dashboard mahasiswa
        if ($request->session()->get("role") == "mahasiswa")
            return view("mahasiswa.dashboard", compact('belumSempro', 'sudahSempro'));

        // Jika request datang dari user dengan role dosen, jalankan blok kode berikut
        if ($request->session()->get("role") == "dosen") {
            $dosenId = Auth::guard('dosen')->id();

            // Lakukan pengecekan ke tabel panitia
            $isPanitia = Panitia::where('dosen_id', $dosenId)->exists();

            // Jika dosen adalah panitia, tampilkan dashboard panitia
            if ($isPanitia) {
                return view("panitia.dashboard");
            }

            // Jika Dosen buka panitia,  tampilkan dashboard dosen
            return view("dosen.dashboard");
        }


        // Jika request datang bukan dari user dengan role mahasiswa atau dosen tampilan dashboard admin prodi
        return view("admin-prodi.dashboard");
    }
}
