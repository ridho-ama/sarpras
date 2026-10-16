<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $id = $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('role')->default('user');
        
        // MODIFIKASI: Buat kolom identitas kustom menjadi nullable demi akun Gmail
        $table->string('nisn_or_nip')->nullable()->unique();
        $table->string('class')->nullable(); // Menampung "Siswa" / "Guru" / "Admin"
        $table->string('photo')->nullable();
        
        // MODIFIKASI: Kolom password bawaan Breeze dibuat nullable karena Gmail tidak pakai password lokal
        $table->string('password')->nullable();
        
        // KOLOM BARU: Menyimpan ID Google dan Token Akses unik dari Gmail
        $table->string('google_id')->nullable()->unique();
        $table->string('google_token')->nullable();
        
        $table->rememberToken();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
