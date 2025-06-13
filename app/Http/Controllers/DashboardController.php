<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function showDashboardPage(Request $request): View
    {
        // Jika request datang dari user dengan role mahasiswa tampilkan dashboard mahasiswa
        if ($request->session()->get("role") == "mahasiswa")
            return view("mahasiswa.dashboard");

        // Jika request datang dari user dengan role dosen dan user adalah panitia, tampilkan dashboard panitia
        // if($request->session()->get("role") == "dosen" && $request->user("dosen")->is_panitia)
        //     return view("panitia.dashboard");

        // Jika request datang dari user dengan role dosen tampilkan dashboard dosen
        if ($request->session()->get("role") == "dosen")
            return view("dosen.dashboard");

        // Jika request datang bukan dari user dengan role mahasiswa atau dosen tampilan dashboard admin prodi
        return view("admin-prodi.dashboard");
    }
}
