<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Aplikasi - Sarpras</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lores.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
</head>
<body style="display: block; background-color: #C3E2FF; min-height: 100vh;">

    <div id="authContainer" class="auth-page-container">
        
        <div class="auth-content-box">
            
            <div class="auth-panel-half panel-login-form" style="width: 100%; position: static; opacity: 1; pointer-events: auto;">
                <div class="auth-card-form">
                    <h2>SELAMAT DATANG</h2>
                    <p class="sub-text">Silahkan masuk menggunakan akun anda</p>

                    @if(session('status'))
                        <div style="background-color: #D1E7DD; color: #0F5132; padding: 10px 12px; border-radius: 6px; margin-bottom: 15px; font-size: 0.8rem; font-weight: 700; text-align: center;">
                            <i class="fa-solid fa-circle-check me-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div style="background-color: #FEE2E2; color: #991B1B; padding: 11px 14px; border-radius: 8px; margin-bottom: 15px; font-size: 0.8rem; font-weight: 600;">
                            <ul style="padding-left: 15px; margin: 0; list-style-type: square;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <div class="auth-form-group">
                            <label for="nisn_or_nip">Nomor NISN / NIP</label>
                            <input type="text" id="nisn_or_nip" class="auth-input-field" name="nisn_or_nip" value="{{ old('nisn_or_nip') }}" placeholder="Masukkan 10 digit NISN atau 18 digit NIP..." required autofocus autocomplete="off">
                        </div>

                        <div class="auth-form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="auth-input-field" name="password" placeholder="Masukkan kata sandi..." required autocomplete="current-password">
                        </div>
                        
                        <div style="margin: 15px 0; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <input type="checkbox" id="remember_me" name="remember" style="width: 14px; height: 14px; cursor: pointer;">
                            <label for="remember_me" style="font-size: 0.85rem; color: #64748B; font-weight: 600; cursor: pointer;">Remember me</label>
                        </div>
                        
                        <button type="submit" class="btn-submit-green" style="margin-bottom: 20px;">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Aplikasi
                        </button>
                    </form>

                    <hr style="border: 0; border-top: 1px solid #E2E8F0; margin-bottom: 15px;">

                    <div class="login-footer-action" style="justify-content: center;">
                        <span style="font-size: 0.85rem; color: #64748B;">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="btn-link-green" style="text-decoration: none;">
                            Daftar Sekarang <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="auth-banner-blue" style="position: absolute; top: 0; left: 50%; width: 50%; height: 100%;">
                <h1>Sarpras</h1>
                <p>Sistem Pemantauan & Layanan Pelaporan Fasilitas SMK Angkasa 1 Margahayu</p>
            </div>

        </div>
    </div>
</body>
</html>
