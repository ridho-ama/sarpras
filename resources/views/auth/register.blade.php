<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Sarpras</title>
    <!-- Menghubungkan ke berkas style utama dan lores.css kustom adaptif monitor -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lores.css') }}?v=8.0">
    <!-- Memanggil library ikon premium FontAwesome -->
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
</head>
<body style="display: block; background-color: #C3E2FF; min-height: 100vh;">

    <!-- WADAH UTAMA ADAPTIF FULL-SCREEN (STANDARISASI ASLI) -->
    <div id="authContainer" class="auth-page-container">
        
        <!-- GRID CONTAINER: Mengunci kesimetrisan pembagian ruang 50-50 di desktop -->
        <div class="auth-content-box">
            
            <!-- ELEMEN FORM REGISTER (Mengisi Kolom Kiri Grid Desktop) -->
            <div class="auth-panel-half panel-login-form" style="width: 100%; position: static; opacity: 1; pointer-events: auto;">
                <div class="auth-card-form" style="max-height: 95vh; overflow-y: auto; padding-right: 5px;">
                    <h2>DAFTAR AKUN BARU</h2>
                    <p class="sub-text">Silahkan lengkapi identitas diri anda menggunakan email Gmail asli</p>

                    <!-- Lencana Kolektif Error Validasi bawaan Laravel Breeze -->
                    @if ($errors->any())
                        <div style="background-color: #FEE2E2; color: #991B1B; padding: 11px 14px; border-radius: 8px; margin-bottom: 15px; font-size: 0.8rem; font-weight: 600;">
                            <ul style="padding-left: 15px; margin: 0; list-style-type: square;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form diarahkan ke route registrasi store bawaan Laravel Breeze -->
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <!-- Input 1: Nomor Identitas Sekolah (NISN / NIP) -->
                        <div class="auth-form-group">
                            <label for="nisn_or_nip">Nomor NISN / NIP</label>
                            <input type="text" id="nisn_or_nip" class="auth-input-field" name="nisn_or_nip" value="{{ old('nisn_or_nip') }}" placeholder="10 digit Siswa / 18 digit Guru..." required autofocus autocomplete="off">
                        </div>

                        <!-- Input 2: Nama Lengkap -->
                        <div class="auth-form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" class="auth-input-field" name="name" value="{{ old('name') }}" required autocomplete="name">
                        </div>

                        <!-- Input 3: Alamat Email Gmail Asli -->
                        <div class="auth-form-group">
                            <label for="email">Alamat Email Gmail</label>
                            <input type="email" id="email" class="auth-input-field" name="email" value="{{ old('email') }}" placeholder="contoh: nama@gmail.com" required autocomplete="username">
                        </div>

                        <!-- Input 4: Password -->
                        <div class="auth-form-group">
                            <label for="password">Kata Sandi Baru</label>
                            <input type="password" id="password" class="auth-input-field" name="password" placeholder="Minimal 8 karakter..." required autocomplete="new-password">
                        </div>

                        <!-- Input 5: Konfirmasi Ulang Password -->
                        <div class="auth-form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <input type="password" id="password_confirmation" class="auth-input-field" name="password_confirmation" placeholder="Ulangi kata sandi di atas..." required autocomplete="new-password">
                        </div>
                        
                        <button type="submit" class="btn-submit-green" style="margin-top: 10px; margin-bottom: 20px;">
                            <i class="fa-solid fa-user-plus me-2"></i> Daftarkan Akun
                        </button>
                    </form>

                    <hr style="border: 0; border-top: 1px solid #E2E8F0; margin-bottom: 15px;">

                    <div class="login-footer-action" style="justify-content: center;">
                        <span style="font-size: 0.85rem; color: #64748B;">Sudah memiliki akun?</span>
                        <a href="{{ route('login') }}" class="btn-link-green" style="text-decoration: none;">
                            Login Sekarang <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ELEMEN BANNER KANAN (Statis Menawan di Desktop Full Screen, Otomatis Sembunyi di HP) -->
            <div class="auth-banner-blue" style="position: absolute; top: 0; left: 50%; width: 50%; height: 100%;">
                <h1>Sarpras</h1>
                <p>Sistem Pemantauan & Layanan Pelaporan Fasilitas SMK Angkasa 1 Margahayu</p>
            </div>

        </div> <!-- Penutup .auth-content-box -->
    </div> <!-- Penutup #authContainer -->

</body>
</html>