<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FacilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () { 
    return view('about');
})->name('user.about');


    // --- HALAMAN UTAMA DASHBOARD USER PELAPOR (SISWA / GURU) ---
    Route::get('/', [UserDashboardController::class, 'report'])->name('welcome');
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/create-report', [UserDashboardController::class, 'create'])->name('user.create-report');
    Route::get('/reports', [UserDashboardController::class, 'allReports'])->name('user.report.index');
    Route::get('/report/create', [UserDashboardController::class, 'index'])
        ->middleware(['auth', \App\Http\Middleware\CheckBannedUser::class])
        ->name('user.report.index');
    Route::post('/report/store', [UserDashboardController::class, 'store'])->name('user.report.store');
    Route::delete('/report/{id}/delete', [UserDashboardController::class, 'destroyUserReport'])->name('user.report.destroy');

























require __DIR__.'/auth.php';

Route::middleware(['auth', \App\Http\Middleware\CheckBannedUser::class])->group(function () {
    

Route::middleware(['auth'])->group(function () {
    // Pastikan ada akhiran ->name('user.profile') seperti di bawah ini:
    Route::get('/profil', [UserDashboardController::class, 'profile'])->name('user.profile');
    Route::post('/profile', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/laporan/detail/{id}', [UserDashboardController::class, 'show'])->name('user.show-report');    

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [AdminDashboardController::class, 'userProfileView'])->name('admin.profile');
    Route::patch('/profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
    });


























    // ===================================================================
    // SEKTOR ROUTE KHUSUS ADMIN (DILINDUNGI KEAMANAN MIDDLEWARE AUTH)
    // ===================================================================
    // --- DASHBOARD KENDALI UTAMA ADMIN ---
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');

    // --- MODUL MANAJEMEN BERKAS LAPORAN ADUAN GURU & SISWA ---
    Route::get('/admin/reports', [AdminDashboardController::class, 'allReports'])->name('admin.report.index');
    Route::get('/admin/reports/{id}', [AdminDashboardController::class, 'showReport'])->name('admin.show-report');
    Route::post('/admin/reports/{id}/update-status', [AdminDashboardController::class, 'updateStatus'])->name('admin.report.updateStatus');
    Route::delete('/admin/reports/{id}/destroy', [AdminDashboardController::class, 'destroyReport'])->name('admin.report.destroy');

    // --- MODUL MASTER MANAJEMEN FASILITAS SEKOLAH ---
    Route::get('/admin/facilities/index', [AdminDashboardController::class, 'facilitiesIndex'])->name('admin.facility.index');
    Route::post('/admin/facilities/store', [AdminDashboardController::class, 'facilitiesStore'])->name('admin.facility.store');
    Route::get('/admin/facilities/{id}', [AdminDashboardController::class, 'facilitiesShow'])->name('admin.facility.show');
    Route::put('/admin/facilities/{id}/update', [AdminDashboardController::class, 'adminUpdate'])->name('admin.facility.update');
    // Rute Hapus Sub-Fasilitas
    Route::delete('/{id}', [App\Http\Controllers\AdminDashboardController::class, 'destroy'])->name('admin.facility.destroy');
    // Rute Hapus Kategori Utama
    Route::delete('/category/{id}', [App\Http\Controllers\AdminDashboardController::class, 'destroy_category'])->name('admin.facility.destroy_category');

    // --- RUTE RAHASIA USER MANAGEMENT  ---
    Route::get('/admin/kelola-pengguna', [AdminDashboardController::class, 'usersIndex'])->name('admin.manauser');
    Route::post('/admin/kelola-pengguna/{id}/toggle-status', [AdminDashboardController::class, 'toggleUserStatus'])->name('admin.users.toggle_status');
    Route::delete('/admin/kelola-pengguna/{id}/hapus', [AdminDashboardController::class, 'destroyUser'])->name('admin.users.destroy');

}); // Penutup akhir dari Route::middleware(['auth', ...])
