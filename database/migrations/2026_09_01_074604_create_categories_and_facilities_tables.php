<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL KATEGORI UTAMA
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_category');
            $table->text('description_category')->nullable();
            $table->string('image_category')->nullable();
            $table->timestamps();
        });

        // 2. TABEL SUB-KATEGORI / FASILITAS RUANGAN (Menghubungkan ke Laporan Kerusakan Anda)
        // Kita modifikasi tabel facilities agar punya relasi ke tabel categories
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name_facility'); // Contoh: R. KELAS, PERPUSTAKAAN, TU
            $table->string('location');      // Contoh: Gedung A Lt.2, Ruang Belakang, dsb.
            $table->string('condition')->default('Baik'); // Baik, Rusak Ringan, Rusak Berat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('categories');
    }
};
