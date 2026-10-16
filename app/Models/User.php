<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom database yang boleh diisi massal.
     */
    protected $fillable = [
        'name',
        'email',
        'nisn_or_nip',
        'class',
        'photo',
        'password',
        'role',
    ];

    /**
     * Menyembunyikan kolom sensitif.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Penyesuaian tipe data.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi database ke tabel laporan pengaduan.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // CATATAN: Fungsi username() nisn_or_nip resmi DICOPOT total 
    // agar core Auth Laravel otomatis membaca kolom 'email' bawaan asli Breeze.
}
