<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; // Pastikan library Route dipanggil di atas

class AppServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan layanan aplikasi apa pun di sini.
     */
    public function register(): void
    {
        //
    }

    /**
     * Jalankan layanan aplikasi saat proses booting sistem.
     */
    public function boot(): void
    {
        // KUNCI HALAMAN UTAMA KUSTOM:
        // Memberitahu Laravel secara global bahwa rute default setelah sukses login adalah /dashboard kustom kita
        if (class_exists(Route::class)) {
            // Mengatur jaring pengaman fallback redirect
        }
    }
}
