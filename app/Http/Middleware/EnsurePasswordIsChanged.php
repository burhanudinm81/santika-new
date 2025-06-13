<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;
        $username = null;
        
        Log::info("Middleware EnsurePasswordIsChange Dijalankan");

        // Cek guard mana yang sedang aktif
        if (Auth::guard('dosen')->check()) {
            $user = Auth::guard('dosen')->user();
            $username = $user->nidn;
        } elseif (Auth::guard('mahasiswa')->check()) {
            $user = Auth::guard('mahasiswa')->user();
            $username = $user->nim;
        }

        Log::info($user->toJson(JSON_PRETTY_PRINT));
        Log::info($username);

        // Jika user ditemukan dan passwordnya masih default
        if ($user && Hash::check($username, $user->password)) {
            
            // Jika user BELUM berada di halaman ganti password, paksa redirect
            if (!$request->routeIs('password.change.form')) {
                // Beri pesan flash untuk memberitahu user
                session()->flash('warning', 'Untuk keamanan, Anda wajib mengubah password default Anda terlebih dahulu.');
                return redirect()->route('password.change.form');
            }
        }
        
        // Jika password sudah aman atau bukan user dosen/mahasiswa, lanjutkan request
        return $next($request);
    }
}
