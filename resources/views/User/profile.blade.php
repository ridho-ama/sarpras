<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Sarpras</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    <style>
        /* REVISI: Kontainer diperlebar menjadi 1000px agar sangat luas dan lega */
        .profile-container-centered {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            box-sizing: border-box;
            width: 100%;
        }
        .profile-top-banner {
            background-color: #C3E2FF;
            border-radius: 20px;
            height: 160px;
            position: relative;
            width: 100%;
            display: flex;
            align-items: flex-start;
            padding: 20px;
            box-sizing: border-box;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .btn-profile-back {
            background-color: #046D64;
            color: #FFFFFF;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* REVISI FOTO PROFIL: Overlay Kamera menyatu di dalam Avatar */
        .profile-avatar-wrapper {
            width: 150px;
            height: 150px;
            margin: -75px auto 20px auto;
            position: relative;
            z-index: 10;
        }
        .profile-avatar-large {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid #FFFFFF;
            background-color: #CBD5E1;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .avatar-edit-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.6);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
            border: 6px solid transparent;
            box-sizing: border-box;
        }
        /* Menyala hanya saat masuk mode edit (Class .active diinduksi oleh JS) */
        .profile-avatar-wrapper.active .avatar-edit-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .profile-text-header {
            text-align: center;
            margin-bottom: 35px;
        }
        .profile-text-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #1E293B;
        }
        .profile-text-header p {
            font-size: 1.1rem;
            color: #00A896;
            font-weight: 700;
            margin-top: 5px;
        }
        .profile-card-form-box {
            background-color: #F8FAFC;
            border-radius: 24px;
            border: 2px solid #C3E2FF;
            padding: 40px 60px;
            width: 100%;
            box-sizing: border-box;
        }
        .profile-form-row {
            display: flex;
            align-items: center;
            margin-bottom: 22px;
            width: 100%;
        }
        .profile-form-row label {
            width: 30%;
            font-size: 0.95rem;
            font-weight: 600;
            color: #475569;
        }
        .profile-input-wrapper {
            width: 70%;
            position: relative;
        }
        .profile-input-field-custom {
            width: 100%;
            padding: 11px 16px;
            background-color: #C3E2FF;
            border: 1px solid #94A3B8;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1E293B;
            font-weight: 700;
            outline: none;
            box-sizing: border-box;
            transition: all 0.2s;
        }
        .profile-input-field-custom:disabled {
            background-color: #E2E8F0 !important;
            color: #64748B !important;
            cursor: not-allowed;
            border-color: #CBD5E1;
        }
        .profile-input-field-custom:focus {
            background-color: #FFFFFF;
            border-color: #046D64;
        }

        /* REVISI: Tombol Eye intip sandi */
        .password-toggle-eye-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            font-size: 1rem;
            display: none;
        }
        .password-toggle-eye-btn:hover { color: #046D64; }

        .profile-action-group-center {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
            width: 100%;
        }
        .btn-action-profile {
            padding: 11px 35px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-edit-mode { background-color: #046D64; color: white; }
        .btn-edit-mode:hover { background-color: #03524B; }
        .btn-save-mode { background-color: #10B981; color: white; }
        .btn-cancel-mode { background-color: #EF4444; color: white; }
        
        .btn-logout-luxury {
            background-color: #DC2626;
            color: white;
        }
        .btn-logout-luxury:hover { background-color: #991B1B; }
    </style>
</head>
<body style="display: block; background-color: #FFFFFF; min-height: 100vh;">

    <div class="profile-container-centered">
        
        <div class="profile-top-banner">
            <a href="{{ route('welcome') }}" class="btn-profile-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- REVISI FOTO: Menyatu di dalam lingkaran avatar -->
        <div class="profile-avatar-wrapper" id="avatarContainer">
            @if($user->photo && file_exists(public_path('storage/' . $user->photo)))
                <img id="avatarPreview" src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="profile-avatar-large">
            @else
                <img id="avatarPreview" src="{{ $user->role === 'admin' ? 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' : 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' }}" alt="Avatar Default" class="profile-avatar-large">
            @endif 
            
            <!-- Label pemicu klik input file kustom -->
            <label for="photo_profile" class="avatar-edit-overlay">
                <i class="fa-solid fa-camera fa-lg"></i>
                <span>GANTI FOTO</span>
            </label>
        </div>

        <div class="profile-text-header">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->role === 'admin' ? 'Staff Sarpras Admin' : $user->class }}</p>
        </div>

        <section class="profile-card-form-box">
            @if(session('success'))
                <div style="background-color: #D1E7DD; color: #0F5132; padding: 12px 16px; border-radius: 8px; margin-bottom: 25px; font-size: 0.9rem; font-weight: 600; text-align: center;">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background-color: #FEE2E2; color: #991B1B; padding: 12px 16px; border-radius: 8px; margin-bottom: 25px; font-size: 0.9rem;">
                    <ul style="padding-left: 20px; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- REVISI FORM: Satukan action rute edit & ganti foto -->
            <form id="profileForm" action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Input file gambar rahasia -->
                <input type="file" id="photo_profile" name="photo_profile" accept="image/*" style="display: none;" disabled onchange="previewAvatarImage(this)">

                <div class="profile-form-row">
                    <label>NIP/NISN</label>
                    <div class="profile-input-wrapper">
                        <input type="text" class="profile-input-field-custom" style="background-color: #CBD5E1 !important; color: #64748B !important; cursor: not-allowed; border-color: #CBD5E1;" value="{{ $user->nisn_or_nip }}" readonly disabled>
                    </div>
                </div>

                <div class="profile-form-row">
                    <label for="name">Nama</label>
                    <div class="profile-input-wrapper">
                        <input type="text" class="profile-input-field-custom editable-field" id="name" name="name" value="{{ old('name', $user->name) }}" required disabled>
                    </div>
                </div>

                <div class="profile-form-row">
                    <label for="class">Class</label>
                    <div class="profile-input-wrapper">
                        <input type="text" class="profile-input-field-custom editable-field" id="class" name="class" value="{{ old('class', $user->class) }}" required disabled>
                   </div>
                </div>

                 <!-- Baris 4: Email -->
                <div class="profile-form-row">
                    <label for="email">Email</label>
                    <div class="profile-input-wrapper">
                        <input type="email" class="profile-input-field-custom editable-field" id="email" name="email" value="{{ old('email', $user->email) }}" required disabled>
                    </div>
                </div>

                <!-- Baris 5: Password Lama (Muncul otomatis saat ingin ganti password) -->
                <div class="profile-form-row" id="oldPasswordRow" style="display: none;">
                    <label for="old_password">Password Lama</label>
                    <div class="profile-input-wrapper">
                        <input type="password" class="profile-input-field-custom editable-field" id="old_password" name="old_password" placeholder="Masukkan password lama untuk konfirmasi">
                        <button type="button" class="password-toggle-eye-btn" onclick="togglePasswordVisibility('old_password', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Baris 6: Password Baru -->
                <div class="profile-form-row">
                    <label for="password">Password Baru</label>
                    <div class="profile-input-wrapper">
                        <input type="password" class="profile-input-field-custom editable-field" id="password" name="password" placeholder="Isi hanya jika ingin mengganti password" disabled>
                        <button type="button" class="password-toggle-eye-btn" onclick="togglePasswordVisibility('password', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Baris 7: Konfirmasi Password Baru -->
                <div class="profile-form-row" id="confirmRow" style="display: none;">
                    <label for="password_confirmation">Konfirmasi</label>
                    <div class="profile-input-wrapper">
                        <input type="password" class="profile-input-field-custom editable-field" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                        <button type="button" class="password-toggle-eye-btn" onclick="togglePasswordVisibility('password_confirmation', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- CONTAINER TOMBOL AKSI DINAMIS -->
                <div class="profile-action-group-center">
                    <button type="button" id="btnEdit" class="btn-action-profile btn-edit-mode" onclick="enableEditMode()">
                        <i class="fa-solid fa-user-pen"></i> Edit Profil
                    </button>
                    
                    <button type="button" id="btnLogout" class="btn-action-profile btn-cancel-mode" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();" title="Keluar dari Aplikasi">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>

                    <button type="button" id="btnCancel" class="btn-action-profile btn-cancel-mode" style="display: none;" onclick="disableEditMode()">Batal</button>
                    <button type="submit" id="btnSave" class="btn-action-profile btn-save-mode" style="display: none;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>

            </form>
        </section>

        <!-- Form Logout Tersembunyi -->
        <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="none">
            @csrf
        </form>

    </div> <!-- Penutup .profile-container-centered -->

    <!-- JAVASCRIPT LOGIKA SENSOR INPUT & INTIP MATA -->
    <script>
        // Nilai cadangan awal untuk memulihkan data jika user menekan tombol 'Batal'
        const initialValues = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            avatarSrc: document.getElementById('avatarPreview').src
        };

        const editableFields = document.querySelectorAll('.editable-field');
        const passwordInput = document.getElementById('password');
        const oldPasswordRow = document.getElementById('oldPasswordRow');
        const oldPasswordInput = document.getElementById('old_password');
        const confirmRow = document.getElementById('confirmRow');
        const confirmInput = document.getElementById('password_confirmation');
        
        const fileInput = document.getElementById('photo_profile');
        const avatarContainer = document.getElementById('avatarContainer');

        const btnEdit = document.getElementById('btnEdit');
        const btnLogout = document.getElementById('btnLogout');
        const btnCancel = document.getElementById('btnCancel');
        const btnSave = document.getElementById('btnSave');
        const eyeButtons = document.querySelectorAll('.password-toggle-eye-btn');

        // Fungsi 1: Mengaktifkan Mode Edit & Membuka Akses Overlay Kamera Avatar
        function enableEditMode() {
            editableFields.forEach(field => {
                field.removeAttribute('disabled');
            });
            fileInput.removeAttribute('disabled');

            // Memunculkan efek hover kamera ganti foto di dalam lingkaran avatar
            avatarContainer.classList.add('active');

            // Menampilkan seluruh ikon mata pembuka sensor sandi
            eyeButtons.forEach(btn => {
                btn.style.display = 'block';
            });

            // Menukar visibilitas tombol kendali utama
            btnEdit.style.display = 'none';
            btnLogout.style.display = 'none';
            btnCancel.style.display = 'block';
            btnSave.style.display = 'block';
        }

        // Fungsi 2: Membatalkan Mode Edit & Membersihkan Cache File Input (SOLUSI BUG KUNCI)
        function disableEditMode() {
            editableFields.forEach(field => {
                field.setAttribute('disabled', 'true');
            });
            fileInput.setAttribute('disabled', 'true');
            
            // FIX MUTLAK: Mengosongkan nilai input file agar browser mengizinkan upload ulang berkali-kali
            fileInput.value = ""; 

            // Menyembunyikan kembali efek hover kamera avatar ke status default
            avatarContainer.classList.remove('active');

            // Menyembunyikan seluruh ikon mata dan mengembalikan bentuknya
            eyeButtons.forEach(btn => {
                btn.style.display = 'none';
                btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
            });

            // Memulihkan seluruh isi tulisan form ke status asli sebelum diubah user
            document.getElementById('name').value = initialValues.name;
            document.getElementById('email').value = initialValues.email;
            document.getElementById('avatarPreview').src = initialValues.avatarSrc;
            
            passwordInput.value = '';
            passwordInput.type = 'password';
            
            oldPasswordInput.value = '';
            oldPasswordInput.type = 'password';
            oldPasswordInput.removeAttribute('required');
            oldPasswordRow.style.display = 'none';
            
            confirmInput.value = '';
            confirmInput.type = 'password';
            confirmInput.removeAttribute('required');
            confirmRow.style.display = 'none';

            // Mengembalikan susunan visibilitas tombol utama
            btnEdit.style.display = 'block';
            btnLogout.style.display = 'block';
            btnCancel.style.display = 'none';
            btnSave.style.display = 'none';
        }

        // Fungsi 3: Memantau Ketikan Sandi Baru untuk Memunculkan Baris Konfirmasi & Sandi Lama
        passwordInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                oldPasswordRow.style.display = 'flex';
                oldPasswordInput.setAttribute('required', 'true');
                
                confirmRow.style.display = 'flex';
                confirmInput.setAttribute('required', 'true');
            } else {
                oldPasswordRow.style.display = 'none';
                oldPasswordInput.removeAttribute('required');
                oldPasswordInput.value = '';
                
                confirmRow.style.display = 'none';
                confirmInput.removeAttribute('required');
                confirmInput.value = '';
            }
        });

        // Fungsi 4: Real-time Live Preview Penayang Gambar Berulang Kali Tanpa Batas
        function previewAvatarImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                // Jika user membatalkan pemilihan di tengah jalan, kembalikan ke foto awal
                document.getElementById('avatarPreview').src = initialValues.avatarSrc;
            }
        }

        // Fungsi 5: Logika Utama Show / Hide Teks Sandi Klik Ikon Mata
        function togglePasswordVisibility(fieldId, btnElement) {
            const inputField = document.getElementById(fieldId);
            if (inputField.type === 'password') {
                inputField.type = 'text';
                btnElement.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            } else {
                inputField.type = 'password';
                btnElement.innerHTML = '<i class="fa-solid fa-eye"></i>';
            }
        }

        // Pengecekan status dark mode lokal browser
        if (localStorage.getItem('dark-mode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-active');
        }
    </script>
</body>
</html>