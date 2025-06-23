<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Panitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class HomePageController extends Controller
{
    public function adminProdi(): View
    {
        return view("admin-prodi.home");
    }
    public function mahasiswa(Request $request): View
    {
        $forceChangePassword = Hash::check(
            $request->user("mahasiswa")->NIM,
            $request->user("mahasiswa")->password
        );

        return view("mahasiswa.home", [
            "forceChangePassword" => $forceChangePassword
        ]);
    }

    public function dosen(Request $request): View
    {
        $forceChangePassword = Hash::check(
            $request->user("dosen")->NIDN,
            $request->user("dosen")->password
        );

        $isPanitia = false; // Defaultnya false

        // Mengambil ID Dosen
        $dosenId = Auth::guard('dosen')->id();
        // Cek ke database apakah ID dosen ada di tabel panitia
        $isPanitia = Panitia::where('dosen_id', $dosenId)->exists();

        return view("dosen.home", [
            "forceChangePassword" => $forceChangePassword,
            "isPanitia" => $isPanitia
        ]);
    }

    public function panitia(Request $request): View
    {
        $forceChangePassword = Hash::check(
            $request->user("dosen")->NIDN,
            $request->user("dosen")->password
        );

        return view("panitia.home", [
            "forceChangePassword" => $forceChangePassword
        ]);
    }
}
