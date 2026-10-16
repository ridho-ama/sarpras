<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'facility_id',
        'title',
        'description',
        'location_custom', // <--- BARIS INI WAJIB ADA AGAR TIDAK KEMBALI KE DEFAULT DATABASE
        'photo',
        'date_report',
        'status'
    ];

    // RELASI: Laporan ini dimiliki oleh seorang User (Pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELASI: Laporan ini merujuk pada satu Fasilitas tertentu
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    // RELASI: Satu laporan bisa memiliki banyak jejak riwayat status (History)
    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
