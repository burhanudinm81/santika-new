<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        return view("dosen.home", [
            "forceChangePassword" => $forceChangePassword
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
