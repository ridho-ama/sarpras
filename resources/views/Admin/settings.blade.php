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
    <button type="button" class="admin-mobile-hamburger-trigger" id="mobileHamburgerBtn" title="Buka Menu Navigasi Admin">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- LAPISAN BACKDROP PENUTUP LAYAR BELAKANG SAAT SIDEBAR TERBUKA DI HP -->
    <div class="admin-sidebar-overlay-backdrop" id="sidebarBackdropClose" onclick="closeAdminMobileSidebar()"></div>

    <!-- 1. LEFT SIDEBAR COMPONENT -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="app-brand">
                <img src="{{ asset('images/kasa.png') }}" alt="Logo SMK Angkasa 1" style="width: 45px; height: 45px; object-fit: contain;">
                <div class="app-title-text">
                    <h2>Sarpras Admin</h2>
                    <p>SMK Angkasa 1 Margahayu</p>
                </div>
            </div>
                <ul class="sidebar-menu">
                    <li class="menu-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-border-all"></i> Tampilan</a>
                    </li>
                    <li class="menu-item {{ Request::routeIs('admin.report.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.index') }}"><i class="fa-regular fa-file-lines"></i> Laporan</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.facility.index') }}"><i class="fa-solid fa-boxes-stacked"></i> Fasilitas</a>
                    </li>
                    <li class="menu-item {{ Request::routeIs('admin.manauser') ? 'active' : '' }}">
                        <a href="{{ route('admin.manauser') }}"><i class="fa-solid fa-users"></i> Data Pengguna</a>
                    </li>
                    <li class="menu-item {{ Request::routeIs('admin.settings') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear"></i> Settings</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('welcome') }}"><i class="fa-solid fa-house"></i> Beranda</a>
                    </li>
                </ul>
             </div>
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; max-width: 100%; overflow: hidden;">
                    @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                        <!-- Jika ada, tampilkan foto asli milik user/admin tersebut -->
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                            alt="Foto Profil {{ Auth::user()->name }}" 
                            style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
                    @else
                        <!-- Cadangan (Fallback) Gambar Default Berdasarkan Peran jika belum upload foto -->
                        <img src="{{ Auth::user()->role === 'admin' ? 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' : 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' }}" 
                            alt="Avatar Default" 
                            style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
                    @endif 
                <div class="profile-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <span class="badge-admin-role">STAFF SARPRAS</span>
                </div>
                </a>
            </div>
        </div>
        <button type="button" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();" 
        style="background-color: #EF4444; color: #FFFFFF; border: none; padding: 6px 12px; border-radius: 6px; 
        font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: background-color 0.2s; flex-shrink: 0;" title="Keluar dari Aplikasi">Keluar</button>
        
            <!-- Form hidden POST rahasia untuk keamanan Laravel Session -->
            <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
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