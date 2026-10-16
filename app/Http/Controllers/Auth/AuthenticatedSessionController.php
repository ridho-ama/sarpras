<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman form masuk (login) kustom.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani proses otentikasi login masuk secara real-time.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Eksekusi pencocokan NISN/NIP dan Password ke database
        $request->authenticate();

        // 2. Regenerasi session token untuk mencegah serangan hijacking
        $request->session()->regenerate();

        // 3. LOGIKA DIVERSIFIKASI PERAN: Mengarahkan user ke rumah dashboard-nya masing-masing
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Jika akun adalah Staff Sarpras / Admin, lempar ke panel admin utama
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika akun adalah warga sekolah (Siswa / Guru), lempar ke panel aduan pelapor
        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Menghancurkan sesi otentikasi login pengguna (Aksi Keluar/Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar dari sistem dengan aman.');
    }
}
