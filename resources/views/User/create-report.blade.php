<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Baru - Sarpras</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>

    <style>

        /* --- CENTERED FORM REPORT SPECIFIC STYLES --- */
        .form-container-centered {
            max-width: 850px;
            margin: 40px auto;
            padding: 0 20px;
            box-sizing: border-box;
            width: 100%;
        }

        /* Tombol Kembali ke Dashboard di Kiri Atas */
        .btn-form-back {
            color: #1E293B;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            transition: color 0.2s;
        }

        .btn-form-back:hover {
            color: #046D64;
        }

        /* Kartu Utama Putih Formulir */
        .form-card-box-centered {
            background-color: #FFFFFF;
            border-radius: 24px;
            padding: 45px 60px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            width: 100%;
            box-sizing: border-box;
        }

        .form-card-box-centered h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }

        /* Layout Grup Inputan */
        .form-group-block {
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .form-group-block label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #64748B;
        }

        /* Desain Kolom Input Polos Lembut */
        .input-field-soft {
            width: 100%;
            padding: 12px 16px;
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1E293B;
            outline: none;
            box-sizing: border-box;
            transition: all 0.2s;
        }

        .input-field-soft::placeholder {
            color: #94A3B8;
        }

        .input-field-soft:focus {
            background-color: #FFFFFF;
            border-color: #046D64;
            box-shadow: 0 0 0 3px rgba(4, 109, 100, 0.1);
        }

        /* Input File Bukti Custom Berwarna Hijau */
        .file-upload-wrapper {
            display: flex;
            align-items: center;
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            overflow: hidden;
            width: 100%;
        }

        .btn-file-choice {
            background-color: #046D64;
            color: #FFFFFF;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-file-choice:hover {
            background-color: #03524B;
        }

        /* Tombol Utama Kirim Laporan Hijau Lebar */
        .btn-submit-report-wide {
            width: 100%;
            background-color: #046D64;
            color: #FFFFFF;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 15px;
            box-shadow: 0 4px 12px rgba(4, 109, 100, 0.2);
        }

        .btn-submit-report-wide:hover {
            background-color: #03524B;
        }
    </style>
    <script>
        if (localStorage.getItem('dark-mode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-active');
        }
    </script>
</head>
<!-- Menggunakan warna background biru muda senada kustom permintaan Anda -->
<body style="display: block; background-color: #C3E2FF; min-height: 100vh;">

    <div class="form-container-centered">
        
        <!-- Tombol Kembali Ke Dashboard -->
        <a href="{{ route('welcome') }}" class="btn-form-back">
            <i class="fa-solid fa-arrow-left-long"></i> Kembali
        </a>

        <!-- KARTU FORMULIR UTAMA -->
        <section class="form-card-box-centered">
            <h2>Buat Laporan baru</h2>

            <!-- Validasi Pesan Eror -->
            @if ($errors->any())
                <div style="background-color: #FEE2E2; color: #991B1B; padding: 12px 16px; border-radius: 8px; margin-bottom: 25px; font-size: 0.9rem;">
                    <ul style="padding-left: 20px; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- KODE BARU UNTUK BLOK ISIAN FORM AKUN USER (GANTI FORM LAMA ANDA) -->
            <form action="{{ route('user.report.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 1. Dropdown Kategori Utama -->
                <div class="form-group-block">
                    <label for="category_id">Pilih Kategori Fasilitas</label>
                    <select class="input-field-soft" id="category_id" style="cursor: pointer;" required onchange="filterSubKategori(this.value)">
                        <option value="" selected disabled>-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name_category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Dropdown Sub-Kategori (Otomatis Ter-filter lewat JS di bawah) -->
                <div class="form-group-block">
                    <label for="facility_id">Sub-Kategori / Ruangan bermasalah</label>
                    <select class="input-field-soft" id="facility_id" name="facility_id" style="cursor: pointer;" required disabled>
                        <option value="" selected disabled>-- Pilih Ruangan / Jenis Barang --</option>
                    </select>
                </div>

                <!-- 3. INPUT MANUAl: Ketik Lokasi Sendiri Sesuai Aturan Baru -->
                <div class="form-group-block">
                    <label for="location_custom">Lokasi Spesifik Ruangan <span style="color:#046D64; font-weight:bold;"></span></label>
                    <input type="text" class="input-field-soft" id="location" name="location_custom" placeholder="Contoh: Gerbang Utama" required>
                </div>

                <!-- Judul, Deskripsi, Foto, & Tanggal (Tetap Sama dengan Kemarin) -->
                <div class="form-group-block">
                    <label for="title">Judul Laporan</label>
                    <input type="text" class="input-field-soft" id="title" name="title" placeholder="Tuliskan kerusakan..." required>
                </div>
                <div class="form-group-block">
                    <label for="description">Isi/Deskripsi Laporan</label>
                    <textarea class="input-field-soft" id="description" name="description" rows="5" placeholder="Kronologi kerusakan..." required></textarea>
                </div>
                <div class="form-group-block">
                    <label for="date_report">Tanggal Pengaduan <span style="color: #64748B; font-weight: normal;">(Otomatis Hari Ini)</span></label>
                    <input type="date" class="input-field-soft" id="date_report" name="date_report" 
                        value="{{ now()->toDateString() }}" 
                        min="{{ now()->toDateString() }}" 
                        max="{{ now()->toDateString() }}" 
                        readonly style="background-color: #E2E8F0; color: #475569; cursor: not-allowed; font-weight: 700;">
                </div>
                <div class="form-group-block" style="margin-bottom: 35px;">
                    <label for="photo">Foto Bukti (Opsional)</label>
                    <input type="file" class="input-field-soft" name="photo" accept="image/*">
                </div>

                <button type="submit" class="btn-submit-report-wide">Kirim Laporan</button>
            </form>
        </section>
    </div>

<!-- JAVASCRIPT KONTROL DROPDOWN -->
    <script>
        // Membaca data relasi fasilitas dari database Laravel ke dalam array JavaScript
        const categoryData = {
            @foreach($categories as $cat)
                "{{ $cat->id }}": [
                    @foreach($cat->facilities as $fac)
                        { id: "{{ $fac->id }}", name: "{{ $fac->name_facility }}" },
                    @endforeach
                ],
            @endforeach
        };
    
        function filterSubKategori(categoryId) {
            const subSelect = document.getElementById('facility_id');
            subSelect.innerHTML = '<option value="" selected disabled>-- Pilih Ruangan / Jenis Barang --</option>';
            
            if(categoryData[categoryId] && categoryData[categoryId].length > 0) {
                subSelect.removeAttribute('disabled');
                categoryData[categoryId].forEach(function(item) {
                    let opt = document.createElement('option');
                    opt.value = item.id;
                    opt.innerText = item.name;
                    subSelect.appendChild(opt);
                });
            } else {
                subSelect.setAttribute('disabled', 'true');
            }
        }
    </script>
</body>
</html>