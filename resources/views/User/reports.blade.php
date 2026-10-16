<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Transparansi Laporan - SMK Angkasa 1</title>
    <link rel="stylesheet" href="{{ asset('css/repuser.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navus.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
</head>
<body>

    <nav class="dashboard-top-navbar">
        <a href="{{ route('welcome') }}" class="dash-nav-logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqdHriPO8AlVorouvDgAID1tZgXkgLLXdI2k5CD8KyJA&s=10" alt="Logo SMK" style="width: 40px; height: 42px; object-fit: contain;">
            <div class="dash-nav-title">
                <h2>SARPRAS DIGITAL</h2>
                <p>SMK Angkasa 1 Margahayu</p>
            </div>
        </a>

        <ul class="dash-nav-menu-links">
            <li><a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i> Tampilan</a></li>
            <li class="active-nav"><a href="{{ route('user.report.index') }}"><i class="fa-regular fa-file-lines"></i> Daftar Laporan</a></li>
            <li><a href="{{ route('user.about') }}"><i class="fa-solid fa-circle-info"></i> Tentang Aplikasi</a></li>
            <li><a href="{{ route('welcome') }}"><i class="fa-solid fa-home"></i> Kembali</a></li>
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
                <a href="/login" class="btn-about-back-home" style="background-color: #046D64; color: white; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 700;">Masuk</a>
            @endauth
        </div>
    </nav>
    <nav class="mobile-bottom-nav">
        <a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-border-all"></i><span>Tata Cara</span></a>
        <a href="{{ route('user.about') }}"><i class="fa-solid fa-circle-info"></i><span>Tentang Aplikasi</span></a>
        <a href="{{ route('welcome') }}"><i class="fa-solid fa-home"></i><span>Kembali</span></a>
    </nav>

    <!-- MAIN BODY CONTAINER -->
    <main style="padding: 40px 8%; width: 100%; box-sizing: border-box;">
        <!-- ROW UTAMA GRAFIK DIAGRAM BANNER -->
        <div class="reports-analytics-grid">
            
            <div class="bar-chart-container-card">
                <div style="text-align: left; margin-bottom: 15px;">
                    <h3 style="font-size: 1.15rem; font-weight: 800; color: #1E293B; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-chart-column" style="color: #046D64;"></i> 
                        Intensitas Kasus Masuk Per-Minggu (Bulan: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM Y') }})
                    </h3>
                </div>
                <div class="bar-chart-flex-render">
                    <div class="bar-vertical-pillar" style="height: {{ $maxAduan > 0 ? ($minggu1 / $maxAduan) * 100 : 8 }}%;"><span class="bar-floating-counter">{{ $minggu1 }}</span></div>
                    <div class="bar-vertical-pillar" style="height: {{ $maxAduan > 0 ? ($minggu2 / $maxAduan) * 100 : 8 }}%;"><span class="bar-floating-counter">{{ $minggu2 }}</span></div>
                    <div class="bar-vertical-pillar" style="height: {{ $maxAduan > 0 ? ($minggu3 / $maxAduan) * 100 : 8 }}%;"><span class="bar-floating-counter">{{ $minggu3 }}</span></div>
                    <div class="bar-vertical-pillar" style="height: {{ $maxAduan > 0 ? ($minggu4 / $maxAduan) * 100 : 8 }}%;"><span class="bar-floating-counter">{{ $minggu4 }}</span></div>
                </div>
                <div style="display: flex; justify-content: space-around; width: 100%;">
                    <div class="bar-axis-label">Minggu I</div><div class="bar-axis-label">Minggu II</div><div class="bar-axis-label">Minggu III</div><div class="bar-axis-label">Minggu IV+</div>
                </div>
            </div>

            <!-- DIAGRAM DONUT LINGKARAN -->
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

            <!-- TOP 3 FASILITAS TERBANYAK -->
            <div style="background: #FFFFFF; padding: 30px; border-radius: 20px; border: 2px solid #C3E2FF;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #1E293B; margin-bottom: 15px; text-align: left;"><i class="fa-solid fa-fire-flame-curved" style="color:#EF4444; margin-right: 6px;"></i> Rumpun Kasus Terbanyak</h3>
                @foreach($topFacilities as $index => $top)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background-color: #F8FAFC; border-radius: 8px; margin-bottom: 8px; border-left: 4px solid #046D64; font-size:0.9rem;">
                        <div><span style="font-weight:800; color:#046D64; margin-right:8px;">#{{ $index + 1 }}</span><strong>{{ $top->facility->name_facility }}</strong></div>
                        <span style="font-size: 0.8rem; font-weight: 800; color: #EF4444; background-color: #FEE2E2; padding: 3px 8px; border-radius: 6px;">{{ $top->total_damage }} Kasus</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="filter-bar-luxury-wrapper">
            <form id="ajaxLuxuryFilterForm" action="{{ route('user.report.index') }}" method="GET" class="filter-form-flex-layout" onsubmit="event.preventDefault();">
                
                <!-- Kategori Induk -->
                <div class="filter-input-group-block">
                    <label for="category_id">Kategori Bangunan</label>
                    <select name="category_id" id="category_id" class="filter-select-dropdown-custom">
                        <option value="">-- Semua Gedung/Kategori --</option>
                        @foreach($categoriesList as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name_category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sub-Kategori / Ruang (Ditambahkan data-category) -->
                <div class="filter-input-group-block">
                    <label for="facility_id">Sub-Kategori / Ruang</label>
                    <select name="facility_id" id="facility_id" class="filter-select-dropdown-custom filter-ajax-trigger">
                        <option value="">-- Semua Sub-Kategori --</option>
                        @foreach($facilitiesList as $fac)
                            <option value="{{ $fac->id }}" data-category="{{ $fac->category_id }}" {{ request('facility_id') == $fac->id ? 'selected' : '' }}>
                                {{ $fac->name_facility }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Progress -->
                <div class="filter-input-group-block">
                    <label for="status_progress">Status Progress</label>
                    <select name="status_progress" id="status_progress" class="filter-select-dropdown-custom filter-ajax-trigger">
                        <option value="">-- Semua Status --</option>
                        <option value="Pending" {{ request('status_progress') == 'Pending' ? 'selected' : '' }}>Pending (Antrean)</option>
                        <option value="Proses" {{ request('status_progress') == 'Proses' ? 'selected' : '' }}>Proses Perbaikan</option>
                        <option value="Selesai" {{ request('status_progress') == 'Selesai' ? 'selected' : '' }}>Selesai Sempurna</option>
                    </select>
                </div>

                <!-- Tombol Bersihkan -->
                <a href="{{ route('user.report.index') }}" id="btnResetFilter" class="btn-filter-reset-clear" title="Reset Semua Penyaringan Data" style="display: {{ (request()->has('category_id') || request()->has('facility_id') || request()->has('status_progress')) ? 'inline-flex' : 'none' }};">
                    <i class="fa-solid fa-filter-circle-xmark"></i> Bersihkan
                </a>

            </form>
        </div>

        <div class="wide-table-card-slider-container">

            <div class="tab-loading-overlay" id="tabLoadingOverlay">
                <div class="tab-spinner"></div>
                <span style="margin-top: 10px; font-size: 0.85rem; font-weight: 700; color: #046D64;">Memuat Data...</span>
            </div>
    
            <div class="tab-segmented-capsule-wrapper">
                <button type="button" class="btn-tab-toggle-trigger active-tab-text" id="tabPublic" onclick="switchTableSlide('public')">
                    <i class="fa-solid fa-globe"></i> Eksplorasi Publik
                </button>
                <button type="button" class="btn-tab-toggle-trigger" id="tabPrivate" onclick="switchTableSlide('private')">
                    <i class="fa-solid fa-user-lock"></i> Laporan Saya
                </button>
            </div>

            <div class="tables-horizontal-slider-track" id="tablesTrack">
                
                <div class="single-table-slide-pane" id="panePublic" style="display: block;">
                    <div class="table-responsive-scroll">
                        <table style="width: 100%; border-collapse: collapse; min-width: 650px;">
                            <thead>
                                <tr style="border-bottom: 2px solid #E2E8F0; text-align: left; font-size: 0.8rem; color: #64748B;">
                                    <th style="padding: 16px; font-weight: 700;">SUB-KATEGORI</th>
                                    <th style="padding: 16px; font-weight: 700;">JUDUL KELUHAN KERUSAKAN</th>
                                    <th style="padding: 16px; font-weight: 700; text-align: center;">STATUS PROGRESS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $pReport)
                                    <tr style="border-bottom: 1px solid #F1F5F9; font-size: 0.95rem;">
                                        <td style="padding: 16px;">
                                            <span style="font-weight: 800; color: #046D64; background-color: #E6F4F1; padding: 4px 12px; border-radius: 6px; font-size: 0.85rem;">
                                                {{ $pReport->facility->name_facility }}
                                            </span>
                                        </td>
                                        <td style="padding: 16px; font-weight: 600; color: #1E293B;">{{ $pReport->title }}</td>
                                        <td style="padding: 16px; text-align: center;">
                                            @if($pReport->status == 'Selesai') 
                                                <span style="color: #10B981; font-weight: 800; background-color: #DCFCE7; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Selesai</span>
                                            @elseif($pReport->status == 'Proses') 
                                                <span style="color: #D97706; font-weight: 800; background-color: #FEF3C7; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Proses</span>
                                            @else 
                                                <span style="color: #64748B; font-weight: 800; background-color: #F1F5F9; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Pending</span> 
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 30px 0; color: #94A3B8; font-style: italic;">Belum ada aduan masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 25px; display: flex; justify-content: center; width: 100%;">
                        <div class="pagination-wrapper-custom">{{ $reports->links() }}</div>
                    </div>
                </div>

                <div class="single-table-slide-pane" id="panePrivate" style="display: none;">
                    <div class="table-responsive-scroll">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #E2E8F0; text-align: left; font-size: 0.8rem; color: #64748B;">
                                    <th style="padding: 16px; font-weight: 700;">SUB-KATEGORI</th>
                                    <th style="padding: 16px; font-weight: 700;">JUDUL LAPORAN</th>
                                    <th style="padding: 16px; font-weight: 700; text-align: center;">STATUS PROGRESS</th>
                                    <th style="padding: 16px; font-weight: 700; text-align: right;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @auth
                                    @forelse($myReports as $mReport)
                                        <tr style="border-bottom: 1px solid #F1F5F9; font-size: 0.95rem;">
                                            <td style="padding: 16px;">
                                                <span style="font-weight: 800; color: #046D64; background-color: #E6F4F1; padding: 4px 12px; border-radius: 6px; font-size: 0.85rem;">
                                                    {{ $mReport->facility->name_facility }}
                                                </span>
                                            </td>
                                            <td style="padding: 16px; font-weight: 600; color: #1E293B;">{{ $mReport->title }}</td>
                                            <td style="padding: 16px; text-align: center;">
                                                @if($mReport->status == 'Selesai') 
                                                    <span style="color: #10B981; font-weight: 800; background-color: #DCFCE7; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Selesai</span>
                                                @elseif($mReport->status == 'Proses') 
                                                    <span style="color: #D97706; font-weight: 800; background-color: #FEF3C7; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Proses</span>
                                                @else 
                                                    <span style="color: #64748B; font-weight: 800; background-color: #F1F5F9; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem;">Pending</span> 
                                                @endif
                                            </td>
                                            <td style="padding: 16px; text-align: right;">
                                                <a href="/laporan/detail/{{ $mReport->id }}" title="Lihat Detail Log Aktivitas" style="color: #1E293B; text-decoration: none; padding: 6px 12px; background-color: #F1F5F9; border-radius: 6px;">
                                                    <i class="fa-solid fa-magnifying-glass" style="color: #64748B;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center; padding: 30px 0; color: #94A3B8; font-style: italic;">Anda belum memiliki riwayat pengaduan pribadi.</td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 35px 0; color: #64748B; font-weight: 600;">
                                            Silakan <a href="/login" style="color:#046D64; font-weight:800; text-decoration: underline;">Login</a> untuk meninjau riwayat aduan pribadi Anda.
                                        </td>
                                    </tr>
                                @endauth
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.getElementById('ajaxLuxuryFilterForm');
    const categorySelect = document.getElementById('category_id');
    const facilitySelect = document.getElementById('facility_id');
    const filterTriggers = document.querySelectorAll('.filter-ajax-trigger');
    const btnReset = document.getElementById('btnResetFilter');
    const overlay = document.getElementById('tabLoadingOverlay');
    const trackContainer = document.getElementById('tablesTrack');

    // Master penyimpanan opsi asli sub-kategori
    let masterFacilityOptions = [];

    // 1. Simpan semua opsi sub-kategori asli saat pertama kali dimuat
    if (facilitySelect) {
        masterFacilityOptions = Array.from(facilitySelect.querySelectorAll('option'));
    }

    // 2. Fungsi Sinkronisasi Sub-Kategori yang Stabil di Semua Browser
    function syncSubCategories() {
        if (!categorySelect || !facilitySelect || masterFacilityOptions.length === 0) return;

        const selectedCat = String(categorySelect.value).trim();
        const currentSelectedVal = facilitySelect.value;

        // Bersihkan seluruh opsi di dalam select sub-kategori
        facilitySelect.innerHTML = '';

        let isCurrentValid = false;

        // Saring dari master list dan masukkan kembali opsi yang cocok
        masterFacilityOptions.forEach(opt => {
            const optCategory = opt.getAttribute('data-category');

            // Opsi default ("-- Semua Sub-Kategori --") ATAU opsi yang kategori induknya cocok
            if (!opt.value || !selectedCat || String(optCategory) === selectedCat) {
                const clonedOpt = opt.cloneNode(true);
                
                // Pertahankan pilihan sebelumnya jika masih valid
                if (clonedOpt.value === currentSelectedVal && clonedOpt.value !== '') {
                    clonedOpt.selected = true;
                    isCurrentValid = true;
                }

                facilitySelect.appendChild(clonedOpt);
            }
        });

        // Reset pilihan jika sub-kategori sebelumnya tidak ada di kategori baru
        if (!isCurrentValid) {
            facilitySelect.value = '';
        }
    }

    // 3. Fungsi Utama Fetch AJAX (Filter & Pagination)
    window.fetchFilteredReports = function (targetUrl = null) {
        if (overlay) overlay.style.display = 'flex';

        let url = targetUrl ? new URL(targetUrl) : new URL(filterForm.action);
        if (!targetUrl && filterForm) {
            new FormData(filterForm).forEach((val, key) => {
                if (val.trim()) url.searchParams.set(key, val);
                else url.searchParams.delete(key);
            });
        }

        // Tampilkan/sembunyikan tombol reset
        if (btnReset) {
            const hasValue = Array.from(filterTriggers).some(s => s.value !== '');
            btnReset.style.display = hasValue ? 'inline-flex' : 'none';
        }

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newContent = doc.getElementById('tablesTrack');

                setTimeout(() => {
                    if (newContent && trackContainer) trackContainer.innerHTML = newContent.innerHTML;
                    window.history.pushState({}, '', url);
                    bindPagination();
                    if (overlay) overlay.style.display = 'none';
                }, 250);
            })
            .catch(() => { if (overlay) overlay.style.display = 'none'; });
    };

    // 4. Event Listener
    if (categorySelect) {
        categorySelect.addEventListener('change', () => {
            syncSubCategories();
            fetchFilteredReports();
        });
    }

    filterTriggers.forEach(select => {
        if (select !== categorySelect) {
            select.addEventListener('change', () => fetchFilteredReports());
        }
    });

    if (btnReset) {
        btnReset.addEventListener('click', function (e) {
            e.preventDefault();
            filterTriggers.forEach(s => s.value = '');
            syncSubCategories();
            fetchFilteredReports(this.href);
        });
    }

    function bindPagination() {
        document.querySelectorAll('.pagination-wrapper-custom a').forEach(link => {
            link.onclick = (e) => {
                e.preventDefault();
                fetchFilteredReports(link.href);
            };
        });
    }

    // Jalankan penyaringan awal saat pertama kali halaman dimuat
    syncSubCategories();
    bindPagination();
});

        // 5. Fungsi Pindah Tab Slider
        function switchTableSlide(tabType) {
            const publicPane = document.getElementById('panePublic');
            const privatePane = document.getElementById('panePrivate');
            const btnPublic = document.getElementById('tabPublic');
            const btnPrivate = document.getElementById('tabPrivate');
            const overlay = document.getElementById('tabLoadingOverlay');

            if (overlay) overlay.style.display = 'flex';

            setTimeout(() => {
                const isPublic = tabType === 'public';
                publicPane.style.display = isPublic ? 'block' : 'none';
                privatePane.style.display = isPublic ? 'none' : 'block';

                btnPublic.classList.toggle('active-tab-text', isPublic);
                btnPrivate.classList.toggle('active-tab-text', !isPublic);

                if (overlay) overlay.style.display = 'none';
            }, 200);
        }
    </script>
</body>
</html>