<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $report->id }} - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show-report-admin.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    <script>
        if (localStorage.getItem('dark-mode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-active');
        }
    </script>
</head>
<body>

    <!-- REVISI: NAVBAR ATAS KHUSUS HP (Hamburger & Profil) -->
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

    <!-- LAPISAN KACA BACKDROP -->
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
    </aside>

    <main class="main-content">
        <header class="content-header">
            <div class="header-title-wrapper">
                <a href="{{ route('admin.report.index') }}" class="btn-back-box" title="Kembali ke Rumpun Kategori">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="title-text-box">
                    <h1>Detail Informasi Pengaduan</h1>
                    <p>Kode Tiket Laporan: #SRPR-00{{ $report->id }}</p>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div style="background-color: #D1E7DD; color: #0F5132; padding: 12px 16px; border-radius: 8px; margin-bottom: 25px; font-size: 0.9rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="detail-grid">
            <!-- KOLOM KIRI: Deskripsi Aduan, Foto Awal, & Catatan Alasan Terpisah -->
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
                        <p style="color: #94A3B8; font-size: 0.9rem; font-style: italic; text-align: center; padding: 20px 0;">Siswa/Guru tidak melampirkan foto bukti awal.</p>
                    @endif
                </div>
                
                @php
                    $lastHistoryWithPhoto = $report->histories->whereNotNull('photo')->last();
                @endphp

                @if($lastHistoryWithPhoto)
                    <div class="info-card" style="border: 2px solid #10B981; margin-top: 25px; background-color: #FFFFFF;">
                        <div class="info-title" style="color: #10B981; font-weight: 800; border-bottom: 2px solid #E8F5E9; padding-bottom: 10px; margin-bottom: 15px;">
                            <i class="fa-solid fa-square-check me-2"></i>Bukti Penyelesaian Pekerjaan (Terbaru)
                        </div>
                        <div style="font-size: 0.85rem; color: #475569; margin-bottom: 12px; background-color: #F4FBF7; padding: 10px; border-radius: 8px; border-left: 3px solid #10B981;">
                            <strong>Catatan Akhir:</strong> "{{ $lastHistoryWithPhoto->note }}"
                        </div>
                        <img src="{{ asset('storage/' . $lastHistoryWithPhoto->photo) }}" alt="Bukti Selesai Lapangan" class="img-preview-box" style="width: 100%; border-radius: 10px; border: 1px solid #C8E6C9;">
                    </div>
                @endif
            </div>

            <!-- KOLOM KANAN: Status, Atribut & Tombol Pemicu Pop-Up Modal -->
            <div>
                <div class="info-card">
                    <div class="info-title"><i class="fa-solid fa-circle-info me-2"></i>Atribut Laporan</div>
                    <div class="meta-list">
                        <div class="meta-item">
                            <span class="meta-label">Status Terkini</span>
                            <td class="td-status">
                                @if($report->status == 'Proses')
                                    <span class="status-pill status-proses">Proses</span>
                                @endif
                                @if($report->status == 'Tolak')
                                    <span class="status-pill status-tolak">Tolak</span>
                                @endif
                                @if($report->status == 'Selesai')
                                    <span class="status-pill status-selesai">Selesai</span>
                                @endif
                                @if($report->status == 'Pending')
                                    <span class="status-pill status-pending">Pending</span>
                                @endif
                            </td>
                        </div>
                        <div class="meta-item"><span class="meta-label">Nama Pelapor</span><span class="meta-value" style="font-size: 0.85rem;">{{ $report->user->name }}</span></div>
                        <div class="meta-item"><span class="meta-label">Kelas/Jabatan</span><span class="meta-value">{{ $report->user->class ?? 'Siswa/Guru' }}</span></div>
                        <div class="meta-item">
                            <span class="meta-label">Lokasi Ruang</span>
                            <span class="meta-value" style="text-align: right; max-width: 60%; word-break: break-word; color: #046D64;">
                                @if(!empty($report->location_custom))
                                    {{ $report->location_custom }}
                                @else
                                    {{ $report->facility->location }}
                                @endif
                            </span>
                        </div>
                        <div class="meta-item"><span class="meta-label">Fasilitas</span><span class="meta-value" style="font-size: 0.85rem;">{{ $report->facility->name_facility }}</span></div>
                        <div class="meta-item"><span class="meta-label">Tgl Dilaporkan</span><span class="meta-value">{{ \Carbon\Carbon::parse($report->date_report)->locale('id')->isoFormat('D MMMM Y') }}</span></div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; width: 100%;">
                    <!-- Tombol 1: Tanggapi Laporan (Hijau) -->
                    <button type="button" class="btn-tanggapi-admin" onclick="openTanggapiModal()" style="margin-bottom: 0;">
                        <i class="fa-solid fa-reply"></i> Tanggapi Laporan
                    </button>

                    <!-- Tombol 2: Hapus Laporan (Merah Mewah Gradasi) -->
                    <button type="button" onclick="triggerMewahDelete('{{ $report->id }}', '{{ addslashes($report->title) }}')" style="background: linear-gradient(135deg, #EF4444, #DC2626); color: #FFFFFF; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; justify-content: center; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2); transition: all 0.2s; width: 100%;">
                        <i class="fa-solid fa-trash-can"></i> Hapus Berkas Laporan
                    </button>
                </div>

                <div class="info-card">
                    <div class="info-title"><i class="fa-solid fa-clock-rotate-left me-2"></i>Log Aktivitas Perbaikan</div>
                    
                    <!-- BUNGKUS DENGAN ID INI UNTUK TARGET AJAX -->
                    <div id="history-container" style="transition: opacity 0.4s ease-in-out;">
                        <!-- GANTI $report->histories menjadi $histories -->
                        @if($histories->count() > 0)
                            <ul class="timeline">
                                @foreach($histories as $history)
                                    <li class="timeline-item">
                                        <div class="timeline-date">
                                            {{ \Carbon\Carbon::parse($history->date_update)->locale('id')->isoFormat('dddd, D MMM Y, HH:mm') }} WIB
                                        </div>
                                        <div class="timeline-note">{{ $history->note }}</div>
                                        <small style="color: #046D64; font-size: 0.75rem; display: block; margin-top: 4px; font-weight: 700;">
                                            Oleh: {{ $history->user->name }} ({{ $history->user->role === 'admin' ? 'Staff Sarpras' : 'User' }})
                                        </small>
                                        @if($history->photo)
                                            <div style="margin-top: 10px;">
                                                <p style="font-size: 0.8rem; font-weight: 700; color: #10B981; margin-bottom: 5px;"><i class="fa-solid fa-camera me-1"></i> Lampiran Foto Bukti Selesai:</p>
                                                <img src="{{ asset('storage/' . $history->photo) }}" alt="Bukti Selesai" class="img-preview-box" style="max-height: 200px; width: 100%; object-fit: cover; border-radius: 8px;">
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            
                            <!-- Pagination -->
                            <div class="pagination-wrapper-custom">
                                {{ $histories->appends(request()->except('history_page'))->links() }}
                            </div>
                        @else
                            <p style="color: #94A3B8; font-size: 0.85rem; font-style: italic; line-height: 1.4;">Belum ada rekam jejak aktivitas penanganan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div> 
    </main>

    <!-- MODAL FORM TANGGAPI LAPORAN -->
    <div id="tanggapiModal" class="modal-overlay" onclick="closeTanggapiModal(event)" style="background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px);">
        <div class="modal-window" onclick="event.stopPropagation()" style="border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); border: 1px solid #E2E8F0; padding: 35px;">
            <button class="modal-close-btn" onclick="document.getElementById('tanggapiModal').style.display = 'none'" style="font-size: 1.6rem; color: #94A3B8;">&times;</button>
            
            <h3 style="font-size: 1.4rem; font-weight: 800; color: #046D64; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-file-signature"></i> Form Tanggapi Laporan
            </h3>
            <p style="font-size: 0.85rem; color: #64748B; margin-top: 4px; margin-bottom: 20px;">Silakan berikan verifikasi fungsional berkas penanganan sarpras sekolah.</p>
            <hr style="border: 0; border-top: 1px solid #F1F5F9; margin-bottom: 20px;">
            
            <form action="{{ route('admin.report.updateStatus', $report->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; width: 100%; gap: 15px;">                
                @csrf
                <div style="width: 100%; display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 700; font-size: 0.85rem; color: #475569;">Ubah Status</label>
                    <select class="auth-input-field" name="status" style="width: 100%; padding: 11px;" onchange="togglePhotoProofField(this.value)" required>
                        <option value="Pending" {{ $report->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Proses" {{ $report->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ $report->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Tolak" {{ $report->status == 'Tolak' ? 'selected' : '' }}>Tolak</option>
                    </select>
                </div>

                <div style="width: 100%; display: flex; flex-direction: column; gap: 5px;">
                    <label style="font-weight: 700; font-size: 0.85rem; color: #475569;">Catatan / Progress Tindakan</label>
                    <textarea class="auth-input-field" name="note" placeholder="Tuliskan catatan penanganan..." style="width: 100%; min-height: 100px; padding: 12px; box-sizing: border-box;" required></textarea>
                </div>

                <div id="photoProofGroup" style="width: 100%; display: {{ $report->status == 'Selesai' ? 'block' : 'none' }};">
                    <label style="font-weight: 700; font-size: 0.85rem; color: #10B981; display: block; margin-bottom: 5px;">Upload Foto Bukti Selesai</label>
                    <input type="file" class="auth-input-field" name="photo_proof" accept="image/*" style="width: 100%;">
                </div>

                <button type="submit" class="btn-submit-green" style="width: 100%; padding: 12px; margin-top: 5px;">Simpan Tanggapan</button>
            </form>
        </div>
    </div>


    <!-- MODAL HAPUS PERMANEN -->
    <div id="mewahDeleteModal" class="delete-modal-overlay" onclick="closeMewahDelete()">
        <div class="delete-modal-window" onclick="event.stopPropagation()">
            <div class="delete-icon-circle">
                <i class="fa-solid fa-trash-arrow-up"></i>
            </div>
            
            <h3>Hapus Berkas Laporan?</h3>
            <p id="deleteModalReportTitle" style="font-weight: 600; color: #475569; font-style: italic; word-break: break-word;"></p>
            <p style="margin-top: -15px; margin-bottom: 20px; font-size: 0.85rem; color:#64748B;">Tindakan ini bersifat permanen. Seluruh data rekam jejak keluhan serta lampiran foto log perbaikan akan dihapus total dari database sarpras sekolah.</p>
            
            <div class="delete-action-buttons">
                <button type="button" class="btn-delete-cancel" onclick="closeMewahDelete()">Batalkan</button>
                <form action="{{ route('admin.report.destroy', $report->id) }}" method="POST" style="margin: 0; padding: 0; flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-confirm-red">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // SCRIPT TAMBAHAN: Untuk Membuka dan Menutup Sidebar di HP
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

        // Script Asli
        function triggerMewahDelete(id, reportTitle) {
            const modal = document.getElementById('mewahDeleteModal');
            document.getElementById('deleteModalReportTitle').innerText = '"' + reportTitle + '"';
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('show-active');
            }, 10);
        }

        function closeMewahDelete() {
            const modal = document.getElementById('mewahDeleteModal');
            modal.classList.remove('show-active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        function openTanggapiModal() {
            document.getElementById('tanggapiModal').style.display = 'flex';
        }

        function closeTanggapiModal(event) {
            document.getElementById('tanggapiModal').style.display = 'none';
        }

        function togglePhotoProofField(statusValue) {
            const photoGroup = document.getElementById('photoProofGroup');
            const fileInput = photoGroup.querySelector('input[type="file"]');
            
            if (statusValue === 'Selesai') {
                photoGroup.style.display = 'block';
                fileInput.setAttribute('required', 'true');
            } else {
                photoGroup.style.display = 'none';
                fileInput.removeAttribute('required');
                fileInput.value = '';
            }
        }
        // ==============================================================
        // SCRIPT AJAX SMOOTH PAGINATION (Tanpa Reload)
        // ==============================================================
        document.addEventListener('click', function(e) {
            // Tangkap klik hanya pada link (angka) di dalam pagination custom
            let paginationLink = e.target.closest('.pagination-wrapper-custom a');
            
            if (paginationLink) {
                e.preventDefault(); // Cegah halaman reload
                let url = paginationLink.href;
                fetchSmoothPagination(url);
            }
        });

        function fetchSmoothPagination(url) {
            let container = document.getElementById('history-container');
            
            // Berikan efek memudar (loading)
            container.style.opacity = '0.2';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Konversi teks HTML menjadi struktur DOM
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, 'text/html');
                
                // Ambil isi div history-container yang baru dari server
                let newContainer = doc.getElementById('history-container');
                
                if (newContainer) {
                    // Timpa isi HTML lama dengan yang baru
                    container.innerHTML = newContainer.innerHTML;
                    
                    // Ubah URL di address bar browser agar tetap bisa di-copy
                    window.history.pushState(null, '', url);
                }
                
                // Kembalikan opacity agar muncul (fade-in)
                setTimeout(() => {
                    container.style.opacity = '1';
                }, 50);
            })
            .catch(error => {
                console.error('Gagal mengambil data pagination:', error);
                container.style.opacity = '1';
                window.location.href = url; // Fallback jika AJAX gagal, kembali ke reload normal
            });
        }
    </script>
</body>
</html>