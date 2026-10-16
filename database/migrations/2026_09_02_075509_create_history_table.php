<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            
            // Relasi Foreign Key ke tabel reports
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            
            // Relasi Foreign Key ke tabel users (siapa admin/user yang memperbarui)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->text('note')->nullable();
            $table->dateTime('date_update'); // Menyimpan waktu perubahan status
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
