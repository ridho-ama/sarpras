<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth');
    }
    
    public function index()
    {
        return view('user.dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
        'nisn_or_nip' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('nisn_or_nip', $request->nisn_or_nip)->first();

    if ($user && str_contains($user->name, '[DIBLOKIR]')) {
        return redirect()->back()
            ->withInput($request->only('nisn_or_nip'))
            ->withErrors(['nisn_or_nip' => 'Hak akses akun Anda telah ditangguhkan/diblokir oleh Staff Sarpras sekolah karena pelanggaran!']);
    }

    $credentials = $request->only('nisn_or_nip', 'password');
    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->intended(route('user.dashboard'));
    }

    return redirect()->back()
        ->withInput($request->only('nisn_or_nip'))
        ->withErrors(['nisn_or_nip' => 'Nomor identitas atau kata sandi yang Anda masukkan salah.']);
}

    public function showRegister()
    {
        return view('auth');
    }

    public function register(Request $request)
    {

    $request->validate([
        'nisn_or_nip' => 'required|numeric|digits_between:10,18',
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $identity = trim($request->nisn_or_nip);
    $length = strlen($identity);

    if ($length === 10) {
        $role = 'user';
        $userClass = 'Siswa';
    } elseif ($length === 18) {
        $role = 'user';
        $userClass = 'Guru';
    } else {
        return back()->withErrors([
            'nisn_or_nip' => 'Nomor Identitas tidak valid! NISN wajib bernilai 10 digit (Siswa) atau NIP wajib bernilai 18 digit (Guru).'
        ])->withInput();
    }

    $user = \App\Models\User::create([
        'nisn_or_nip' => $identity,
        'name' => $request->name,
        'class' => $userClass,
        'role' => $role,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect()->route('user.dashboard');
    
    Auth::login($user);

    return redirect()->route('user.dashboard');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}