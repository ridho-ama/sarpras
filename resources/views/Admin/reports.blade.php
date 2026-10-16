<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengaduan - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagi.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    <style>
        .admin-filter-bar {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
            min-width: 160px;
        }
        .filter-group label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #475569;
        }
        .filter-input-custom, .filter-select-custom {
            padding: 10px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            background: #FFFFFF;
            color: #1E293B;
            width: 100%;
            box-sizing: border-box;
            transition: all 0.2s;
        }
        .filter-select-custom:focus, .filter-input-custom:focus {
            border-color: #046D64;
            box-shadow: 0 0 0 3px rgba(4, 109, 100, 0.1);
        }
        
        .btn-action-excel {
            background-color: #10B981;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            height: 42px;
            box-sizing: border-box;
            transition: background 0.2s;
        }
        .btn-action-excel:hover { background-color: #059669; }

        .btn-reset-filter {
            background-color: #F1F5F9;
            color: #64748B;
            border: 1px solid #CBD5E1;
            padding: 10px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            height: 42px;
            box-sizing: border-box;
        }
        .btn-reset-filter:hover { background-color: #E2E8F0; color: #1E293B; }

        .btn-detail-table-custom {
            background-color: #F1F5F9;
            color: #046D64;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-detail-table-custom:hover { background-color: #046D64; color: #FFFFFF; }

        #table-overlay-loading {
            display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 12px;
        }
        #search-spinner { display: none; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #046D64; }
        @media (max-width: 768px) {
            .admin-filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-group {
                min-width: 100%;
            }
            .filter-select-custom option {
                font-size: 0.85rem;
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
                <!-- Teks Info Nama Admin Pengganti Tombol Keluar Lama -->
                <div class="admin-mobile-profile-text-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <span>Admin</span>
                </div>
            @endauth
        </div>
    </div>

    <div class="admin-sidebar-overlay-backdrop" id="sidebarBackdropClose"></div>

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
            <div class="content-title">
                <h1>Daftar Berkas Pengaduan Masuk</h1>
                <p>Meninjau, memverifikasi kronologi, serta memperbarui log progress penanganan fasilitas sekolah.</p>
            </div>
        </header>

        <section class="data-card" style="background-color: #FFFFFF; border-radius: 20px; border: 2px solid #E2E8F0; padding: 30px; width: 100%;">
            
            <!-- FORM FILTER (Tanpa onchange agar tidak mereload halaman penuh) -->
            <form action="{{ route('admin.report.index') }}" method="GET" class="admin-filter-bar" id="filterFormAjax">
                
                <!-- 1. Search Box -->
                <div class="filter-group" style="flex: 2; min-width: 220px;">
                    <label for="search">Cari Laporan</label>
                    <div style="position: relative;">
                        <!-- Input search menggunakan ID khusus agar JS mudah menemukannya -->
                        <input type="text" name="search" id="ajaxSearchInput" value="{{ request('search') }}" placeholder="Judul, lokasi, atau pelapor..." class="filter-input-custom" style="padding-left: 36px;" autocomplete="off">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94A3B8;"></i>
                        <i class="fa-solid fa-spinner fa-spin" id="search-spinner"></i>
                    </div>
                </div>

                <!-- 2. Filter Kategori -->
                <div class="filter-group">
                    <label for="category_id">Kategori Fasilitas</label>
                    <select name="category_id" id="ajaxCategorySelect" class="filter-select-custom filter-trigger-ajax">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categoriesList as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name_category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 3. Filter Sub-Fasilitas -->
                <div class="filter-group">
                    <label for="facility_id">Sub-Fasilitas</label>
                    <select name="facility_id" id="ajaxFacilitySelect" class="filter-select-custom filter-trigger-ajax">
                        <option value="">-- Semua Sub-Fasilitas --</option>
                        @foreach($facilitiesList as $fac)
                            <option value="{{ $fac->id }}" data-category="{{ $fac->category_id }}" {{ request('facility_id') == $fac->id ? 'selected' : '' }}>
                                {{ $fac->name_facility }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 4. Filter Peran -->
                <div class="filter-group" style="min-width: 130px;">
                    <label for="role_type">Peran</label>
                    <select name="role_type" id="ajaxRoleSelect" class="filter-select-custom filter-trigger-ajax">
                        <option value="">-- Semua --</option>
                        <option value="siswa" {{ request('role_type') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ request('role_type') == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                </div>

                <!-- 5. Filter Bulan -->
                <div class="filter-group" style="min-width: 140px;">
                    <label for="month">Bulan</label>
                    <input type="month" name="month" id="ajaxMonthSelect" value="{{ request('month') }}" class="filter-input-custom filter-trigger-ajax">
                </div>

                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <a href="{{ route('admin.report.index') }}" class="btn-reset-filter" title="Bersihkan Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                    <!-- Tombol Export Excel tetap normal berfungsi karena submit biasa -->
                    <button type="submit" name="export" value="excel" class="btn-action-excel" title="Download Excel">
                        <i class="fa-solid fa-file-excel"></i> Export
                    </button>
                </div>
            </form>

            <div class="data-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #0F172A;"><i class="fa-solid fa-list-check" style="color:#046D64; margin-right: 6px;"></i> Seluruh Riwayat Aduan</h3>
            </div>

            <!-- CONTAINER YANG AKAN DI-RELOAD OLEH AJAX -->
            <div id="tableContainerArea" style="position: relative; min-height: 200px;">
                <!-- Efek Loading Table -->
                <div id="table-overlay-loading">
                    <i class="fa-solid fa-spinner fa-spin fa-2x" style="color:#046D64;"></i>
                </div>
                
                <div class="admin-table-responsive-wrapper">
                    <table class="admin-table" style="width: 100%; border-collapse: collapse; min-width: 800px;">
                        <thead>
                            <tr style="border-bottom: 2px solid #E2E8F0; text-align: left; font-size: 0.8rem; color: #64748B;">
                                <th style="padding: 16px; font-weight: 700;">Sub-Fasilitas</th>
                                <th style="padding: 16px; font-weight: 700;">Lokasi</th>
                                <th style="padding: 16px; font-weight: 700;">Judul Laporan</th>
                                <th style="padding: 16px; font-weight: 700;">Pelapor</th>
                                <th style="padding: 16px; font-weight: 700; text-align: center;">Status</th>
                                <th style="padding: 16px; font-weight: 700;">Tanggal</th>
                                <th style="padding: 16px; font-weight: 700; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr style="border-bottom: 1px solid #F1F5F9; font-size: 0.95rem;">
                                    <td style="padding: 16px; vertical-align: middle;">
                                        <span style="font-weight: 800; color: #046D64; background-color: #E6F4F1; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem;">
                                            {{ $report->facility->name_facility ?? '-' }}
                                        </span>
                                    </td>
                                    <td style="padding: 16px; font-weight: 700; color: #334155; vertical-align: middle;">
                                        {{ $report->location_custom ?? $report->facility->location ?? '-' }}
                                    </td>
                                    <td style="padding: 16px; vertical-align: middle; font-weight: 600; color: #1E293B;">
                                        {{ $report->title }}
                                    </td>
                                    <td style="padding: 16px; vertical-align: middle;">
                                        <strong style="color: #1E293B; display: block;">{{ $report->user->name }}</strong>
                                        <small style="color: #046D64; font-weight: 700; text-transform: uppercase;">
                                            {{ $report->pelapor_jabatan }}
                                        </small>
                                    </td>
                                    <td class="td-status" style="padding: 16px; text-align: center; vertical-align: middle;">
                                        @if($report->status == 'Proses') <span style="color: #D97706; font-weight: 800; background-color: #FEF3C7; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Proses</span> @endif
                                        @if($report->status == 'Tolak') <span style="color: #DC2626; font-weight: 800; background-color: #FEE2E2; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Tolak</span> @endif
                                        @if($report->status == 'Selesai') <span style="color: #10B981; font-weight: 800; background-color: #DCFCE7; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Selesai</span> @endif
                                        @if($report->status == 'Pending') <span style="color: #64748B; font-weight: 800; background-color: #F1F5F9; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Pending</span> @endif
                                    </td>
                                    <td style="padding: 16px; vertical-align: middle; font-weight: 600; color: #475569;">
                                        {{ \Carbon\Carbon::parse($report->date_report)->locale('id')->isoFormat('D MMM Y') }}
                                    </td>
                                    <td class="td-aksi" style="padding: 16px; vertical-align: middle; text-align: right;">
                                        <a href="{{ route('admin.show-report', $report->id) }}" class="btn-detail-table-custom">
                                            <i class="fa-solid fa-magnifying-glass" style="font-size: 0.75rem;"></i> 
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 50px 0; color: #94A3B8; font-style: italic;">
                                        Belum ada data riwayat berkas pengaduan yang sesuai dengan kriteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 25px; display: flex; justify-content: center; width: 100%;">
                    <div class="pagination-wrapper-custom" style="width: 100%;">{{ $reports->links() }}</div>
                </div>
            </div>
            <!-- AKHIR DARI CONTAINER AJAX -->
        </section>
    </main>

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

            // === 2. SCRIPT DROPDOWN DINAMIS LOKAL (Kategori -> Sub-Fasilitas) ===
            const categorySelect = document.getElementById('ajaxCategorySelect');
            const facilitySelect = document.getElementById('ajaxFacilitySelect');
            const facilityOptions = Array.from(facilitySelect.options);

            function filterFacilitiesLocal() {
                const selectedCategory = categorySelect.value;
                const currentSelectedFacility = facilitySelect.value;
                
                facilitySelect.innerHTML = '<option value="">-- Semua Sub-Fasilitas --</option>';
                let isCurrentSelectionValid = false;

                facilityOptions.forEach(option => {
                    if (option.value === "") return;
                    if (!selectedCategory || option.getAttribute('data-category') === selectedCategory) {
                        facilitySelect.appendChild(option.cloneNode(true));
                        if (option.value === currentSelectedFacility) isCurrentSelectionValid = true;
                    }
                });

                if (isCurrentSelectionValid) facilitySelect.value = currentSelectedFacility;
                else facilitySelect.value = "";
            }
            filterFacilitiesLocal(); // Panggil saat pertama kali load

            // === 3. SCRIPT AJAX UNTUK SMOOTH SEARCHING & FILTERING ===
            const searchInput = document.getElementById('ajaxSearchInput');
            const searchSpinner = document.getElementById('search-spinner');
            const tableContainer = document.getElementById('tableContainerArea');
            const tableOverlayLoading = document.getElementById('table-overlay-loading');
            
            // Ambil semua elemen select/input (Kategori, Sub, Peran, Bulan) untuk dijadikan pemicu
            const filterTriggers = document.querySelectorAll('.filter-trigger-ajax');
            let debounceTimer;

            // Fungsi Inti AJAX: Tarik data dari Controller secara diam-diam
            function fetchFilteredData() {
                // Tampilkan efek loading spinner & overlay redup
                searchSpinner.style.display = 'block';
                tableOverlayLoading.style.display = 'flex';

                // Ambil nilai dari semua form filter
                const searchVal = searchInput.value;
                const categoryVal = categorySelect.value;
                const facilityVal = facilitySelect.value;
                const roleVal = document.getElementById('ajaxRoleSelect').value;
                const monthVal = document.getElementById('ajaxMonthSelect').value;

                // Bangun URL Query (seperti admin/reports?search=kayu&category_id=1...)
                let url = new URL('{{ route('admin.report.index') }}', window.location.origin);
                if(searchVal) url.searchParams.append('search', searchVal);
                if(categoryVal) url.searchParams.append('category_id', categoryVal);
                if(facilityVal) url.searchParams.append('facility_id', facilityVal);
                if(roleVal) url.searchParams.append('role_type', roleVal);
                if(monthVal) url.searchParams.append('month', monthVal);

                // Tarik halaman web tersebut di belakang layar
                fetch(url)
                .then(response => response.text())
                .then(htmlString => {
                    // Ekstrak HANYA bagian tabel dari halaman HTML utuh yang diterima
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(htmlString, 'text/html');
                    const newTableContent = doc.getElementById('tableContainerArea').innerHTML;
                    
                    // Timpa tabel lama dengan tabel baru yang sudah difilter
                    tableContainer.innerHTML = newTableContent;

                    // Update URL di browser agar jika di-refresh halamannya, filternya tidak hilang
                    window.history.pushState({}, '', url);

                    // Matikan efek loading
                    searchSpinner.style.display = 'none';
                    tableOverlayLoading.style.display = 'none';

                    // Pasang kembali event listener pada link paginasi yang baru (agar tidak me-reload halaman)
                    attachAjaxPagination();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    searchSpinner.style.display = 'none';
                    tableOverlayLoading.style.display = 'none';
                });
            }

            // A. Trigger AJAX: Saat Mengetik di Kolom Pencarian (Kursor tidak akan hilang)
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer); // Tunda sesaat jika user mengetik cepat
                    searchSpinner.style.display = 'block';
                    debounceTimer = setTimeout(fetchFilteredData, 500); // Eksekusi setelah berhenti mengetik 0.5 dtk
                });
            }

            // B. Trigger AJAX: Saat Dropdown (Kategori, Peran, Bulan) diubah
            filterTriggers.forEach(trigger => {
                trigger.addEventListener('change', function() {
                    // Jika yang diubah adalah Kategori Induk, atur ulang dulu opsi Sub-Fasilitas lokalnya
                    if (this.id === 'ajaxCategorySelect') {
                        facilitySelect.value = "";
                        filterFacilitiesLocal();
                    }
                    fetchFilteredData(); // Langsung eksekusi pencarian AJAX
                });
            });

            // C. Pasang AJAX juga untuk tombol Paginasi Halaman (Halaman 1, 2, Next, dst)
            function attachAjaxPagination() {
                const paginationLinks = document.querySelectorAll('.pagination-wrapper-custom a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault(); // Cegah klik normal (reload halaman penuh)
                        let pageUrl = this.getAttribute('href');
                        
                        tableOverlayLoading.style.display = 'flex';
                        fetch(pageUrl)
                        .then(response => response.text())
                        .then(htmlString => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(htmlString, 'text/html');
                            tableContainer.innerHTML = doc.getElementById('tableContainerArea').innerHTML;
                            window.history.pushState({}, '', pageUrl);
                            tableOverlayLoading.style.display = 'none';
                            attachAjaxPagination(); // Rekursif pasang event kembali ke tombol baru
                        });
                    });
                });
            }
            // Pasang event ke paginasi saat web pertama kali di-load
            attachAjaxPagination();
        });
    </script>
</body>
</html>