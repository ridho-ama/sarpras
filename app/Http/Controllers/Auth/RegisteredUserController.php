<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman form registrasi kustom.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menangani rekues pendaftaran akun baru dengan validasi ketat.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDASI KETAT: Mengunci panjang NISN/NIP dan format Gmail asli
        $request->validate([
            'nisn_or_nip' => ['required', 'numeric', 'digits_between:10,18', 'unique:'.User::class.',nisn_or_nip'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class.',email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/' // Menolak mutlak jika bukan @gmail.com asli
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nisn_or_nip.required'       => 'Nomor identitas sekolah wajib diisi.',
            'nisn_or_nip.digits_between' => 'Gunakan 10 digit untuk NISN (Siswa) atau 18 digit untuk NIP (Guru).',
            'nisn_or_nip.unique'         => 'Nomor NISN/NIP tersebut sudah terdaftar pada akun lain.',
            'name.required'              => 'Nama lengkap wajib diisi.',
            'email.required'             => 'Alamat email wajib diisi.',
            'email.email'                => 'Format alamat email tidak valid.',
            'email.unique'               => 'Alamat email ini sudah digunakan oleh akun lain.',
            'email.regex'                => 'Sistem menolak! Pendaftaran wajib menggunakan akun Gmail asli (@gmail.com).',
            'password.required'          => 'Kata sandi wajib diisi.',
            'password.min'               => 'Kata sandi minimal harus 6 karakter.',
            'password.confirmed'         => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 2. LOGIKA HITUNG DIGIT OTOMATIS: Penentu jabatan civitas sekolah
        $inputLength = strlen($request->nisn_or_nip);
        if ($inputLength == 10) {
            $detectedRole = 'Siswa';
        } elseif ($inputLength == 18) {
            $detectedRole = 'Guru';
        } else {
            return redirect()->back()
                ->withErrors(['nisn_or_nip' => 'Masukkan tepat 10 digit untuk NISN (Siswa) atau 18 digit untuk NIP (Guru).'])
                ->withInput();
        }

        // 3. Eksekusi penyimpanan data ke database secara permanen
        $user = User::create([
            'nisn_or_nip' => $request->nisn_or_nip,
            'name' => $request->name,
            'email' => $request->email,
            'class' => $detectedRole, // Menyimpan string 'Siswa' atau 'Guru' otomatis
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        // Meloginkan pengguna baru secara otomatis bawaan standar Breeze
        Auth::login($user);

        // Langsung lempar ke dashboard pelapor
        // Hapus kode bawaan, dan ganti dengan ini:
        return redirect()->route('welcome')->with('success', 'Akun Anda berhasil didaftarkan sebagai ' . $detectedRole . '!');
    }
}
