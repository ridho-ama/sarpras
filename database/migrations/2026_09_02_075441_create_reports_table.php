<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            
            // Relasi Foreign Key ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi Foreign Key ke tabel facilities
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            
            $table->string('title'); // Penambahan untuk "Judul Laporan" dari UI
            $table->text('description');
            $table->string('photo')->nullable(); // Nullable jika foto bersifat opsional
            $table->date('date_report');
            $table->enum('status', ['Pending', 'Proses', 'Selesai', 'Tolak'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};