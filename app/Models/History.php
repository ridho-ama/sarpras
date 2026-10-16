<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    // Mengubah default nama tabel jamak Laravel (histories) jika di DB Anda menamainya tunggal 'History'
    protected $table = 'histories';

    protected $fillable = [
        'report_id',
        'user_id',
        'note',
        'photo',
        'date_update'
    ];


    // RELASI: Riwayat log ini mencatat status dari satu Laporan tertentu
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // RELASI: Riwayat log ini diubah oleh satu User/Admin tertentu
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 