<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Aplikasi & Sarpras - SMK Angkasa 1</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navus.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, -apple-system, sans-serif;
        }
        body {
            background-color: #C3E2FF; /* Latar belakang warna orisinal */
            color: #1E293B;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR ATAS KHUSUS PENGGANTI SIDEBAR LAMA */
        .about-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 8%;
            background: #FFFFFF;
            border-bottom: 2px solid #E2E8F0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .about-nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .about-nav-title h2 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #046D64;
            line-height: 1;
        }
        .about-nav-title p {
            font-size: 0.65rem;
            color: #64748B;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }
        .btn-about-back-home {
            background-color: #046D64;
            color: #FFFFFF;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-about-back-home:hover {
            background-color: #03524B;
        }

        /* STRUKTUR KONTEN LUAS */
        .about-main-wrapper {
            max-width: 1050px;
            width: 100%;
            margin: 40px auto;
            padding: 0 20px;
            box-sizing: border-box;
        }
        .about-hero-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 45px;
            border: 2px solid #E2E8F0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
        }
        
        /* Grid Penjelasan 2 Kolom */
        .about-info-grid {
            display: column;
            grid-template-columns: 1fr 1fr;
            gap: 35px;
            margin-top: 35px;
            text-align: left;
        }
        .about-info-col h3 {
            font-size: 1.2rem;
            font-weight: 800;
            color: #046D64;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 2px solid #F1F5F9;
            padding-bottom: 8px;
        }
        .about-info-col p {
            font-size: 0.95rem;
            color: #475569;
            line-height: 1.6;
        }

        /* List Nilai Fokus */
        .about-values-list {
            list-style: none;
            margin-top: 15px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .about-values-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.9rem;
            color: #334155;
            font-weight: 600;
        }
        .about-values-list i {
            color: #10B981;
            margin-top: 3px;
        }
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

    <!-- NAVBAR HEADER ATAS PENGGANTI SIDEBAR -->
    <nav class="dashboard-top-navbar">
        <a href="{{ route('welcome') }}" class="dash-nav-logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqdHriPO8AlVorouvDgAID1tZgXkgLLXdI2k5CD8KyJA&s=10" alt="Logo SMK" style="width: 40px; height: 42px; object-fit: contain;">
            <div class="dash-nav-title">
                <h2>SARPRAS DIGITAL</h2>
                <p>SMK Angkasa 1 Margahayu</p>
            </div>
        </a>

        <!-- Menu List Navigasi Atas Tengah -->
        <ul class="dash-nav-menu-links">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i> Tata Cara</a></li>
            <li><a href="{{ route('user.report.index') }}"><i class="fa-regular fa-file-lines"></i> Statistik Laporan</a></li>
            <li class="active-nav"><a href="{{ route('user.about') }}"><i class="fa-solid fa-circle-info"></i> Tentang Aplikasi</a></li>
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
        <a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i><span>Tampilan</span></a>
        <a href="{{ route('user.report.index') }}"><i class="fa-solid fa-file-lines"></i><span>Statistik Laporan</span></a>
        <a href="{{ route('welcome') }}"><i class="fa-solid fa-home"></i><span>Kembali</span></a>
    </nav>

    <!-- KONTEN INDUK UTAMA -->
    <main class="about-main-wrapper">
        <div class="about-hero-card">
            
            <div style="text-align: center; max-width: 750px; margin: 0 auto 30px auto;">
                <span style="font-size: 0.8rem; font-weight: 800; color: #046D64; background-color: #E6F4F1; padding: 6px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">
                    Profil Sistem & Sarana Sekolah
                </span>
                <h1 style="font-size: 2.2rem; font-weight: 800; color: #1E293B; margin-top: 15px; line-height: 1.2;">
                    Mengenal Platform Pengaduan & Manajemen Sarpras Sekolah
                </h1>
                <p style="font-size: 1rem; color: #64748B; margin-top: 12px; line-height: 1.6;">
                    Platform pelaporan ini dirancang khusus untuk memodernisasi tata kelola sarana prasarana serta inventaris fisik di lingkungan SMK Angkasa 1 Margahayu secara transparan dan akuntabel.
                </p>
            </div>

            <!-- GRID PENJELASAN DUA KOLOM -->
            <div class="about-info-grid">
                
                <!-- KOLOM KIRI: MENGENAL WEB & PLATFORM DIGITAL -->
                <div class="about-info-col">
                    <h3><i class="fa-solid fa-laptop-code"></i> Mengenal Web Sarpras</h3>
                    <p>
                         <strong>Sarpras</strong> adalah sistem yang dikelola oleh Sarana dan Prasarana Sekolah SMK ANGKASA 1 MRGAHAYU sebagai sarana resmi bagi masyarakat Sekolah untuk menyampaikan informasi, 
                         atau keluhan terkait fasilitas sekolah. Melalui Sarpras, setiap warga sekolah memiliki akses yang mudah, cepat, dan transparan untuk melaporkan permasalahan/kerusakan yang terjadi di sekolah.
                         Aplikasi Sarpras Digital ini dikembangkan sebagai solusi praktis untuk mengelola dan mempermudah pelaporan kerusakan fasilitas. 
                    </p>

                    <p style="margin-top: 12px;">
                        Dengan sistem ini, seluruh guru, staf, maupun siswa dapat mengajukan keluhan kerusakan fasilitas dalam hitungan detik. Setiap laporan yang masuk akan 
                        diverifikasi dan diteruskan kepada instansi dan unit kerja yang berwenang untuk ditindak lanjuti. Proses tindak lanjut
                        dilakukan secara transparan, dan warga sekolah dapat memantau perkembangan laporan secara langsung melalui sistem yang tersedia.
                    </p>

                    <p style="margin-top: 12px;">
                        Setiap aduan yang masuk langsung dikelompokkan berdasarkan kategori bangunan, dihitung intensitas kasusnya, serta diproses transparan melalui pelacakan linimasa perbaikan yang dapat dipantau langsung oleh pelapor hingga selesai.
                    </p>
                    
                    <ul class="about-values-list">
                        <li><i class="fa-solid fa-circle-check"></i> Pelaporan Real-Time </li>
                        <li><i class="fa-solid fa-circle-check"></i> Penguncian Otentikasi Guna Mencegah Laporan Palsu</li>
                        <li><i class="fa-solid fa-circle-check"></i> Manajemen Riwayat & Log Aktivitas Teknisi</li>
                        <li><i class="fa-solid fa-circle-check"></i> Penyelenggara dapat mengelola pengaduan secara sederhana, cepat, tepat, tuntas, dan terkoordinasi dengan baik</li>
                        <li><i class="fa-solid fa-circle-check"></i> Membantu mengelola fasilitas dengan lebih terstruktur </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
        <main class="about-main-wrapper">
            <div class="about-hero-card">
                <!-- KOLOM KANAN: MENGENAL SARPRAS SEKOLAH -->
                <div class="about-info-col">
                    <h3><i class="fa-solid fa-school"></i> Sarpras SMK Angkasa 1</h3>
                    <p>
                        <strong>Sarana dan Prasarana</strong> di SMK Angkasa 1 Margahayu mencakup seluruh aset fisik penunjang pendidikan yang tersebar di berbagai rumpun bangunan, mulai dari ruang teori, sarana ibadah, kesehatan, hingga fasilitas penunjang vokasi.
                    </p>
                    <p style="margin-top: 12px;">
                        Pemeliharaan sarpras sekolah meliputi perawatan laboratorium komputer, studio multimedia, Teaching Factory (TEFA), gedung perpustakaan, hingga fasilitas olahraga indoor maupun outdoor demi kenyamanan bersama.
                    </p>
                    <p style="margin-top: 12px;">
                        Keunggulan utama dari Sarpras adalah sistemnya yang berbasis digital dan terintegrasi, sehingga dapat diakses kapan pun dan di mana pun siswa, guru dan staff berada. 
                        Melalui Aplikasi sarpras ini, pelaporan tidak lagi harus dilakukan secara tatap muka atau menunggu waktu tertentu. Ini memberikan kemudahan bagi masyarakat di seluruh 
                        lingkungan sekolah untuk tetap terhubung dan mendapatkan layanan yang seharusnya.
                    </p>
                    <p style="margin-top: 12px;">
                        Dengan pemanfaatan teknologi digital, proses pelaporan menjadi lebih efisien, cepat, dan terdokumentasi dengan baik. Data laporan yang masuk juga dikelola dengan sistem 
                        pemantauan otomatis, yang membantu teknisi sarpras terkait melakukan respon lebih tepat waktu dan sesuai standar.
                    </p>
                    
                    <ul class="about-values-list">
                        <li><i class="fa-solid fa-circle-check"></i> 5 Kelompok Bangunan Utama</li>
                        <li><i class="fa-solid fa-circle-check"></i> Pemeliharaan Rutin</li>
                        <li><i class="fa-solid fa-circle-check"></i> Audit Kondisi Aset Secara Berkala oleh Sarpras</li>
                    </ul>
                </div>
                
            </div>
        </main>

            <hr style="border: 0; border-top: 2px solid #F1F5F9; margin: 35px 0 25px 0;">

            <!-- FOOTNOTE FOOT NOTE KECIL -->
            <div style="text-align: center; font-size: 0.85rem; color: #94A3B8; font-weight: 600;">
                <i class="fa-solid fa-shield-halved me-1" style="color: #046D64;"></i> Bersama Merawat Fasilitas Sekolah &copy; {{ date('Y') }} SMK Angkasa 1 Margahayu.
            </div>

</body>
</html>
