<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBannedUser
{
    /**
     * MENYARING SETIAP REKUES HALAMAN DARI USER TERBLOKIR
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Periksa apakah ada pengguna yang sedang dalam posisi login
        if (Auth::check()) {
            $user = Auth::user();

            // 2. KUNCI REAL-TIME: Jika namanya mengandung teks [DIBLOKIR]
            if (str_contains($user->name, '[DIBLOKIR]')) {
                
                // Keluarkan paksa sesi loginnya saat itu juga
                Auth::logout();

                // Hancurkan session token agar tidak bisa di-refresh backdoor
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Lempar kembali ke gerbang login dengan pesan peringatan tegas
                return redirect()->route('login')->withErrors([
                    'nisn_or_nip' => 'Hak akses Anda telah dicabut/ditangguhkan oleh Staff Sarpras sekolah karena terindikasi melakukan pelanggaran!'
                ]);
            }
        }

        return $next($request);
    }
}
