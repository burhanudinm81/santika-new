<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Panitia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginPage(): View
    {
        return view("auth.login");
    }

    public function handleLogin(Request $request): RedirectResponse
    {
        // Validasi username dan password
        // Jika username dan password tidak valid, redirect ke halaman sebelumnya
        $request->validate([
            "username" => "required|ascii",
            "password" => "required|ascii|min:8"
        ]);

        $credentials = $request->only(["username", "password"]);
        $rememberMe = $request->boolean("remember_me");

        if ($this->loginAsMahasiswa($credentials, $rememberMe)) {
            $request->session()->regenerate();
            $request->session()->put("role", "mahasiswa");

            return redirect()->route("mahasiswa.home");
        } else if ($this->loginAsDosen($credentials, $rememberMe)) {
            $isPanitia = false; // Defaultnya false

            // Mengambil ID Dosen
            $dosenId = Auth::guard('dosen')->id();
            // Cek ke database apakah ID dosen ada di tabel panitia
            $isPanitia = Panitia::where('dosen_id', $dosenId)->exists();

            $request->session()->regenerate();
            $request->session()->put("role", "dosen");
            $request->session()->put("is_panitia", $isPanitia);

            return redirect()->route("dosen.home");
        } else if ($this->loginAsAdminProdi($credentials, $rememberMe)) {
            $request->session()->regenerate();
            $request->session()->put("role", "admin-prodi");

            return redirect()->route("admin-prodi.home");
        }

        return back()->withErrors(["Username atau Password Salah"]);
    }

    private function loginAsAdminProdi(array $credentials, bool $rememberMe): bool
    {
        return Auth::attempt([
            "nama" => $credentials["username"],
            "password" => $credentials["password"]
        ], $rememberMe);
    }
    private function loginAsMahasiswa(array $credentials, bool $rememberMe): bool
    {
        return Auth::guard("mahasiswa")->attempt([
            "nim" => $credentials["username"],
            "password" => $credentials["password"],
            "deleted_at" => null
        ], $rememberMe);
    }

    private function loginAsDosen(array $credentials, bool $rememberMe): bool
    {
        return Auth::guard("dosen")->attempt([
            "nidn" => $credentials["username"],
            "password" => $credentials["password"],
            "deleted_at" => null
        ], $rememberMe);
    }
}
