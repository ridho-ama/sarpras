<!--sator 
    arepo
    tenet
    opera 
    rotas-->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Sarpras</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>

</head>
<body>

    <!-- 1. LEFT SIDEBAR COMPONENT -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="app-brand">
                <img src="{{ asset('images/kasa.png') }}" alt="Logo SMK Angkasa 1" style="width: 45px; height: 45px; object-fit: contain;">
                <div class="app-title-text">
                    <h2>Sarpras</h2>
                    <p>SMK Angkasa 1 Margahayu</p>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-item {{ Request::routeIs('user.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i> Tampilan</a>
                </li>
                <li class="menu-item {{ Request::routeIs('user.report.*') ? 'active' : '' }}">
                    <a href="{{ route('user.report.index') }}"><i class="fa-regular fa-file-lines"></i> Laporan</a>
                </li>
                <li class="menu-item {{ Request::routeIs('user.about') ? 'active' : '' }}">
                    <a href="{{ route('user.about') }}"><i class="fa-regular fa-building"></i> Tentang Kami</a>
                </li>
                <li class="menu-item {{ Request::routeIs('user.settings') ? 'active' : '' }}">
                    <a href="{{ route('user.settings') }}"><i class="fa-solid fa-gear"></i> Settings</a>
                </li>
            </ul>
        </div>

        <div class="sidebar-profile" style="display: flex; align-items: center; justify-content: space-between; gap: 10px; width: 100%; border-top: 1px solid #E2E8F0; padding-top: 15px; margin-top: auto; box-sizing: border-box;">
            
            <!-- Bagian Info Profil Kiri -->
            <a href="{{ route('user.profile') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; max-width: 75%; overflow: hidden;">
                <img src="{{ asset('images/leon.png') }}" alt="Avatar" class="profile-avatar" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                <div class="profile-info" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                    <h4 style="margin: 0; font-size: 0.85rem; color: #1E293B; font-weight: 700;">{{ Auth::user()->name }}</h4>
                    <p style="margin: 2px 0 0 0; font-size: 0.75rem; color: #64748B; text-transform: capitalize;">{{ Auth::user()->keterangan_jabatan }}</p>
                </div>
            </a>
            
            <!-- BUTTON LOGOUT BARU: Menggunakan teks tombol merah tegas agar PASTI MUNCUL -->
            <button type="button" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();" style="background-color: #EF4444; color: #FFFFFF; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: background-color 0.2s; flex-shrink: 0;" title="Keluar dari Aplikasi">
                Keluar
            </button>
            
            <!-- Form hidden POST rahasia untuk keamanan Laravel Session -->
            <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <!-- 2. MAIN APPLICATION LAYER CONTENT -->
    <main class="main-content">
        <header class="content-header">
            <div class="content-title">
                <h1>Settings</h1>
                <p>Kustomisasi preferensi fungsionalitas dan tema tampilan aplikasi Anda.</p>
            </div>
        </header>

        <!-- Blok Panel Pengaturan -->
        <section class="settings-card-box">
            
            <!-- Baris 1: Pengaturan Mode Tampilan -->
            <div class="settings-row">
                <div class="settings-info">
                    <h4>Mode Gelap (Dark Mode)</h4>
                    <p>Mengubah tema aplikasi menjadi gelap untuk kenyamanan mata di malam hari.</p>
                </div>
                <div>
                    <label class="switch-toggle">
                        <input type="checkbox" id="darkModeToggle" onclick="toggleDarkMode()">
                        <span class="slider-round"></span>
                    </label>
                </div>
            </div>

            <!-- Baris 2: Pengaturan Notifikasi -->
            <div class="settings-row">
                <div class="settings-info">
                    <h4>Notifikasi Email</h4>
                    <p>Dapatkan pemberitahuan otomatis ke email saat admin memperbarui status aduan Anda.</p>
                </div>
                <div>
                    <label class="switch-toggle">
                        <input type="checkbox" checked>
                        <span class="slider-round"></span>
                    </label>
                </div>
            </div>

        </section>
    </main>

    <!-- JAVASCRIPT LIVE DARK MODE ENGINE (LOCALSTORAGE SINKRON) -->
    <script>
// 1. OTOMATIS SYNC SAKELAR SAAT HALAMAN DIBUKA
    document.addEventListener("DOMContentLoaded", function() {
        const toggle = document.getElementById('darkModeToggle');
        if (localStorage.getItem('dark-mode') === 'enabled') {
            toggle.checked = true;
            document.documentElement.classList.add('dark-mode-active');
        } else {
            toggle.checked = false;
            document.documentElement.classList.remove('dark-mode-active');
        }
    });

// 2. FUNGSI UNTUK MENGUBAH TEMA SECARA REAL-TIME (TANPA REFRESH)
    function toggleDarkMode() {
        const toggle = document.getElementById('darkModeToggle');
        
        if (toggle.checked) {
            // Jika sakelar di-ON kan, aktifkan mode gelap seketika
            document.documentElement.classList.add('dark-mode-active');
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            // Jika sakelar di-OFF kan, langsung runtuhkan warna gelap kembali ke terang seketika
            document.documentElement.classList.remove('dark-mode-active');
            localStorage.setItem('dark-mode', 'disabled');
        }
    }

    </script>
</body>
</html>
