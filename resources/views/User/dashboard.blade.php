<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelapor - Sarpras SMK Angkasa 1</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navus.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    <style>
        .mobile-bottom-nav { display: none; }
        @media (max-width: 680px) {
            .mobile-bottom-nav {
                display: flex; justify-content: space-around; align-items: center;
                background: #FFFFFF; position: fixed; bottom: 0; left: 0; right: 0;
                height: 70px; z-index: 99; box-shadow: 0 -5px 25px rgba(0,0,0,0.06);
                border-top-left-radius: 20px; border-top-right-radius: 20px; padding: 0 10px;
            }
            .mobile-bottom-nav a {
                display: flex; flex-direction: column; align-items: center; justify-content: center;
                text-decoration: none; color: #94A3B8; font-size: 0.65rem; font-weight: 700; gap: 5px; flex: 1; height: 100%; transition: all 0.3s;
            }
            .mobile-bottom-nav a i { font-size: 1.3rem; transition: all 0.3s; }
            .mobile-bottom-nav a.active { color: #046D64; }
            .mobile-bottom-nav a.active i { transform: translateY(-4px); color: #046D64; font-size: 1.45rem; }
        }
    </style>
</head>
<body>

    <!-- REVISI UTAMA: TOP NAVBAR PREMIUM STRUKTUR BARU -->
    <nav class="dashboard-top-navbar">
        <a href="{{ route('welcome') }}" class="dash-nav-logo">
            <img src="{{ asset('images/kasa.png') }}" alt="Logo SMK" style="width: 40px; height: 42px; object-fit: contain;">
            <div class="dash-nav-title">
                <h2>SARPRAS DIGITAL</h2>
                <p>SMK Angkasa 1 Margahayu</p>
            </div>
        </a>

        <!-- Menu List Navigasi Atas Tengah -->
        <ul class="dash-nav-menu-links">
            <li class="active-nav"><a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i> Tampilan</a></li>
            <li><a href="{{ route('user.report.index') }}"><i class="fa-regular fa-file-lines"></i> Daftar Laporan</a></li>
            <li><a href="{{ route('user.about') }}"><i class="fa-solid fa-circle-info"></i> Tentang Aplikasi</a></li>
            <li><a href="{{ route('welcome') }}"><i class="fa-solid fa-home"></i> Kembali</a></li>
        </ul>

        <!-- Profil Melayang Kanan Atas Navbar -->
        <div class="dash-nav-auth-profile-group">
            @auth
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.profile') : route('user.profile') }}" 
                style="display: flex; align-items: center; gap: 12px; text-decoration: none; background: #FFFFFF; padding: 6px 16px 6px 8px; border-radius: 30px; border: 1px solid #E2E8F0; box-shadow: 0 4px 10px rgba(4, 109, 100, 0.05); transition: transform 0.2s;" 
                title="Masuk ke Panel Dashboard Anda">
                    
                    <!-- REVISI FOTO: Mengecek apakah user memiliki file foto profil kustom di database -->
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
                    
                    <!-- Metadata Teks Info Akun -->
                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                        <span style="font-size: 0.8rem; font-weight: 800; color: #1E293B; max-width: 100px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            {{ Auth::user()->name }}
                        </span>
                        <span style="font-size: 0.65rem; font-weight: 700; color: #046D64; text-transform: uppercase; letter-spacing: 0.3px;">
                            {{ Auth::user()->role === 'admin' ? 'Staff Sarpras' : (Auth::user()->class ?? 'Pelapor') }}
                        </span>
                    </div>
                    
                    <i class="fa-solid fa-angle-right" style="font-size: 0.75rem; color: #94A3B8; margin-left: 4px;"></i>
                </a>
            @else
                <a href="/login" class="btn-about-back-home" style="background-color: #046D64; color: white; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 700;">Masuk</a>
            @endauth
        </div>
    </nav>
    <nav class="mobile-bottom-nav">
        <a href="{{ route('user.report.index') }}"><i class="fa-solid fa-file-lines"></i><span>Satistik Laporan</span></a>
        <a href="{{ route('user.about') }}"><i class="fa-solid fa-circle-info"></i><span>Tentang Aplikasi</span></a>
        <a href="{{ route('welcome') }}"><i class="fa-solid fa-home"></i><span>Kembali</span></a>
    </nav>

    <!-- LAYOUT INDUK UTAMA KONTEN DASHBOARD (FULL MELEBAR LUXURY) -->
    <main class="dashboard-main-content-wrapper">
        
        <!-- SPANDUK SELAMAT DATANG PREMIUM -->
        <header class="dashboard-welcome-banner">
            <div class="banner-text-left">
                <h2>Halo, {{ Auth::check() ? Auth::user()->name : 'Tamu Pengunjung' }}!</h2>
                <p>Selamat datang di Pusat Layanan Pengaduan Sarana Prasarana Digital SMK Angkasa 1 Margahayu.</p>
            </div>
            @auth
                <a href="{{ route('user.create-report') }}" class="btn-create-report" style="text-decoration: none; background-color: #FFFFFF; color: #046D64; font-weight: 800; border: 2px solid #FFFFFF; white-space: nowrap; box-shadow: 0 4px 12px rgba(0,0,0,0.08); padding: 12px 24px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-file-pen"></i> Buat Laporan Kerusakan
                </a>
            @endauth
        </header>

        <!-- LAYOUT GRID DUA KOLOM INFO-CENTRIC -->
        <div class="dashboard-info-layout-grid">
            
            <!-- KOLOM KIRI: PUSAT PANDUAN TATA CARA MELAPOR -->
            <div class="guide-instruction-card">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #1E293B; margin-bottom: 5px; text-align: left; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-book-open" style="color: #046D64;"></i> Panduan Tata Cara Melapor
                </h3>
                <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 20px; font-weight: 600; text-align: left;">Silakan ikuti langkah-langkah di bawah ini untuk mengajukan aduan kerusakan:</p>
                
                <!-- Langkah 1 -->
                <div class="guide-step-row">
                    <div class="guide-number-circle">1</div>
                    <div class="guide-text-body">
                        <h4>Pilih Kategori Induk & Sub-Fasilitas</h4>
                        <p>Klik tombol "Buat Laporan" di atas, tentukan kategori bangunan utama (baris pertama), kemudian tentukan sub-kategori ruangan yang bermasalah (baris kedua).</p>
                    </div>
                </div>

                <!-- Langkah 2 -->
                <div class="guide-step-row">
                    <div class="guide-number-circle">2</div>
                    <div class="guide-text-body">
                        <h4>Ketik Lokasi Secara Spesifik</h4>
                        <p>Pada kolom lokasi, ketik secara akurat posisi fasilitas yang rusak agar teknisi tidak salah alamat. Contoh: <em>"Gerbang Utama, Koridor Belakang Kelas X PPLG 1"</em>.</p>
                    </div>
                </div>

                <!-- Langkah 3 -->
                <div class="guide-step-row">
                    <div class="guide-number-circle">3</div>
                    <div class="guide-text-body">
                        <h4>Tulis Kronologi, detai kerusakan & Unggah Bukti Awal</h4>
                        <p>Berikan judul yang ringkas dan padat. Jelaskan kronologi atau kondisi kerusakan pada kolom deskripsi, serta lampirkan foto asli sebagai bukti validasi awal laporan.</p>
                    </div>
                </div>

                <!-- Langkah 4 -->
                <div class="guide-step-row">
                    <div class="guide-number-circle">4</div>
                    <div class="guide-text-body">
                        <h4>Pantau Alur Kemajuan Tindakan Perbaikan</h4>
                        <p>Setelah terkirim, buka menu "Daftar Laporan" yang ada pada navbar, lalu geser ke tab "Laporan Saya". Pantau kemajuan status log dari <strong>Pending</strong>, <strong>Proses</strong>, hingga diselesaikan oleh admin.</p>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: JELAJAH 3 FITUR UTAMA APLIKASI -->
            <div class="features-overview-card">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #1E293B; margin-bottom: 5px; text-align: left; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-cubes" style="color: #046D64;"></i> Fitur Utama Web Sarpras
                </h3>
                <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 20px; font-weight: 600; text-align: left;">Fungsionalitas keunggulan platform digital sekolah:</p>

                <!-- Fitur 1 -->
                <div class="feature-box-item">
                    <div class="feature-icon-square f-bg-blue">
                        <i class="fa-solid fa-signature"></i>
                    </div>
                    <div class="feature-text-block">
                        <h4>Otomatisasi Akun Cerdas</h4>
                        <p>Sistem registrasi mendeteksi otomatis peran Anda sebagai <strong>Siswa</strong> (ketika menginput NISN 10 digit) atau <strong>Guru</strong> (ketika menginput NIP 18 digit) tanpa ribet mengisi kolom jabatan secara manual.</p>
                    </div>
                </div>

                <!-- Fitur 2 -->
                <div class="feature-box-item">
                    <div class="feature-icon-square f-bg-green">
                        <i class="fa-solid fa-route"></i>
                    </div>
                    <div class="feature-text-block">
                        <h4>Pelacakan Transparan Linimasa</h4>
                        <p>Riwayat penanganan aduan tercatat mendalam di halaman detail laporan. Setiap catatan progress perbaikan dari teknisi sarpras dapat dilihat langsung memalui web.</p>
                    </div>
                </div>

                <div class="feature-box-item">
                    <div class="feature-icon-square f-bg-purple">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div class="feature-text-block">
                        <h4>Pelaporan Digital</h4>
                        <p>Memudahkan pelaporan karena dilakukan secara <strong>daring </strong>tanpa harus mencari staff sarpras dan menghemat penggunaan kertas. Dapat diakses serta dilaporkan <strong>kapanpun dan dimanapun</strong> secara daring. </p>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
