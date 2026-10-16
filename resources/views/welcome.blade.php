<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarpras Digital - SMK Angkasa 1 Margahayu</title>
    <link rel="stylesheet" href="{{ asset('css/wel.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="luxury-navbar-container">
        <nav class="luxury-navbar">
            <a href="#" class="nav-logo-area">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqdHriPO8AlVorouvDgAID1tZgXkgLLXdI2k5CD8KyJA&s=10" alt="Logo SMK" style="width: 42px; height: 45px; object-fit: contain;">
                <div class="nav-logo-text">
                    <h2>SARPRAS</h2>
                    <p>SMK Angkasa 1 Margahayu</p>
                </div>
            </a>
            
            <ul class="nav-center-menu">
                <li><a href="#tentang-sarpras">Tentang sarpras</a></li>
                <li><a href="#lapor">Lapor</a></li>
                <li><a href="#statistik">Statistik</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>

            <div class="nav-auth-group">
                @auth
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.profile') : route('user.profile') }}" 
                    style="display: flex; align-items: center; gap: 12px; text-decoration: none; background: #FFFFFF; padding: 6px 16px 6px 8px; border-radius: 30px; border: 1px solid #E2E8F0; box-shadow: 0 4px 10px rgba(4, 109, 100, 0.05); transition: transform 0.2s;" 
                    title="Masuk ke Panel Dashboard Anda">
                        
                        @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                alt="Foto Profil {{ Auth::user()->name }}" 
                                style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
                        @else
                            <img src="{{ Auth::user()->role === 'admin' ? 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' : 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' }}" 
                                alt="Avatar Default" 
                                style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
                        @endif
                        
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
                    <a href="/login" class="btn-nav-outline">Masuk</a>
                    <a href="/register" class="btn-nav-solid-green">Daftar</a>
                @endauth
            </div>
        </nav>
    </div>

    <section class="hero-section-box">
        <div class="hero-left">
            <h1>Layanan Pengaduan <span>Sarana Prasarana</span> Sekolah</h1>
            <p>Platform terintegrasi yang memudahkan seluruh civitas akademika SMK Angkasa 1 Margahayu dalam mengajukan perbaikan kerusakan fasilitas fisik ruang dan barang demi menjamin kelancaran mutu pembelajaran.</p>
            
            @auth
                <a href="{{ route('user.create-report') }}" class="btn-nav-solid-green" style="padding: 15px 32px; font-size: 0.95rem;">
                    <i class="fa-solid fa-paper-plane me-2"></i> Lapor Sekarang
                </a>
            @else
                <a href="/login" class="btn-nav-solid-green" style="padding: 15px 32px; font-size: 0.95rem;">
                    Lapor Sekarang <i class="fa-solid fa-arrow-right" style="padding-left:6px;"></i>
                </a>
            @endauth
        </div>
        <div class="hero-right">
            <img src="{{ asset('images/kasa.png') }}" alt="Sarpras Ilustrasi">
        </div>
    </section>

    <section id="tentang-sarpras" style="background-color: rgba(255, 255, 255, 0.4); border-top: 1px solid rgba(255, 255, 255, 0.5);">
        <div class="section-header-center">
            <h3>Mengenal Aplikasi</h3>
            <h2>Komite Pemeliharaan Aset Fasilitas Sekolah</h2>
        </div>
        
        <div class="white-container-card" style="max-width: 900px; margin: 0 auto;">
            <p style="font-size: 1rem; color: #475569; line-height: 1.7; text-align: center; margin-bottom: 25px;">
                Sistem Pengaduan Sarpras Digital SMK Angkasa 1 Margahayu hadir sebagai jembatan komunikasi real-time antara warga sekolah dan tim logistik inventaris dan sarana. Melalui platform ini, setiap laporan kerusakan ditindaklanjuti secara transparan dengan pencatatan log kronologis yang akurat demi mendukung kenyamanan ruang belajar siswa maupun guru.
            </p>
            <div class="about-grid-metrics">
                <div class="metric-pill">
                    <h4>100%</h4>
                    <p>Transparan & Terbuka</p>
                </div>
                <div class="metric-pill">
                    <h4>&lt; 24 Jam</h4>
                    <p>Respon Verifikasi Awal</p>
                </div>
                <div class="metric-pill">
                    <h4>Terjaga</h4>
                    <p>Proteksi Laporan Palsu</p>
                </div>
            </div>
            <div style="text-align: center; margin-top: 45px;">
                @auth
                    <a href="{{ route('user.about') }}" class="btn-nav-solid-green" style="padding: 14px 35px; font-size: 1rem;">
                        <i class="fa-solid fa-book-open-reader fa-fw" aria-hidden="true"></i> Kenali Lebih Dalam
                    </a>
                @else
                    <a href="/about" class="btn-nav-solid-green" style="padding: 14px 35px; font-size: 1rem;">
                        <i class="fa-solid fa-book-open-reader fa-fw" aria-hidden="true" ></i> Kenali Lebih Dalam
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <section id="lapor">
        <div class="section-header-center">
            <h3>Panduan Pengguna</h3>
            <h2>4 Langkah Mudah Mengajukan Laporan</h2>
        </div>

        <div class="step-flow-wrapper">
            <div class="step-node-card">
                <div class="step-number-badge">1</div>
                <i class="fa-solid fa-user-shield"></i>
                <h4>Masuk / Daftar Akun</h4>
                <p>Gunakan akun beridentitas resmi. NISN 10 digit untuk Murid atau NIP 18 digit untuk Guru.</p>
            </div>
            <div class="step-node-card">
                <div class="step-number-badge">2</div>
                <i class="fa-solid fa-map-location-dot"></i>
                <h4>Pilih & Ketik Lokasi</h4>
                <p>Pilih kategori rumpun gedung, nama sub-fasilitas, lalu ketik mandiri lokasi spesifik titik ruang.</p>
            </div>
            <div class="step-node-card">
                <div class="step-number-badge">3</div>
                <i class="fa-solid fa-camera-retro"></i>
                <h4>Isi Detail & Kirim</h4>
                <p>Tulis kronologi kerusakan secara detail, sertakan foto bukti fisik awal, dan tanggal otomatis hari ini.</p>
            </div>
            <div class="step-node-card">
                <div class="step-number-badge">4</div>
                <i class="fa-solid fa-list-check"></i>
                <h4>Pantau Progress</h4>
                <p>Pantau rekam log perbaikan secara berkala hingga tim Staff Sarpras mengunggah foto bukti selesai.</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 45px;">
            @auth
                <a href="{{ route('user.dashboard') }}" class="btn-nav-solid-green" style="padding: 14px 35px; font-size: 1rem;">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Pelajari Lebih Lanjut
                </a>
            @else
                <a href="/dashboard" class="btn-nav-solid-green" style="padding: 14px 35px; font-size: 1rem;">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Pelajari Lebih Lanjut
                </a>
            @endauth
        </div>
    </section>

    <section id="statistik" style="background-color: rgba(255, 255, 255, 0.4); border-top: 1px solid rgba(255, 255, 255, 0.5);">
        <div class="section-header-center">
            <h3>Intensitas Aduan</h3>
            <h2>Statistik Grafik Laporan Masuk</h2>
        </div>

        <div class="white-container-card" style="max-width: 750px; margin: 0 auto;">
            <div style="background: #FFFFFF; padding: 30px; border-radius: 20px; border: 2px solid #E2E8F0; display: flex; align-items: center; justify-content: space-around;">
                <div style="text-align: left;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #1E293B; margin-bottom: 5px;">Persentase Ketuntasan</h3>
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; font-weight: 700; margin-top: 15px;">
                        <div><span style="display:inline-block; width:12px; height:12px; background-color:#046D64; border-radius:3px; margin-right:5px;"></span>Proses: {{ $totalMasuk }}</div>
                        <div><span style="display:inline-block; width:12px; height:12px; background-color:#10B981; border-radius:3px; margin-right:5px;"></span>Selesai: {{ $totalSelesai }}</div>
                    </div>
                </div>
                <div style="position: relative; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: conic-gradient(#10B981 0% {{ $persenSelesai }}%, #046D64 {{ $persenSelesai }}% 100%);">
                    <div style="position: absolute; width: 90px; height: 90px; background: #FFFFFF; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-weight: 800;">
                        <span>{{ $persenSelesai }}%</span><span style="font-size:0.6rem; color:#64748B;">TUNTAS</span>
                    </div>
                </div>
            </div>
            <div>
                
                </span>
                <a href="{{ route('user.report.index') }}" style="color: #00A896; font-weight: 700; text-decoration: none; margin-left: 15px; font-size: 0.85rem;" title="Lihat Rekap Data Grafik Bulanan">
                    Lihat Selengkapnya <i class="fa-solid fa-angles-right" style="font-size:0.75rem; padding-left:2px;"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="faq">
        <div class="section-header-center">
            <h3>TANYA JAWAB</h3>
            <h2>Frequently Asked Questions</h2>
        </div>

        <div class="faq-accordion-box">
            <div class="faq-item">
                <div class="faq-question-trigger" onclick="toggleFaqView(this)">
                    <span>Apa itu Sarpras Digital?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="faq-answer-content">
                    Sarpras Digital adalah aplikasi resmi pengelolaan dan pelaporan pemeliharaan sarana fisik inventaris ruang sekolah SMK Angkasa 1 Margahayu, Lanud Sulaiman, Bandung.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question-trigger" onclick="toggleFaqView(this)">
                    <span>Berapa lama estimasi pengerjaan perbaikan sarpras oleh teknisi?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="faq-answer-content">
                    Waktu perbaikan bervariasi bergantung pada tingkat keparahan (Rusak Ringan / Rusak Berat). Namun, setiap perubahan status progress dan catatan kronologis tindakan tim Sarpras terekam transparan di web pengguna.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question-trigger" onclick="toggleFaqView(this)">
                    <span>Bagaimana cara menyampaikan laporan kerusakan sarana dan prasarana?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="faq-answer-content">
                    Pengguna dapat mengajukan laporan melalui menu "Lapor" di halaman utama. Pastikan untuk mengisi semua detail yang diminta, termasuk lokasi, deskripsi kerusakan, dan foto bukti.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question-trigger" onclick="toggleFaqView(this)">
                    <span>Bagaimana cara memantau status laporan kerusakan saya?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="faq-answer-content">
                    Pengguna dapat memantau status laporan dengan login terlebih dahulu dan buka menu "Laporan Saya" di halaman utama. Di sana, anda dapat melihat detail laporan, termasuk progress perbaikan dan catatan dari tim Sarpras.
                </div>
            </div>
        </div>
    </section>

    <!-- PREMIUM FOOTER -->
    <footer class="luxury-footer">
        <div class="footer-grid-row">
            <div class="footer-col">
                <h3 style="color:#00A896; font-weight:800;">SARPRAS DIGITAL</h3>
                <p style="margin-top: 10px; font-size: 0.85rem; color:#94A3B8;">Aplikasi Resmi Pengelolaan dan Pelaporan Pemeliharaan Sarana Fisik Inventaris Ruang Sekolah SMK Angkasa 1 Margahayu, Lanud Sulaiman, Bandung.</p>
            </div>
            <div class="footer-col">
                <h3>Tautan Cepat</h3>
                <ul class="footer-links-list">
                    <li><a href="#tentang-sarpras">Tentang Sarpras</a></li>
                    <li><a href="#statistik">Statistik Rekapitulasi</a></li>
                    <li><a href="#faq">Pusat FAQ Bantuan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Hubungi Kami</h3>
                <p style="font-size:0.85rem; color:#94A3B8;"><i class="fa-solid fa-envelope me-2" style="color:#00A896;"></i> sarpras@smkangkasa1.sch.id</p>
                <p style="font-size:0.85rem; color:#94A3B8; margin-top:8px;"><i class="fa-solid fa-location-dot me-2" style="color:#00A896;"></i> Gedung Sebelah Ruang Guru.</p>
                
                <!-- icon hub -->
                <ul class="wrapper">
                    <a href="http://www.facebook.com/share/1FA8xC1qy2/">
                        <li class="icon facebook">
                            <span class="tooltip">Facebook</span>
                            <svg viewBox="0 0 320 512"
                            height="1.2em"
                            fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                            ></path>
                            </svg>
                        </li>
                    </a>
                    
                    <a href="http://www.youtube.com/@smkangkasa1margahayu785">
                        <li class="icon youtube">
                            <span class="tooltip">Youtube</span>
                            <svg xmlns="http://w3.org/2000/svg"
                            width="24" 
                            height="24" 
                            fill="currentColor" 
                            viewBox="0 0 16 15">
                            
                            <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.05-.074 1.961l-.008.104-.022.261-.01.104c-.048.519-.119 1.023-.22 1.402a2.007 2.007 0 0 1-1.415 1.42c-1.123.302-5.288.332-6.11.335h-.088c-.822-.003-4.987-.033-6.11-.335a2.01 2.01 0 0 1-1.415-1.42c-.101-.38-.172-.883-.22-1.402l-.01-.104-.022-.261-.008-.104c-.065-.914-.073-1.77-.074-1.957v-.075c.001-.194.01-1.05.074-1.961l.008-.104.022-.261.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c1.123-.302 5.288-.332 6.11-.335zm-2.09 3.523v5.045l4.631-2.523-4.63-2.522z"/>
                            </svg>
                        </li>
                    </a>
                        
                    <a href="https://www.instagram.com/smkangkasa1margahayu_official?stkn=MXIybGhwdGVwdnl6aw==">
                        <li class="icon instagram">
                            <span class="tooltip">Instagram</span>
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="1.2em"
                            fill="currentColor"
                            class="bi bi-instagram"
                            viewBox="0 0 16 16">
                            
                            <path
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"
                            ></path>
                            </svg>
                        </li>
                    </a>
                </ul>
            </div>
        </div>

        <div class="footer-bottom-bar">
            <span id="secretAdminTrigger" onclick="executeSecretClick()" 
                style="color: #94A3B8; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: color 0.2s;" 
                onmouseout="this.style.color='#94A3B8'">
                <p>&copy; 2026 SMK Angkasa 1 Margahayu. All Rights Reserved.</p>
            </span>
        </div>
    </footer>

    <!-- JAVASCRIPT ENGINE UNTUK FAQ ACCORDION -->
    <script>
        function toggleFaqView(element) {
            const faqItem = element.parentElement;
            const isOpen = faqItem.classList.contains('open-faq');
            
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('open-faq');
            });
            
            if (!isOpen) {
                faqItem.classList.add('open-faq');
            }
        }
        let secretClickCount = 0;
        let secretClickTimeout;

        function executeSecretClick() {
            // Membaca status login dan role user langsung dari Laravel Auth Blade
            const isUserLoggedIn = @json(Auth::check());
            const userRole = @json(Auth::check() ? Auth::user()->role : 'guest');

            // Jika belum login atau login sebagai Siswa/Guru biasa (User)
            if (!isUserLoggedIn || userRole !== 'admin') {
                secretClickCount++;
                
                // Jika user biasa usil mengklik sampai 5 kali, beri gertakan peringatan sistem
                if (secretClickCount >= 5) {
                    secretClickCount = 0; // Reset kembali
                }
                return;
            }

            // KONDISI KHUSUS: Jika yang mengetik adalah akun Admin (Staff Sarpras)
            secretClickCount++;
            
            // Bersihkan timeout lama agar ketukan harus dilakukan secara cepat berturut-turut
            clearTimeout(secretClickTimeout);
            
            // Jika admin sukses mengetuk sebanyak 5 kali tanpa jeda lama
            if (secretClickCount === 5) {
                secretClickCount = 0; // Reset counter
                // Alihkan paksa Admin menuju halaman kelola pengguna
                window.location.href = "{{ route('admin.dashboard') }}"; 
            }

            // Reset hitungan ketukan otomatis jika dalam 2 detik Admin berhenti mengetuk
            secretClickTimeout = setTimeout(() => {
                secretClickCount = 0;
            }, 2000);
        }
    </script>
</body>
</html>