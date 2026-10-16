<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $report->id }} - Sarpras Digital</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- =========================================================
         NAVBAR DESKTOP
    ========================================================== -->
    <nav class="desktop-navbar">
        <a href="{{ route('user.dashboard') }}" class="nav-brand">
            <img src="{{ asset('images/kasa.png') }}" alt="Logo">
            <div class="nav-brand-text">
                <span class="nav-brand-title">SARPRAS DIGITAL</span>
                <span class="nav-brand-subtitle">SMK ANGKASA 1 MARGAHAYU</span>
            </div>
        </a>

        <div class="nav-menu">
            <a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i><span>Tampilan</span></a>
            <a href="{{ route('user.report.index') }}"><i class="fa-regular fa-file-lines"></i><span>Daftar Laporan</span></a>
            <a href="{{ route('user.about') }}"><i class="fa-solid fa-circle-info"></i><span>TentangAplikasi</span></a>
        </div>

        <div class="nav-profile-group">
            <a href="{{ route('user.profile') }}" class="nav-profile-pill">
                @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profil">
                @else
                    <img src="https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60" alt="Avatar">
                @endif
                <div class="nav-profile-text">
                    <span style="font-size: 0.8rem; font-weight: 800; color: #1E293B; max-width: 100px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                        {{ Auth::user()->name }}
                    </span>
                    <span style="font-size: 0.65rem; font-weight: 700; color: #046D64; text-transform: uppercase; letter-spacing: 0.3px;">
                        {{ Auth::user()->role === 'admin' ? 'Staff Sarpras' : (Auth::user()->class ?? 'Pelapor') }}
                    </span>
                </div>
            </a>
            <!-- Tombol Logout dihapus sesuai permintaan -->
        </div>
    </nav>

    <!-- =========================================================
         NAVBAR MOBILE (HP)
    ========================================================== -->
    <nav class="mobile-top-navbar">
        <div class="brand">
            <img src="{{ asset('images/kasa.png') }}" alt="Logo" style="width: 35px; height: 35px; object-fit: contain;"> Sarpras
        </div>
        <a href="{{ route('user.profile') }}" style="display: block;">
            @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profil" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64;">
            @else
                <img src="https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60" alt="Avatar" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64;">
            @endif
        </a>
    </nav>
    <nav class="mobile-bottom-nav">
        <a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i><span>Tampilan</span></a>
        <a href="{{ route('user.report.index') }}"><i class="fa-solid fa-file-lines"></i><span>Daftar Laporan</span></a>
        <a href="{{ route('user.about') }}"><i class="fa-solid fa-circle-info"></i><span>TentangAplikasi</span></a>
    </nav>

    <!-- =========================================================
         MAIN CONTENT AREA
    ========================================================== -->
    <main class="main-container">
        
        <!-- HEADER BANNER HIJAU -->
        <div style="background: #046D64; border-radius: 16px; padding: 30px; color: white; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 30px; box-shadow: 0 10px 25px rgba(4, 109, 100, 0.2);">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 800; margin: 0 0 5px 0;">Detail Informasi Pengaduan</h1>
                <p style="margin: 0; opacity: 0.9; font-size: 0.95rem;">Kode Tiket Laporan: #SRPR-00{{ $report->id }}</p>
            </div>
            <a href="{{ route('user.report.index') }}" style="background: white; color: #046D64; padding: 12px 24px; border-radius: 10px; font-weight: 800; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-top: 15px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        <div class="detail-grid">
            <!-- KOLOM KIRI (Aduan User & Timbal Balik Admin) -->
            <div>
                <div class="info-card">
                    <h2 style="font-size: 1.4rem; font-weight: 700; color: #0F172A; margin-bottom: 15px;">{{ $report->title }}</h2>
                    <p style="font-size: 0.95rem; color: #475569; line-height: 1.6; white-space: pre-line;">{{ $report->description }}</p>
                </div>

                <div class="info-card">
                    <div class="info-title"><i class="fa-regular fa-image me-2"></i>Foto Bukti Kerusakan</div>
                    @if($report->photo && !str_contains($report->photo, 'reports_completed'))
                        <img src="{{ asset('storage/' . $report->photo) }}" alt="Bukti Kerusakan" class="img-preview-box">
                    @else
                        <p style="color: #94A3B8; font-size: 0.9rem; font-style: italic; text-align: center; padding: 20px 0;">Anda tidak melampirkan foto bukti awal.</p>
                    @endif
                </div>
                
                @php
                    $latestHistory = \App\Models\History::where('report_id', $report->id)->orderBy('date_update', 'desc')->first();
                    $lastHistoryWithPhoto = \App\Models\History::where('report_id', $report->id)->whereNotNull('photo')->orderBy('date_update', 'desc')->first();
                @endphp

                @if($latestHistory && $report->status != 'Pending')
                    <div class="info-card" style="border: 2px solid #046D64; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(4, 109, 100, 0.05); margin-bottom: 25px;">
                        <div style="color: #046D64; font-size: 1.15rem; font-weight: 800; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-regular fa-comment-dots"></i> Catatan / Alasan Penanganan Terkini
                        </div>
                        <div style="background-color: #F8FAFC; border-radius: 8px; padding: 16px; color: #334155; font-size: 0.95rem; line-height: 1.5; font-weight: 500;">
                            {{ $latestHistory->note }}
                        </div>
                    </div>
                @endif

                @if($lastHistoryWithPhoto)
                    <div class="info-card" style="border: 2px solid #10B981; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.05);">
                        <div style="color: #10B981; font-size: 1.15rem; font-weight: 800; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-camera"></i> Foto Bukti Selesai Perbaikan (Admin)
                        </div>
                        <img src="{{ asset('storage/' . $lastHistoryWithPhoto->photo) }}" alt="Bukti Penanganan Admin" style="width: 100%; border-radius: 10px; border: 1px solid #E2E8F0; max-height: 400px; object-fit: cover;">
                    </div>
                @endif
            </div>

            <!-- KOLOM KANAN (Atribut & Histori) -->
            <div>
                <div class="info-card">
                    <div class="info-title"><i class="fa-solid fa-circle-info me-2"></i>Atribut Laporan</div>
                    <div class="meta-list">
                        
                        <!-- PERBAIKAN: Status Pill (Warna Solid Cerah, Teks Putih) -->
                        <div class="meta-item">
                            <span class="meta-label">Status Terkini</span>
                            <td class="td-status">
                                @if($report->status == 'Proses') 
                                    <span style="background-color: #F59E0B; color: #FFFFFF; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block;">Proses</span> 
                                @endif
                                @if($report->status == 'Tolak') 
                                    <span style="background-color: #EF4444; color: #FFFFFF; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block;">Tolak</span> 
                                @endif
                                @if($report->status == 'Selesai') 
                                    <span style="background-color: #10B981; color: #FFFFFF; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block;">Selesai</span> 
                                @endif
                                @if($report->status == 'Pending') 
                                    <span style="background-color: #64748B; color: #FFFFFF; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block;">Pending</span> 
                                @endif
                            </td>
                        </div>

                        <div class="meta-item"><span class="meta-label">Nama Pelapor</span><span class="meta-value" style="font-size: 0.85rem;">{{ $report->user->name }}</span></div>
                        <div class="meta-item">
                            <span class="meta-label">Lokasi Ruang</span>
                            <span class="meta-value" style="color: #046D64;">
                                @if(!empty($report->location_custom)) {{ $report->location_custom }} @else {{ $report->facility->location }} @endif
                            </span>
                        </div>
                        <div class="meta-item"><span class="meta-label">Fasilitas</span><span class="meta-value" style="font-size: 0.85rem;">{{ $report->facility->name_facility }}</span></div>
                        <div class="meta-item"><span class="meta-label">Dilaporkan</span><span class="meta-value">{{ \Carbon\Carbon::parse($report->date_report)->locale('id')->isoFormat('D MMM Y') }}</span></div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-title"><i class="fa-solid fa-clock-rotate-left me-2"></i>Log Aktivitas Perbaikan</div>
                    
                    @if($histories->count() > 0)
                        <ul class="timeline">
                            @foreach($histories as $history)
                                <li class="timeline-item">
                                    <div class="timeline-date">{{ \Carbon\Carbon::parse($history->date_update)->locale('id')->isoFormat('D MMM Y, HH:mm') }} WIB</div>
                                    <div class="timeline-note">{{ $history->note }}</div>
                                    <small style="color: #046D64; font-size: 0.75rem; display: block; margin-top: 4px; font-weight: 700;">
                                        Oleh: {{ $history->user->name ?? 'Admin' }}
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                        
                        <!-- PEMANGGIL PAGINATION -->
                        <div class="pagination-wrapper-custom">
                            {{ $histories->appends(request()->except('history_page'))->links() }}
                        </div>
                    @else
                        <p style="color: #94A3B8; font-size: 0.85rem; font-style: italic; line-height: 1.4; margin: 0;">Laporan Anda belum ditangani oleh Admin.</p>
                    @endif
                </div>
            </div>
        </div> 
    </main>

</body>
</html>