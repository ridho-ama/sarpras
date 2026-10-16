<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sub-Kategori - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    <style>

        .search-filter-row {
            display: flex; justify-content: flex-start; align-items: center;
            margin-bottom: 20px; width: 100%;
        }
        .search-form-wrapper {
            display: flex; align-items: center; background-color: #FFFFFF;
            border: 2px solid #E2E8F0; border-radius: 10px; padding: 4px 6px 4px 15px;
            max-width: 500px; width: 100%; box-sizing: border-box; transition: border-color 0.2s;
        }
        .search-form-wrapper:focus-within { border-color: #046D64; }
        .search-input-box {
            border: none; outline: none; padding: 8px 5px; width: 100%; 
            font-size: 0.95rem; color: #1E293B; background: transparent;
        }
        .btn-clear-search {
            color: #94A3B8; font-size: 1.1rem; padding: 5px 12px;
            text-decoration: none; display: inline-flex; align-items: center; justify-content: center;
            transition: color 0.2s;
        }
        .btn-clear-search:hover { color: #EF4444; }
        .btn-search-trigger {
            background-color: #046D64; color: #FFFFFF; border: none; padding: 8px 18px;
            border-radius: 6px; cursor: pointer; font-weight: 700; font-size: 0.85rem;
        }
        .btn-search-trigger:hover { background-color: #03524B; }

        /* =========================================
         HEADER TITLE & BACK BUTTON BOX
        ----------------------------------------- */
        .header-title-wrapper {
            display: flex; align-items: flex-start; gap: 15px; margin-bottom: 15px;
        }
        .btn-back-box {
            display: inline-flex; justify-content: center; align-items: center;
            width: 42px; height: 42px; background-color: #F8FAFC; border: 1px solid #E2E8F0;
            border-radius: 10px; color: #475569; text-decoration: none; font-size: 1.1rem;
            flex-shrink: 0; transition: all 0.2s;
        }
        .btn-back-box:hover { background-color: #E2E8F0; color: #0F172A; }
        .title-text-box { display: flex; flex-direction: column; gap: 8px; }
        .title-text-box h1 { margin: 0; font-size: 1.6rem; font-weight: 800; color: #1E293B; }
        .title-text-box p { margin: 0; color: #64748B; font-size: 0.95rem; line-height: 1.5; }

        .data-card { background-color: #FFFFFF; border-radius: 20px; border: 2px solid #E2E8F0; padding: 25px; width: 100%; box-sizing: border-box; }
        .facility-table { width: 100%; border-collapse: collapse; min-width: 650px; }
        .facility-table th, .facility-table td { padding: 15px 12px; border-bottom: 1px solid #F1F5F9; font-size: 0.95rem; vertical-align: middle; }
        .facility-table th { text-align: left; color: #94A3B8; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; border-bottom: 2px solid #E2E8F0; padding-bottom: 12px; }
        
        .count-report-badge { background-color: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; display: inline-block; white-space: nowrap; }
        .count-report-badge.zero-case { background-color: #DCFCE7; color: #16A34A; }

        .btn-delete-category {
            background-color: #FEE2E2; color: #DC2626; border: none; padding: 8px 12px;
            border-radius: 8px; cursor: pointer; transition: background 0.2s;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-delete-category:hover { background-color: #DC2626; color: white; }

        .empty-state-wrapper { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 15px; text-align: center; }

        .delete-modal-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background: rgba(15, 23, 42, 0.5) !important;
            backdrop-filter: blur(4px) !important;
            z-index: 99999 !important;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .delete-modal-window {
            background: #FFFFFF;
            border-radius: 28px;
            padding: 30px 24px 24px 24px;
            max-width: 380px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: popInModal 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes popInModal {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }

        .delete-icon-circle {
            width: 64px;
            height: 64px;
            background-color: #FFE4E6;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
        }

        .delete-icon-circle i {
            color: #E11D48;
            font-size: 1.5rem;
        }

        .delete-action-buttons {
            display: flex;
            gap: 12px;
            width: 100%;
        }

        .btn-delete-cancel {
            background: #F1F5F9;
            color: #334155;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            flex: 1;
            cursor: pointer;
        }

        .btn-delete-confirm-red {
            background: #E11D48;
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
        }

        .btn-delete-confirm-red:hover {
            background-color: #BE123C;
        }

        @media (max-width: 768px) {
            .main-content { padding: 85px 14px 30px 14px !important; }
            .content-header { flex-direction: column; align-items: stretch; gap: 15px; margin-bottom: 20px !important; }
            .btn-back-box { display: none !important; }
            
            .header-title-wrapper {
                background-color: #FFFFFF; border: 1px solid #E2E8F0; padding: 15px; 
                border-radius: 12px; align-items: center; text-align: left; margin-bottom: 0;
            }
            .title-text-box h1 { font-size: 1.25rem; }
            .title-text-box p { font-size: 0.85rem; }
            .btn-back-box { width: 38px; height: 38px; font-size: 1rem; }

            .btn-create-report { width: 100% !important; justify-content: center; }
            .data-card { padding: 15px !important; border-radius: 16px !important; }
            .admin-table-responsive-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }
    </style>
</head>
<body>

    <div class="admin-mobile-top-navbar-container">
        <button type="button" class="admin-mobile-hamburger-trigger" id="mobileHamburgerBtn" title="Buka Menu Navigasi Admin">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="admin-mobile-nav-profile-right">
            @auth
                <a href="{{ route('admin.profile') }}" class="admin-mobile-avatar-link" title="Lihat Profil Admin">
                    @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Avatar {{ Auth::user()->name }}">
                    @else
                        <img src="https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww" alt="Avatar Default">
                    @endif
                </a>
                <div class="admin-mobile-profile-text-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <span>Admin</span>
                </div>
            @endauth
        </div>
    </div>

    <div class="admin-sidebar-overlay-backdrop" id="sidebarBackdropClose"></div>

    <aside class="sidebar">
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
                <li class="menu-item {{ Request::routeIs('admin.facility.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.facility.index') }}"><i class="fa-solid fa-boxes-stacked"></i> Fasilitas</a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.manauser') ? 'active' : '' }}">
                    <a href="{{ route('admin.manauser') }}"><i class="fa-solid fa-users"></i> Data Pengguna</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('welcome') }}"><i class="fa-solid fa-house"></i> welcome</a>
                </li>
            </ul> 
        </div>

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
        <header class="content-header" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; margin-bottom: 25px;">
            <div class="header-title-wrapper">
                <a href="{{ route('admin.facility.index') }}" class="btn-back-box" title="Kembali ke Rumpun Kategori">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="title-text-box">
                    <h1>{{ $category->name_category }}</h1>
                    <p>Mengelola jajaran sub-kategori ruangan fisik beserta kontrol peninjauan intensitas laporan kerusakan.</p>
                </div>
            </div>

            <button type="button" class="btn-create-report" onclick="openAddSubModal()" style="background-color: #046D64; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-plus"></i> Tambah Sub-Kategori
            </button>
        </header>

        @if(session('success'))
            <div style="background-color: #D1E7DD; color: #0F5132; padding: 12px 16px; border-radius: 12px; margin-bottom: 25px; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 8px; border: 1px solid #BADBCC;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="search-filter-row">
            <form action="{{ route('admin.facility.show', $category->id) }}" method="GET" class="search-form-wrapper">
                <i class="fa-solid fa-magnifying-glass" style="color: #94A3B8; margin-left: 5px;"></i>
                <input type="text" name="search" class="search-input-box" placeholder="Cari nama ruangan atau lokasi..." value="{{ $search }}">
                
                @if($search)
                    <a href="{{ route('admin.facility.show', $category->id) }}" class="btn-clear-search" title="Bersihkan Hasil Pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
                
                <button type="submit" class="btn-search-trigger">Cari</button>
            </form>
        </div>

        <section class="data-card">
            <div class="data-card-header" style="margin-bottom: 20px;">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0F172A;">Daftar Sub-Kategori Ruangan</h3>
            </div>

            <div class="admin-table-responsive-wrapper">
                <table class="facility-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Sub-Kategori</th>
                            <th style="width: 30%;">Lokasi</th>
                            <th style="width: 15%; text-align: center;">Laporan</th>
                            <th style="width: 10%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subCategories as $sub)
                            <tr>
                                <td>
                                    <span style="font-weight: 800; color: #046D64; background-color: #E6F4F1; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; white-space: nowrap;">
                                        {{ $sub->name_facility }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #475569; font-size: 0.9rem;">{{ $sub->location }}</span>
                                </td>
                                <td style="text-align: center;">
                                    @if($sub->reports_count > 0)
                                        <span class="count-report-badge">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $sub->reports_count }} Laporan
                                        </span>
                                    @else
                                        <span class="count-report-badge zero-case">
                                            <i class="fa-solid fa-circle-check me-1"></i> 0 Laporan
                                        </span>
                                    @endif
                                </td>
                                
                                <td style="text-align: right;">
                                    <td style="text-align: right;">
                                        <button type="button" 
                                                class="btn-delete-category" 
                                                onclick="triggerMewahDelete('{{ $sub->id }}', {{ json_encode($sub->name_facility) }})" 
                                                title="Hapus Ruangan">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state-wrapper">
                                        <i class="fa-regular fa-folder-open fa-2x" style="color: #CBD5E1; margin-bottom: 15px;"></i>
                                        @if($search)
                                            <span style="color: #94A3B8; font-size: 0.9rem; line-height: 1.5;">Hasil pencarian untuk <strong style="color:#475569;">"{{ $search }}"</strong> tidak ditemukan.</span>
                                        @else
                                            <span style="color: #94A3B8; font-size: 0.9rem; line-height: 1.5;">Belum ada data sub-kategori ruangan fungsional di dalam rumpun kategori ini.</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <div id="addSubModal" class="modal-overlay" onclick="closeAddSubModal(event)" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100; justify-content: center; align-items: center;">
        <div class="modal-window" onclick="event.stopPropagation()" style="background: white; padding: 25px; border-radius: 15px; width: 90%; max-width: 450px; position: relative;">
            <button class="modal-close-btn" onclick="document.getElementById('addSubModal').style.display = 'none'" style="position: absolute; right: 20px; top: 20px; border: none; background: transparent; font-size: 1.5rem; cursor: pointer;">&times;</button>
            <h3 style="margin-bottom: 5px; font-size: 1.25rem; font-weight: 700; color: #1E293B;">Tambah Sub-Kategori</h3>
            <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 15px; font-style: italic;">Menambahkan unit ruangan atau sarpras fisik baru</p>
            <hr style="border: 0; border-top: 1px solid #E2E8F0; margin-bottom: 15px;">
            
            <form action="{{ route('admin.facility.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf
                <input type="hidden" name="form_type" value="subcategory">
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                
                <div class="auth-form-group">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #475569; display: block; margin-bottom: 5px;">Nama Ruangan / Sub-Kategori</label>
                    <input type="text" class="auth-input-field" name="name_facility" placeholder="Contoh: RUANG KELAS, LAB, STUDIO, TEFA" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #CBD5E1; box-sizing: border-box;">
                    <small style="color: #94A3B8; font-size: 0.75rem; display: block; margin-top: 3px;">Sistem akan mengonversi teks menjadi huruf besar otomatis.</small>
                </div>

                <div class="auth-form-group">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #475569; display: block; margin-bottom: 5px;">Lokasi Spesifik / Blok Gedung</label>
                    <input type="text" class="auth-input-field" name="location" placeholder="Contoh: Gedung B Lantai 2" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #CBD5E1; box-sizing: border-box;">
                </div>

                <button type="submit" class="btn-submit-green" style="width: 100%; cursor: pointer; border: none; background-color: #046D64; color: white; padding: 12px; border-radius: 8px; font-weight: bold; margin-top: 10px;">Simpan Sub-Kategori</button>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Navigasi Mobile
            const hamburgerBtn = document.getElementById('mobileHamburgerBtn');
            const sidebarElement = document.querySelector('.sidebar');

            if (hamburgerBtn && sidebarElement) {
                hamburgerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    sidebarElement.classList.add('sidebar-open');
                });
            }

            document.addEventListener('click', function(event) {
                if (sidebarElement && sidebarElement.classList.contains('sidebar-open')) {
                    if (!sidebarElement.contains(event.target)) {
                        closeAdminMobileSidebar();
                    }
                }
            });

            window.closeAdminMobileSidebar = function() {
                if (sidebarElement && sidebarElement.classList.contains('sidebar-open')) {
                    sidebarElement.classList.remove('sidebar-open');
                }
            };
        });

        // Modal Tambah Sub-Kategori
        window.openAddSubModal = function() {
            const modal = document.getElementById('addSubModal');
            if (modal) modal.style.display = 'flex';
        };

        window.closeAddSubModal = function(event = null) {
            if (!event || event.target.id === 'addSubModal') {
                const modal = document.getElementById('addSubModal');
                if (modal) modal.style.display = 'none';
            }
        };

        // Modal Hapus Mewah Custom (Global Window Function)
        window.triggerMewahDelete = function(id, title) {
            const modal = document.getElementById('mewahDeleteModal');
            const titleElem = document.getElementById('deleteModalReportTitle');
            const formElem = document.getElementById('mewahDeleteForm');

            // 1. Tampilkan judul ruangan di modal
            if (titleElem) {
                titleElem.textContent = `"${title}"`;
            }

            // 2. Buat URL dinamis yang 100% akurat dengan rute Laravel
            if (formElem) {
                // Laravel akan mencetak URL rute asli dengan 'PLACEHOLDER_ID'
                let baseUrl = "{{ route('admin.facility.destroy', 'PLACEHOLDER_ID') }}";
                
                // Ganti teks 'PLACEHOLDER_ID' dengan id asli dari parameter tombol
                formElem.action = baseUrl.replace('PLACEHOLDER_ID', id);
            }

            // 3. Munculkan modal
            if (modal) {
                modal.style.setProperty('display', 'flex', 'important');
            }
        };
        window.closeMewahDelete = function() {
            const modal = document.getElementById('mewahDeleteModal');
            if (modal) {
                modal.style.setProperty('display', 'none', 'important');
            }
        };
    </script>
    <div id="mewahDeleteModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.7); z-index: 9999999; justify-content: center; align-items: center;" onclick="if(event.target === this) closeMewahDelete()">
        <div style="background-color: #FFFFFF; border-radius: 20px; padding: 30px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5); position: relative; opacity: 1;">
            <div style="width: 60px; height: 60px; background-color: #FFE4E6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <i class="fa-solid fa-trash-arrow-up" style="color: #E11D48; font-size: 1.5rem;"></i>
            </div>
                <h3 style="font-size: 1.3rem; font-weight: 800; color: #1E293B; margin-top: 0; margin-bottom: 10px;">Hapus Sub-Kategori?</h3>
                <p id="deleteModalReportTitle" style="font-weight: 600; color: #475569; font-style: italic; margin-bottom: 15px; word-break: break-word;"></p>
                <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 25px; line-height: 1.5;">Tindakan ini bersifat permanen. Seluruh data rekam jejak keluhan serta lampiran foto log perbaikan akan dihapus total dari database sarpras sekolah.</p>
                
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="closeMewahDelete()" style="flex: 1; padding: 12px; background-color: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; border-radius: 10px; font-weight: 700; cursor: pointer;">Batalkan</button>
                    <form id="mewahDeleteForm" action="" method="POST" style="flex: 1; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 100%; padding: 12px; background-color: #E11D48; color: #FFF; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Ya, Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>