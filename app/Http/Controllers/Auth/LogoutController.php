<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $role = $request->session()->get("role");

        if($role === "mahasiswa"){
            Auth::guard("mahasiswa")->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        else if($role === "dosen"){
            Auth::guard("dosen")->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        else if($role === "admin-prodi"){
            Log::info("Kode Ini Dijalankan");
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route("login");
    }
}
