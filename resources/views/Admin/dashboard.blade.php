<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ringkasan - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/diag.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    <style>
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th, .admin-table td { padding: 15px 10px; border-bottom: 1px solid #F1F5F9; font-size: 0.9rem; color: #64748B; vertical-align: middle; }
        .admin-table th { text-align: left; color: #94A3B8; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; border-bottom: 2px solid #E2E8F0; padding-bottom: 12px; }
        .th-pelapor { width: 18%; }
        .th-lokasi   { width: 15%; font-weight: 700; color: #1E293B; }
        .th-judul     { width: 37%; }
        .th-status   { width: 12%; text-align: center; }
        .th-tanggal { width: 10%; text-align: center; }
        .th-aksi       { width: 8%; text-align: right; padding-right: 15px; }
    </style>
</head>
<body>

    <div class="admin-mobile-top-navbar-container">
        <!-- Pasangan Sisi Kiri: Tombol Pemicu Hamburger -->
        <button type="button" class="admin-mobile-hamburger-trigger" id="mobileHamburgerBtn" title="Buka Menu Navigasi Admin">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Pasangan Sisi Kanan: Kapsul Identitas Nama & Foto Profil Melayang -->
        <div class="admin-mobile-nav-profile-right">
            @auth
                <a href="{{ route('admin.profile') }}" class="admin-mobile-avatar-link" title="Lihat Profil Admin">
                    @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Avatar {{ Auth::user()->name }}">
                    @else
                        <img src="https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww" alt="Avatar Default">
                    @endif
                </a>
                <!-- Teks Info Nama Admin Pengganti Tombol Keluar Lama -->
                <div class="admin-mobile-profile-text-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <span>Admin</span>
                </div>
            @endauth
        </div>
    </div>

    <!-- LAPISAN KACA BACKDROP PENGUNCI KLIK AREA LUAR -->
    <div class="admin-sidebar-overlay-backdrop" id="sidebarBackdropClose"></div>

    <!-- SIDEBAR KIRI PANEL CONTROL ADMIN (MURNI TANPA PROFIL SAAT DI HP) -->
    <aside class="sidebar">
        <!-- Tombol silang inline penutup laci di pojok atas sidebar khusus di HP -->
        <button type="button" class="sidebar-close-inline-btn" onclick="closeAdminMobileSidebar()" title="Tutup Navigasi">
            <i class="fa-solid fa-xmark"></i>
        </button>

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
                    <a href="{{ route('admin.report.index') }}"><i class="fa-solid fa-file-lines"></i> Laporan</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.facility.index') }}"><i class="fa-solid fa-boxes-stacked"></i> Fasilitas</a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.manauser') ? 'active' : '' }}">
                    <a href="{{ route('admin.manauser') }}"><i class="fa-solid fa-users"></i> Data Pengguna</a>
                </li>
                <!-- <li class="menu-item {{ Request::routeIs('admin.settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear"></i> Settings</a>
                </li> -->
                <li class="menu-item">
                    <a href="{{ route('welcome') }}"><i class="fa-solid fa-house"></i> welcome</a>
                </li>
            </ul> 
        </div>

        <!-- BLOK DESKTOP ONLY PROFILE (Otomatis Sembunyi Di HP Lewat Aturan CSS) -->
        <div class="sidebar-profile">
            <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                <a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; max-width: 100%; overflow: hidden;">
                    @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil {{ Auth::user()->name }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
                    @else
                        <img src="https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww" alt="Avatar Default" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
                    @endif               
                    <div class="profile-info">
                        <h4>{{ Auth::user()->name }}</h4>
                        <span class="badge-admin-role">STAFF SARPRAS</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- BLOK DESKTOP ONLY LOGOUT BUTTON -->
        
        <!-- Form hidden POST rahasia untuk keamanan Laravel Session -->
        <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>

    <!-- CONTENT INDUK AREA KERJA UTAMA -->
    <main class="main-content">
        <header class="content-header">
            <div class="content-title">
                <h1>Panel Kendali Pengaduan</h1>
                <p>Memantau, menanggapi, dan memproses pembaharuan perbaikan fasilitas sekolah.</p>
            </div>
        </header>

        <!-- KOTAK REKAPITULASI STATISTIK (OTOMATIS SINKRON MULTI-KOLOM 2-2-1 DI HP) -->
        <section class="stat-cards-row-admin">
            <div class="stat-card">
                <div><span class="card-label label-dikirim">Total Aduan</span><h3>{{ $totalLaporan }}</h3></div>
                <i class="fa-solid fa-folder-open card-icon icon-dikirim"></i>
            </div>
            <div class="stat-card">
                <div><span class="card-label label-ditanggapi">Pending</span><h3>{{ $laporanPending }}</h3></div>
                <i class="fa-regular fa-clock card-icon icon-ditanggapi"></i>
            </div>
            <div class="stat-card">
                <div><span class="card-label label-proses">Diproses</span><h3>{{ $laporanProses }}</h3></div>
                <i class="fa-solid fa-spinner fa-spin card-icon icon-proses"></i>
            </div>
            <div class="stat-card">
                <div><span class="card-label label-selesai">Selesai</span><h3>{{ $laporanSelesai }}</h3></div>
                <i class="fa-solid fa-square-check card-icon icon-selesai"></i>
            </div>
            <div class="stat-card">
                <div><span class="card-label label-tolak">Ditolak</span><h3>{{ $laporanDitolak }}</h3></div>
                <i class="fa-solid fa-triangle-exclamation card-icon icon-tolak"></i>
            </div>
        </section>

        <!-- DIAGRAM GRAFIK AREA DINAMIS SMOOTH (ZOOM IN/OUT) -->
        <section class="chart-container-box">
            <div class="chart-header-row">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #0F172A; margin: 0;">
                    <i class="fa-solid fa-chart-line me-2" style="color:#046D64;"></i> Statistik Tren Laporan
                </h3>
                
                <!-- Filter Form -->
                <form id="chartFilterForm" style="display: flex; gap: 8px; margin: 0; align-items: center;" onsubmit="return false;">
                    
                    <!-- Filter Tahun (Penulisan Blade yang lebih aman) -->
                    <select name="year" id="filterYear" class="chart-filter-select" onchange="fetchSmoothChartData()">
                        @foreach ($availableYears as $y)
                            <option value="{{ $y }}" {{ $selectedYear ==$y ? 'selected' : '' }}>
                                Tahun {{ $y }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Filter Rentang Waktu -->
                    <select name="range" id="filterRange" class="chart-filter-select" onchange="fetchSmoothChartData()">
                        <option value="all" {{ $selectedRange == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                        <option value="last_3_months" {{ $selectedRange == 'last_3_months' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                    </select>

                </form>
            </div>

            <!-- SVG AREA CHART ELASTIS -->
            <div class="chart-scroll-wrapper">
                <svg viewBox="0 0 750 210" class="area-chart-svg">
                    <defs>
                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#046D64" stop-opacity="0.6"/>
                            <stop offset="100%" stop-color="#046D64" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>

                    <!-- Garis Grid Horizontal -->
                    <line x1="45" y1="20" x2="720" y2="20" class="chart-grid-line" />
                    <line x1="45" y1="65" x2="720" y2="65" class="chart-grid-line" />
                    <line x1="45" y1="110" x2="720" y2="110" class="chart-grid-line" />
                    <line x1="45" y1="155" x2="720" y2="155" class="chart-grid-line" />
                    <line x1="45" y1="185" x2="720" y2="185" stroke="#CBD5E1" stroke-width="2" />

                    <!-- Label Angka Sumbu Y -->
                    <text x="35" y="24" class="chart-y-label">20+</text>
                    <text x="35" y="69" class="chart-y-label">15</text>
                    <text x="35" y="114" class="chart-y-label">10</text>
                    <text x="35" y="159" class="chart-y-label">5</text>
                    <text x="35" y="189" class="chart-y-label">0</text>

                    @php
                        $dataCount = count($monthsLabels);$startX = 80;
                        $endX = 680;
                        $stepX = ($dataCount > 1) ? ($endX - $startX) / ($dataCount - 1) : 0;
                        $pathString = ""; 
                    @endphp

                    <!-- Path Garis & Area dengan Transisi -->
                    <path id="svgAreaPath" class="chart-area-fill" style="transition: d 0.6s cubic-bezier(0.4, 0, 0.2, 1);" />
                    <path id="svgLinePath" class="chart-line-path" style="transition: d 0.6s cubic-bezier(0.4, 0, 0.2, 1);" />

                    <!-- Titik Data -->
                    @for ($i = 0; $i < 12; $i++)
                        @php
                            $isActive = $i <$dataCount;
                            $val =$isActive ? ($monthlyData[$i] ?? 0) : 0;
                            $label =$isActive ? ($monthsLabels[$i] ?? '') : '';
                            
                            $valCapped = min($val, 20);
                            $y = 185 - ($valCapped * 8.25);
                            $x =$isActive ? ($startX + ($i * $stepX)) :$endX; 
                            $opacity =$isActive ? 1 : 0;

                            if($isActive) {
                                if($i === 0)$pathString .= "M {$x},{$y} ";
                                else $pathString .= "L {$x},{$y} ";
                            }
                        @endphp
                        
                        <g id="group-{{ $i }}" style="opacity: {{ $opacity }}; transition: opacity 0.5s ease-in-out;">
                            <circle id="dot-{{ $i }}" cx="{{ $x }}" cy="{{ $y }}" r="4.5" class="chart-data-dot" style="transition: cx 0.6s cubic-bezier(0.4, 0, 0.2, 1), cy 0.6s cubic-bezier(0.4, 0, 0.2, 1);" />
                            <text id="val-{{ $i }}" x="{{ $x }}" y="{{ $y - 12 }}" class="chart-axis-label" style="fill: #046D64; font-weight: 800; font-size: 11px; transition: x 0.6s cubic-bezier(0.4, 0, 0.2, 1), y 0.6s cubic-bezier(0.4, 0, 0.2, 1);">
                                {{ $val > 0 ?$val : '' }}
                            </text>
                            <text id="label-{{ $i }}" x="{{ $x }}" y="202" class="chart-axis-label" style="transition: x 0.6s cubic-bezier(0.4, 0, 0.2, 1);">
                                {{ $label }}
                            </text>
                        </g>
                    @endfor
                    
                    @php 
                        $lastX =$startX + (($dataCount - 1) *$stepX);
                        $areaString =$pathString . "L {$lastX},185 L {$startX},185 Z";
                    @endphp

                    <!-- Render Awal SVG -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById('svgLinePath').setAttribute('d', "{{ $pathString }}");
                            document.getElementById('svgAreaPath').setAttribute('d', "{{ $areaString }}");
                        });
                    </script>
                </svg>
            </div>
        </section>

        <!-- TABEL REKAP ADUAN TERBARU (SCROLLABLE DI HP KECIL) -->
        <section class="data-card">
            <div class="data-card-header">
                <h3>Pengaduan Terbaru</h3>
                <a href="{{ route('admin.report.index') }}" class="link-view-all">View All</a>
            </div>

            <!-- Pembungkus pengaman limpahan lebar tabel agar bisa digeser horizontal di layar HP -->
            <div class="admin-table-responsive-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="th-pelapor">Pelapor</th>
                            <th class="th-lokasi">Lokasi</th>
                            <th class="th-judul">Judul Laporan</th>
                            <th class="th-tanggal">Tanggal</th>
                            <th class="th-status">Status</th>
                            <th style="text-align: right; padding-right: 20px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestReports as $report)
                            <tr>
                                <td>
                                    <strong style="color: #1E293B;">{{ $report->user->name }}</strong><br>
                                    <small style="color: #94A3B8; font-weight:700;">{{ $report->user->class }}</small>
                                </td>
                                <td style="font-weight: 700; color: #046D64;">{{ $report->location_custom ?? $report->facility->location_custom }}</td>
                                <td><span style="font-weight: 600; color: #1E293B;">{{ $report->title }}</span></td>
                                <td><span style="font-weight: 600;">{{ \Carbon\Carbon::parse($report->date_report)->locale('id')->isoFormat('D MMM Y') }}</span></td>
                                <td class="td-status">
                                    @if($report->status == 'Proses') <span class="status-pill status-proses">Proses</span> @endif
                                    @if($report->status == 'Tolak') <span class="status-pill status-tolak">Tolak</span> @endif
                                    @if($report->status == 'Selesai') <span class="status-pill status-selesai">Selesai</span> @endif
                                    @if($report->status == 'Pending') <span class="status-pill status-pending">Pending</span> @endif
                                </td>
                                <td class="td-aksi">
                                    <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%;">
                                        <!-- Menggunakan tombol teks Detail premium -->
                                        <a href="{{ route('admin.show-report', $report->id) }}" class="btn-detail-table-custom" title="Lihat Berkas Log Aktivitas Lengkap">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align: center; padding: 40px 0; color: #94A3B8;">Belum ada data aduan masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- ===================================================================
       JAVASCRIPT ENGINE: SENSOR BUKA HAMBURGER & PENUTUP AREA LUAR DETECTOR
    ==================================================================== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hamburgerBtn = document.getElementById('mobileHamburgerBtn');
            const sidebarElement = document.querySelector('.sidebar');

            // 1. Fungsi Utama: Klik Tombol Hamburger luar untuk membuka laci menu
            if (hamburgerBtn && sidebarElement) {
                hamburgerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Amankan agar tidak langsung memicu penutupan klik luar
                    sidebarElement.classList.add('sidebar-open');
                });
            }

            // 2. SENSOR AREA LUAR: Klik di area kosong mana saja di luar sidebar akan otomatis menutup menu
            document.addEventListener('click', function(event) {
                if (sidebarElement && sidebarElement.classList.contains('sidebar-open')) {
                    // Jika jari pengguna menyentuh area yang bukan bagian dari badan sidebar putih
                    if (!sidebarElement.contains(event.target)) {
                        closeAdminMobileSidebar();
                    }
                }
            });

            // 3. Fungsi Utama Penutup Bilah Samping Navigasi Admin
            window.closeAdminMobileSidebar = function() {
                if (sidebarElement && sidebarElement.classList.contains('sidebar-open')) {
                    sidebarElement.classList.remove('sidebar-open');
                }
            };

            // 4. Pengaman Reset Ukuran Layar Monitor Desktop/Laptop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 480 && sidebarElement && sidebarElement.classList.contains('sidebar-open')) {
                    closeAdminMobileSidebar();
                }
            });
        });
        function fetchSmoothChartData() {
                const year = document.getElementById('filterYear').value;
                const range = document.getElementById('filterRange').value;
                const url = `{{ route('admin.dashboard') }}?year=${year}&range=${range}`;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(res => {
                    if (!res.chartData) return;
                    
                    const data = res.chartData; 
                    const dataCount = data.length;
                    const startX = 80;
                    const endX = 680;
                    const stepX = dataCount > 1 ? (endX - startX) / (dataCount - 1) : 0;
                    
                    let newPathString = "";

                    for(let i = 0; i < 12; i++) {
                        let group = document.getElementById(`group-${i}`);
                        let dot = document.getElementById(`dot-${i}`);
                        let textVal = document.getElementById(`val-${i}`);
                        let textLabel = document.getElementById(`label-${i}`);

                        if(i < dataCount) {
                            let val = parseInt(data[i].val) || 0;
                            let valCapped = Math.min(val, 20);
                            let y = 185 - (valCapped * 8.25);
                            let x = startX + (i * stepX);

                            if (i === 0) newPathString += `M ${x},${y} `;
                            else newPathString += `L ${x},${y} `;

                            group.style.opacity = 1;
                            dot.setAttribute('cx', x);
                            dot.setAttribute('cy', y);
                            textVal.setAttribute('x', x);
                            textVal.setAttribute('y', y - 12);
                            textVal.textContent = val > 0 ? val : '';
                            textLabel.setAttribute('x', x);
                            textLabel.textContent = data[i].label;

                        } else {
                            group.style.opacity = 0; 
                        }
                    }

                    let lastX = startX + ((dataCount - 1) * stepX);
                    let newAreaString = newPathString + `L ${lastX},185 L ${startX},185 Z`;

                    document.getElementById('svgLinePath').setAttribute('d', newPathString);
                    document.getElementById('svgAreaPath').setAttribute('d', newAreaString);
                })
                .catch(error => {
                    console.error('AJAX Error:', error);
                    window.location.href = url;
                });
            }
    </script>
</body>
</html>