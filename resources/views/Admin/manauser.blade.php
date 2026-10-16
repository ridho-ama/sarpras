<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?">
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
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
                <li class="menu-item">
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
        
        <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>


    <main class="main-content">
        <div class="users-main-wrapper">
            
            <header class="users-header-block" style="margin-top: 15px; margin-bottom: 20px;">
                <h1 style="font-size: 1.5rem; font-weight: 800; color: #1E293B; margin-bottom: 6px;">
                    Pusat Kendali Akun Pengguna
                </h1>
                <p style="font-size: 0.85rem; color: #64748B; line-height: 1.4; margin: 0;">
                    Memantau aktivitas, mengelola status pemblokiran hak akses, serta membersihkan akun palsu murid secara terpusat.
                </p>
            </header>

            @if(session('success'))
                <div style="background-color: #D1E7DD; color: #0F5132; padding: 14px 18px; border-radius: 10px; margin-bottom: 25px; font-size: 0.9rem; font-weight: 700; border: 1px solid #BADBCC; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <i class="fa-solid fa-circle-check me-2" style="font-size:1.1rem;"></i> {{ session('success') }}
                </div>
            @endif

            <section class="users-data-card">
                <div class="users-card-title">
                    <i class="fa-solid fa-user-shield" style="color: #046D64;"></i> 
                    Daftar Identitas Pengguna Terdaftar (Siswa & Guru)
                </div>

                <div class="users-table-responsive-scroll">
                    <table class="users-admin-table">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Nama Pengguna Sekolah</th>
                                <th style="width: 20%;">Nomor Identitas (NISN/NIP)</th>
                                <th style="width: 15%; text-align: center;">Jabatan</th>
                                <th style="width: 15%; text-align: center;">Total Laporan</th>
                                <th style="width: 20%; text-align: right; padding-right: 25px;">Tindakan Proteksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allUsers as $u)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <img src="{{ $u->photo ? asset('storage/' . $u->photo) : 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' }}" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid #CBD5E1; flex-shrink: 0;">
                                            <div>
                                                <strong style="color: #1E293B; display: block;">{{ $u->name }}</strong>
                                                <span style="font-size: 0.75rem; color: #64748B; font-weight: 600;">{{ $u->email }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="font-family: monospace; font-weight: 700; color: #475569; font-size: 1rem;">
                                        {{ $u->nisn_or_nip }}
                                    </td>

                                    <td style="text-align: center;">
                                        <span style="font-size: 0.75rem; font-weight: 700; padding: 4px 12px; border-radius: 12px; background-color: {{ $u->class === 'Guru' ? '#FEF3C7' : '#E0F2FE' }}; color: {{ $u->class === 'Guru' ? '#B45309' : '#0369A1' }};">
                                            {{ $u->class }}
                                        </span>
                                    </td>

                                    <td style="text-align: center;">
                                        <strong style="color: {{ $u->reports_count > 0 ? '#EF4444' : '#10B981' }}; font-size: 1rem;">
                                            {{ $u->reports_count }} Kasus
                                        </strong>
                                    </td>

                                    <td>
                                        <div class="users-action-flex-group" style="padding-right: 10px; display: flex; gap: 8px; justify-content: flex-end;">
                                            
                                            <!-- Tombol Blokir / Pulihkan Memanggil JS -->
                                            @if(str_contains($u->name, '[DIBLOKIR]'))
                                                <button type="button" class="btn-security-action btn-security-warm-green" title="Pulihkan dan Aktifkan Kembali Hak Akses Akun" onclick="triggerRestoreModal('{{ $u->id }}', {{ json_encode($u->name) }})">
                                                    <i class="fa-solid fa-user-check"></i> Pulihkan
                                                </button>
                                            @else
                                                <button type="button" class="btn-security-action btn-security-warn-yellow" title="Tangguhkan/Blokir Hak Akses Sementara waktu" onclick="triggerBlockModal('{{ $u->id }}', {{ json_encode($u->name) }})">
                                                    <i class="fa-solid fa-user-slash"></i> Blokir
                                                </button>
                                            @endif

                                            <!-- Tombol Hapus Memanggil JS -->
                                            <button type="button" class="btn-security-action btn-security-danger-red" title="Hapus Akun Palsu Selamanya" onclick="triggerDeleteUserModal('{{ $u->id }}', {{ json_encode($u->name) }})">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 50px 0; color: #94A3B8; font-style: italic;">
                                        Belum ada data identitas pengguna (Siswa & Guru) yang terdaftar di sistem basis data sekolah.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <!-- 1. MODAL BLOKIR AKUN -->
    <div id="mewahBlockModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.7); z-index: 9999999; justify-content: center; align-items: center;" onclick="if(event.target === this) closeBlockModal()">
        <div style="background-color: #FFFFFF; border-radius: 20px; padding: 30px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
            <div style="width: 60px; height: 60px; background-color: #FEF3C7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <i class="fa-solid fa-user-slash" style="color: #D97706; font-size: 1.5rem;"></i>
            </div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #1E293B; margin-top: 0; margin-bottom: 10px;">Tangguhkan Hak Akses?</h3>
            <p id="blockModalUserName" style="font-weight: 600; color: #475569; font-style: italic; margin-bottom: 15px; word-break: break-word;"></p>
            <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 25px; line-height: 1.5;">Apakah Anda yakin ingin memblokir sementara hak akses pelaporan milik pengguna ini?</p>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeBlockModal()" style="flex: 1; padding: 12px; background-color: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; border-radius: 10px; font-weight: 700; cursor: pointer;">Batalkan</button>
                <form id="blockUserForm" action="" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; padding: 12px; background-color: #D97706; color: #FFF; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Ya, Blokir</button>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. MODAL PULIHKAN AKUN -->
    <div id="mewahRestoreModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.7); z-index: 9999999; justify-content: center; align-items: center;" onclick="if(event.target === this) closeRestoreModal()">
        <div style="background-color: #FFFFFF; border-radius: 20px; padding: 30px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
            <div style="width: 60px; height: 60px; background-color: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <i class="fa-solid fa-user-check" style="color: #059669; font-size: 1.5rem;"></i>
            </div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #1E293B; margin-top: 0; margin-bottom: 10px;">Pulihkan Hak Akses?</h3>
            <p id="restoreModalUserName" style="font-weight: 600; color: #475569; font-style: italic; margin-bottom: 15px; word-break: break-word;"></p>
            <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 25px; line-height: 1.5;">Pengguna ini akan diaktifkan kembali dan dapat membuat laporan kerusakan lagi.</p>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeRestoreModal()" style="flex: 1; padding: 12px; background-color: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; border-radius: 10px; font-weight: 700; cursor: pointer;">Batalkan</button>
                <form id="restoreUserForm" action="" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; padding: 12px; background-color: #059669; color: #FFF; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Ya, Pulihkan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- 3. MODAL HAPUS PERMANEN -->
    <div id="mewahDeleteUserModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.7); z-index: 9999999; justify-content: center; align-items: center;" onclick="if(event.target === this) closeDeleteUserModal()">
        <div style="background-color: #FFFFFF; border-radius: 20px; padding: 30px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
            <div style="width: 60px; height: 60px; background-color: #FFE4E6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <i class="fa-solid fa-trash-can" style="color: #E11D48; font-size: 1.5rem;"></i>
            </div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #1E293B; margin-top: 0; margin-bottom: 10px;">Hapus Akun Permanen?</h3>
            <p id="deleteUserModalName" style="font-weight: 600; color: #475569; font-style: italic; margin-bottom: 15px; word-break: break-word;"></p>
            <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 25px; line-height: 1.5;">Tindakan sangat kritis! Seluruh riwayat aduan kerusakan miliknya akan otomatis terhapus total dari sistem.</p>
            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeDeleteUserModal()" style="flex: 1; padding: 12px; background-color: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; border-radius: 10px; font-weight: 700; cursor: pointer;">Batalkan</button>
                <form id="deleteUserForm" action="" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; padding: 12px; background-color: #E11D48; color: #FFF; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

</body>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sidebar Navigation Script
            const hamburgerBtn = document.getElementById('mobileHamburgerBtn');
            const sidebarElement = document.querySelector('.sidebar');
            const backdropElement = document.getElementById('sidebarBackdropClose');

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
            
            window.addEventListener('resize', function() {
                if (window.innerWidth > 480 && sidebarElement && sidebarElement.classList.contains('sidebar-open')) {
                    closeAdminMobileSidebar();
                }
            });
        });

        // ===============================================
        // FUNGSI MODAL BLOKIR AKUN
        // ===============================================
        window.triggerBlockModal = function(id, name) {
            document.getElementById('blockModalUserName').textContent = `"${name}"`;
            let baseUrl = "{{ route('admin.users.toggle_status', 'PLACEHOLDER_ID') }}";
            document.getElementById('blockUserForm').action = baseUrl.replace('PLACEHOLDER_ID', id);
            document.getElementById('mewahBlockModal').style.setProperty('display', 'flex', 'important');
        };

        window.closeBlockModal = function() {
            document.getElementById('mewahBlockModal').style.setProperty('display', 'none', 'important');
        };

        // ===============================================
        // FUNGSI MODAL PULIHKAN AKUN
        // ===============================================
        window.triggerRestoreModal = function(id, name) {
            document.getElementById('restoreModalUserName').textContent = `"${name}"`;
            let baseUrl = "{{ route('admin.users.toggle_status', 'PLACEHOLDER_ID') }}";
            document.getElementById('restoreUserForm').action = baseUrl.replace('PLACEHOLDER_ID', id);
            document.getElementById('mewahRestoreModal').style.setProperty('display', 'flex', 'important');
        };

        window.closeRestoreModal = function() {
            document.getElementById('mewahRestoreModal').style.setProperty('display', 'none', 'important');
        };

        // ===============================================
        // FUNGSI MODAL HAPUS PERMANEN
        // ===============================================
        window.triggerDeleteUserModal = function(id, name) {
            document.getElementById('deleteUserModalName').textContent = `"${name}"`;
            let baseUrl = "{{ route('admin.users.destroy', 'PLACEHOLDER_ID') }}";
            document.getElementById('deleteUserForm').action = baseUrl.replace('PLACEHOLDER_ID', id);
            document.getElementById('mewahDeleteUserModal').style.setProperty('display', 'flex', 'important');
        };

        window.closeDeleteUserModal = function() {
            document.getElementById('mewahDeleteUserModal').style.setProperty('display', 'none', 'important');
        };
    </script>
</html>