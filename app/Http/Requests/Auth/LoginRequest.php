<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan membuat rekues ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 1. VALIDASI INPUT LOGIN: Mengubah target cek dari email menjadi NISN/NIP
     */
    public function rules(): array
    {
        return [
            'nisn_or_nip' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Kustomisasi pesan error bahasa Indonesia agar informatif.
     */
    public function messages(): array
    {
        return [
            'nisn_or_nip.required' => 'Nomor identitas sekolah (NISN/NIP) wajib diisi.',
            'password.required' => 'Kata sandi/password wajib diisi.',
        ];
    }

    /**
     * 2. LOGIKA OTENTIKASI UTAMA (Mencocokkan NISN/NIP + Cek Proteksi Pemblokiran)
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // A. CEK PROTEKSI BAN: Cari tahu dulu status akun sebelum diizinkan attempt login
        $user = User::where('nisn_or_nip', $this->input('nisn_or_nip'))->first();
        
        if ($user && str_contains($user->name, '[DIBLOKIR]')) {
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'nisn_or_nip' => 'Hak akses akun Anda telah ditangguhkan/diblokir oleh Staff Sarpras sekolah karena pelanggaran!',
            ]);
        }

        // B. EKSEKUSI MATCHING LOGIN: Mencocokkan input nisn_or_nip dan password lokal
        $credentials = [
            'nisn_or_nip' => $this->input('nisn_or_nip'),
            'password' => $this->input('password')
        ];


        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nisn_or_nip' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Memastikan rekues login tidak terkena limit pembatasan (anti-brute force).
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'nisn_or_nip' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Mendapatkan kunci unik pembatas rate limit login.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('nisn_or_nip')).'|'.$this->ip());
    }
}