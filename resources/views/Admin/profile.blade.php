<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - Sarpras</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/3e6f4431bd.js" crossorigin="anonymous"></script>
    <style>
        /* DESIGN PREMIUM FLOATING CONTAINER - LEBAR 1000PX */
        .profile-container-centered {
            max-width: 1000px;
            margin: 40px auto;
            background: #FFFFFF;
            border-radius: 24px;
            border: 2px solid #C3E2FF;
            padding: 45px;
            box-shadow: 0 12px 30px -5px rgba(4, 109, 100, 0.05);
            width: 100%;
            box-sizing: border-box;
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
        
        /* OVERLAY KAMERA AVATAR MENYATU (TERKUNCI PATEN SEBELUM EDIT MODE) */
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
            background: rgba(15, 23, 42, 0.65);
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
        /* Menyala jingga-hijau saat JS mengaktifkan mode edit */
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
            color: #046D64;
            font-weight: 700;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .profile-card-form-box {
            background-color: #F8FAFC;
            border-radius: 24px;
            border: 1px solid #E2E8F0;
            padding: 40px 60px;
            width: 100%;
            box-sizing: border-box;
        }
        .profile-form-row {
            display: flex;
            flex-direction: column; /* Baris lurus tegak vertikal ke bawah */
            gap: 6px;
            margin-bottom: 22px;
            width: 100%;
            text-align: left;
        }
        .profile-form-row label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .profile-input-wrapper {
            width: 100%;
            position: relative;
        }
        .profile-input-field-custom {
            width: 100%;
            padding: 12px 16px;
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1E293B;
            font-weight: 600;
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
            border-color: #046D64;
            box-shadow: 0 0 0 3px rgba(4, 109, 100, 0.1);
        }

        /* Tombol Eye Intip Sandi */
        .password-toggle-eye-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            font-size: 1.05rem;
            display: none;
        }
        .password-toggle-eye-btn:hover { color: #046D64; }

        /* GRUP TOMBOL KONTROL PROFILE */
        .profile-action-group-center {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
            width: 100%;
        }
        .btn-action-profile {
            padding: 12px 35px;
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
        .btn-cancel-mode { background-color: #64748B; color: white; }
        .btn-cancel-mode:hover { background-color: #475569; }
        .btn-save-mode { background: linear-gradient(135deg, #046D64, #00A896); color: white; }
        .btn-save-mode:hover { transform: translateY(-1px); }
        
        .btn-logout-luxury {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white; border: none; padding: 12px 28px; border-radius: 8px;
            font-size: 0.95rem; font-weight: 700; cursor: pointer;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2); display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-logout-luxury:hover { transform: translateY(-1px); box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3); }
    </style>
</head>
<body style="display: block; background-color: #FFFFFF; min-height: 100vh;">

    <div class="profile-container-centered">
        
        <div class="profile-top-banner">
            <a href="{{ route('admin.dashboard') }}" class="btn-profile-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="profile-avatar-wrapper" id="avatarContainer">
            @if(Auth::user()->photo && file_exists(public_path('storage/' . Auth::user()->photo)))
                <!-- Jika ada, tampilkan foto asli milik user/admin tersebut -->
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                    alt="Foto Profil {{ Auth::user()->name }}" 
                    style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
            @else
                <!-- Cadangan (Fallback) Gambar Default Berdasarkan Peran jika belum upload foto -->
                <img src="{{ Auth::user()->role === 'admin' ? 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' : 'https://images.unsplash.com/vector-1742875355318-00d715aec3e8?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHByb2ZpbGUlMjBpY29ufGVufDB8fDB8fHww' }}" 
                    alt="Avatar Default" 
                    style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 2px solid #046D64; flex-shrink: 0;">
            @endif               
            
            <label for="photo_profile" class="avatar-edit-overlay">
                <i class="fa-solid fa-camera fa-lg"></i>
                <span>GANTI FOTO</span>
            </label>
        </div>

        <div class="profile-text-header">
            <h2>{{ $admin->name }}</h2>
            <p><i class="fa-solid fa-user-shield me-1"></i> Staff Sarpras Admin</p>
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

            <!-- Form disinkronkan mengarah ke rute gabungan updateProfile Anda -->
            <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="file" id="photo_profile" name="photo_profile" accept="image/*" style="display: none;" disabled onchange="previewAvatarImage(this)">

                <!-- INPUT NAMA (Penting agar tidak error di JavaScript) -->
                <div class="profile-form-row">
                    <label for="name">Nama Lengkap</label>
                    <div class="profile-input-wrapper">
                        <input type="text" class="profile-input-field-custom editable-field" id="name" name="name" value="{{ old('name', $admin->name) }}" required disabled>
                    </div>
                </div>

                <div class="profile-form-row">
                    <label>NIP/NISN</label>
                    <div class="profile-input-wrapper">
                        <input type="text" class="profile-input-field-custom" style="background-color: #CBD5E1 !important; color: #64748B !important; cursor: not-allowed; border-color: #CBD5E1;" value="{{ $admin->nisn_or_nip }}" readonly disabled>
                    </div>
                </div>

                <!-- Baris 4: Email Admin -->
                <div class="profile-form-row">
                    <label for="email">Email</label>
                    <div class="profile-input-wrapper">
                        <input type="email" class="profile-input-field-custom editable-field" id="email" name="email" value="{{ old('email', $admin->email) }}" required disabled>
                    </div>
                </div>

                <!-- Baris 5: Password Lama dengan Keterangan Bantuan -->
                <div class="profile-form-row" id="oldPasswordRow" style="display: none;">
                    <label for="old_password">Password Lama</label>
                    <div class="profile-input-wrapper">
                        <input type="password" class="profile-input-field-custom editable-field" id="old_password" name="old_password" placeholder="Masukkan password lama Anda saat ini">
                        <button type="button" class="password-toggle-eye-btn" onclick="togglePasswordVisibility('old_password', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <small style="color: #64748B; font-size: 0.75rem; margin-top: 4px; display: block;">
                        *Diperlukan untuk verifikasi keamanan. Jika Anda lupa password lama, silakan hubungi pengembang sistem untuk melakukan reset database.
                    </small>
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
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="profile-input-wrapper">
                        <input type="password" class="profile-input-field-custom editable-field" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" disabled>
                        <button type="button" class="password-toggle-eye-btn" onclick="togglePasswordVisibility('password_confirmation', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- CONTAINER TOMBOL AKSI DINAMIS SISI ADMIN -->
                <div class="profile-action-group-center">
                    <button type="button" id="btnEdit" class="btn-action-profile btn-edit-mode" onclick="enableEditMode()">
                        <i class="fa-solid fa-user-pen"></i> Edit Profil
                    </button>
                    
                    <button type="button" id="btnLogout" class="btn-action-profile btn-logout-luxury" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();" title="Keluar dari Aplikasi">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>

                    <button type="button" id="btnCancel" class="btn-action-profile btn-cancel-mode" style="display: none;" onclick="disableEditMode()">Batal</button>
                    
                    <!-- PERHATIAN: Tombol simpan bertipe submit agar data terkirim ke Controller -->
                    <button type="submit" id="btnSave" class="btn-action-profile btn-save-mode" style="display: none;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>

            </form>
        </section>

        <!-- Form Logout Tersembunyi -->
        <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div> <!-- Penutup .profile-container-centered -->

    <!-- JAVASCRIPT LOGIKA SENSOR INPUT & INTIP MATA UNTUK ADMIN -->
    <script>
        const initialValues = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            avatarSrc: document.querySelector('.profile-avatar-wrapper img').src
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

        function enableEditMode() {
            editableFields.forEach(field => {
                field.removeAttribute('disabled');
            });
            fileInput.removeAttribute('disabled');
            avatarContainer.classList.add('active');

            eyeButtons.forEach(btn => {
                btn.style.display = 'block';
            });

            btnEdit.style.display = 'none';
            btnLogout.style.display = 'none';
            btnCancel.style.display = 'block';
            btnSave.style.display = 'block';
        }

        function disableEditMode() {
            editableFields.forEach(field => {
                field.setAttribute('disabled', 'true');
            });
            fileInput.setAttribute('disabled', 'true');
            fileInput.value = ""; 
            avatarContainer.classList.remove('active');

            eyeButtons.forEach(btn => {
                btn.style.display = 'none';
                btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
            });

            document.getElementById('name').value = initialValues.name;
            document.getElementById('email').value = initialValues.email;
            document.querySelector('.profile-avatar-wrapper img').src = initialValues.avatarSrc;
            
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

            btnEdit.style.display = 'block';
            btnLogout.style.display = 'block';
            btnCancel.style.display = 'none';
            btnSave.style.display = 'none';
        }

        passwordInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                oldPasswordRow.style.display = 'flex';
                oldPasswordInput.setAttribute('required', 'true');
                oldPasswordInput.removeAttribute('disabled');
                confirmRow.style.display = 'flex';
                confirmInput.setAttribute('required', 'true');
                confirmInput.removeAttribute('disabled');
            } else {
                oldPasswordRow.style.display = 'none';
                oldPasswordInput.removeAttribute('required');
                oldPasswordInput.value = '';
                confirmRow.style.display = 'none';
                confirmInput.removeAttribute('required');
                confirmInput.value = '';
            }
        });

        function previewAvatarImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-avatar-wrapper img').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                document.querySelector('.profile-avatar-wrapper img').src = initialValues.avatarSrc;
            }
        }

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
    </script>
</body>
</html>