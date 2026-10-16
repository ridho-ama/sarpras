<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Fasilitas - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous">
        if (localStorage.getItem('dark-mode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-active');
        }
    </script>
    <style>
        .category-grid-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            width: 100%;
            margin-top: 20px;
            box-sizing: border-box;
        }
        
        .category-card {
            background-color: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 2px solid #E2E8F0;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            position: relative;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.08);
            border-color: #046D64;
        }

        .category-img-container {
            width: 100%;
            height: 180px;
            background-color: #C3E2FF;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .category-img-container img { width: 100%; height: 100%; object-fit: cover; }
        .category-img-placeholder { color: #046D64; font-size: 3rem; }

        .category-info-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .category-info-body h3 {
            font-size: 1.15rem; font-weight: 700; color: #1E293B; margin-bottom: 8px; line-height: 1.3;
        }
        .category-info-body p {
            font-size: 0.85rem; color: #64748B; line-height: 1.5; margin-bottom: 15px; flex-grow: 1;
        }

        .category-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px dashed #E2E8F0;
        }

        .category-badge-count {
            background-color: #F1F5F9; color: #475569; font-size: 0.75rem;
            font-weight: 700; padding: 6px 12px; border-radius: 20px;
        }

        .btn-delete-category {
            background-color: #FEE2E2; color: #DC2626; border: none; padding: 8px 12px;
            border-radius: 8px; cursor: pointer; transition: background 0.2s;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-delete-category:hover { background-color: #DC2626; color: white; }

        .dark-mode-active .category-card { background-color: #1E293B !important; border-color: #334155 !important; }
        .dark-mode-active .category-info-body h3 { color: #F8FAFC !important; }
        .dark-mode-active .category-badge-count { background-color: #334155; color: #CBD5E1; }
        .dark-mode-active .category-footer { border-top-color: #334155; }

        @media (max-width: 768px) {
            .content-header { display: flex; flex-direction: column; gap: 15px; }
            .btn-create-report { width: 100%; justify-content: center; }
            
            .category-grid-box {
                grid-template-columns: 2fr;
            }
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
                <li class="menu-item active"><a href="{{ route('admin.facility.index') }}"><i class="fa-solid fa-boxes-stacked"></i> Fasilitas</a></li>
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
        
        <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>

    <main class="main-content">
        <header class="content-header" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap;">
            <div class="content-title">
                <h1>Master Kategori Fasilitas</h1>
                <p>Silakan pilih rumpun kategori utama untuk mengelola daftar sub-kategori ruangan fungsional sekolah.</p>
            </div>
            <button type="button" class="btn-create-report" onclick="openAddCategoryModal()" style="background-color: #046D64; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 0.95rem; cursor: pointer;">
                <i class="fa-solid fa-plus"></i> Tambah Kategori
            </button>
        </header>

        @if(session('success'))
            <div style="background-color: #D1E7DD; color: #0F5132; padding: 12px 16px; border-radius: 8px; margin-bottom: 25px; font-size: 0.9rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif
        
        <section class="category-grid-box">
            @forelse ($categories as $category)
                <div class="category-card" onclick="window.location='{{ route('admin.facility.show', $category->id) }}'" style="cursor: pointer;">
                    
                    <div class="category-img-container">
                        @if($category->image_category && file_exists(public_path('images/facilities/' .$category->image_category)))
                            <img src="{{ asset('images/facilities/' . $category->image_category) }}" alt="{{ $category->name_category }}">
                        @else
                            <div class="category-img-placeholder"><i class="fa-solid fa-building-shield"></i></div>
                        @endif
                    </div>

                    <div class="category-info-body">
                        <h3>{{ $category->name_category }}</h3>
                        <p>{{ $category->description_category ?? 'Belum ada penjelasan deskripsi singkat mengenai kategori sarpras ini.' }}</p>
                        
                        <div class="category-footer">
                            <div class="category-badge-count">
                                <i class="fa-solid fa-layer-group me-1"></i> {{ $category->facilities_count }} Sub-Kategori / Ruang
                            </div>
                            
                            <!-- Tombol Hapus: memanggil Modal Mewah secara spesifik (Stop Propagation di JS) -->
                            <button type="button" class="btn-delete-category" 
                                    onclick="triggerCategoryDelete(event, '{{ $category->id }}', {{ json_encode($category->name_category) }})" 
                                    title="Hapus Kategori">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px 0; color: #94A3B8; background: #FFFFFF; border-radius: 16px; border: 2px dashed #E2E8F0;">
                    <i class="fa-regular fa-folder-open fa-3x" style="display: block; margin-bottom: 12px; color: #CBD5E1;"></i>
                    Belum ada data rumpun kategori master sarpras di database.
                </div>
            @endforelse
        </section>
    </main>

    <!-- MODAL TAMBAH KATEGORI -->
    <div id="addCategoryModal" class="modal-overlay" onclick="closeAddCategoryModal(event)" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100; justify-content: center; align-items: center;">
        <div class="modal-window" onclick="event.stopPropagation()" style="background: white; padding: 25px; border-radius: 15px; width: 90%; max-width: 450px; position: relative;">
            <button class="modal-close-btn" onclick="document.getElementById('addCategoryModal').style.display = 'none'" style="position: absolute; right: 20px; top: 20px; border: none; background: transparent; font-size: 1.5rem; cursor: pointer;">&times;</button>
            <h3 style="margin-bottom: 5px; font-size: 1.25rem; font-weight: 700; color: #1E293B;">Tambah Kategori Utama</h3>
            <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 15px; font-style: italic;">Membuat rumpun kelompok induk sarpras baru sekolah</p>
            <hr style="border: 0; border-top: 1px solid #E2E8F0; margin-bottom: 15px;">
            
            <form action="{{ route('admin.facility.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf
                <input type="hidden" name="form_type" value="category">
                
                <div class="auth-form-group">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #475569; display: block; margin-bottom: 5px;">Nama Kategori Utama</label>
                    <input type="text" class="auth-input-field" name="name_category" placeholder="Contoh: Gedung Praktek Vokasi" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #CBD5E1; box-sizing: border-box;">
                </div>

                <div class="auth-form-group">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #475569; display: block; margin-bottom: 5px;">Deskripsi Singkat</label>
                    <textarea class="auth-input-field" name="description_category" placeholder="Jelaskan fungsi peruntukan rumpun kelompok bangunan ini..." style="width: 100%; min-height: 80px; resize: vertical; padding: 10px; border-radius: 8px; border: 1px solid #CBD5E1; box-sizing: border-box; font-family: inherit;" required></textarea>
                </div>

                <div class="auth-form-group">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #475569; display: block; margin-bottom: 5px;">Gambar Ilustrasi / Sampul (Opsional)</label>
                    <input type="file" class="auth-input-field" name="image_category" accept="image/*" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #CBD5E1; box-sizing: border-box;">
                    <small style="color: #94A3B8; font-size: 0.75rem; display: block; margin-top: 3px;">Format: PNG, JPG, JPEG (Maks. 2MB)</small>
                </div>

                <button type="submit" class="btn-submit-green" style="width: 100%; cursor: pointer; border: none; background-color: #046D64; color: white; padding: 12px; border-radius: 8px; font-weight: bold; margin-top: 10px;">Simpan Kategori</button>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS KATEGORI MEWAH CUSTOM -->
    <div id="mewahCategoryDeleteModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.7); z-index: 9999999; justify-content: center; align-items: center;" onclick="if(event.target === this) closeCategoryDelete()">
        <div style="background-color: #FFFFFF; border-radius: 20px; padding: 30px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5); position: relative; opacity: 1;">
            
            <div style="width: 60px; height: 60px; background-color: #FFE4E6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <i class="fa-solid fa-trash-arrow-up" style="color: #E11D48; font-size: 1.5rem;"></i>
            </div>
            
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #1E293B; margin-top: 0; margin-bottom: 10px;">Hapus Kategori Induk?</h3>
            
            <p id="deleteCategoryModalTitle" style="font-weight: 600; color: #475569; font-style: italic; margin-bottom: 15px; word-break: break-word;"></p>
            
            <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 25px; line-height: 1.5;">Peringatan keras: Tindakan ini bersifat permanen. <b>Seluruh data sub-fasilitas</b> dan laporan perbaikan di bawah kategori ini akan ikut <b>terhapus secara total</b>.</p>
            
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeCategoryDelete()" style="flex: 1; padding: 12px; background-color: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; border-radius: 10px; font-weight: 700; cursor: pointer;">Batalkan</button>
                <form id="mewahCategoryDeleteForm" action="" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; padding: 12px; background-color: #E11D48; color: #FFF; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Ya, Hapus Semua</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sidebar Logika
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

        // =========================================
        // Modal Tambah Kategori
        // =========================================
        window.openAddCategoryModal = function() {
            document.getElementById('addCategoryModal').style.display = 'flex';
        };

        window.closeAddCategoryModal = function(event = null) {
            if (!event || event.target.id === 'addCategoryModal') {
                document.getElementById('addCategoryModal').style.display = 'none';
            }
        };

        // =========================================
        // Modal Hapus Kategori (Mewah)
        // =========================================
        window.triggerCategoryDelete = function(event, id, title) {
            event.stopPropagation(); // Mencegah klik menyebar ke card parent (biar nggak pindah halaman)
            
            const modal = document.getElementById('mewahCategoryDeleteModal');
            const titleElem = document.getElementById('deleteCategoryModalTitle');
            const formElem = document.getElementById('mewahCategoryDeleteForm');

            if (titleElem) {
                titleElem.textContent = `"${title}"`;
            }

            if (formElem) {
                // Route penghapusan Kategori Induk. Ganti 'PLACEHOLDER_ID' menggunakan route helper Laravel
                let baseUrl = "{{ route('admin.facility.destroy_category', 'PLACEHOLDER_ID') }}";
                formElem.action = baseUrl.replace('PLACEHOLDER_ID', id);
            }

            if (modal) {
                modal.style.setProperty('display', 'flex', 'important');
            }
        };

        window.closeCategoryDelete = function() {
            const modal = document.getElementById('mewahCategoryDeleteModal');
            if (modal) {
                modal.style.setProperty('display', 'none', 'important');
            }
        };
    </script>
</body>
</html>