<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun khusus Staff Sarpras (Admin Utama)
        User::create([
            'nisn_or_nip' => '202526981256023447', // NIP Staff Sarpras
            'name' => 'Bapak Fitra',
            'class' => 'Sarana Prasarana',
            'role' => 'admin', // <--- MEMILIKI HAK AKSES ADMIN PENGELOLA
            'email' => 'admin@sarpras.sch.id',
            'password' => Hash::make('kesadaran'), // Password untuk login admin
        ]);
    }
}