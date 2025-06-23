<?php

namespace App\Http\Middleware;

use App\Models\Panitia;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPanitia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user yang login menggunakan guard 'dosen'
        if (Auth::guard('dosen')->check()) {
            
            $dosenId = Auth::guard('dosen')->id();

            // Lakukan pengecekan ke tabel panitia
            $isPanitia = Panitia::where('dosen_id', $dosenId)->exists();

            // Jika dosen tersebut adalah seorang panitia, izinkan request untuk melanjutkan
            if ($isPanitia) {
                return $next($request);
            }
        }

        // Jika user bukan dosen yang login atau bukan seorang panitia,
        // hentikan request dan redirect ke halaman lain dengan pesan error.
        
        // Menampilkan halaman error 403 (Forbidden)
        abort(403, 'AKSES DITOLAK. ANDA BUKAN PANITIA!');
    }
}
