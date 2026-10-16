<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userReports = Report::where('user_id', Auth::id())->latest()->get();
        $facilities = Facility::all(); // Untuk opsi pilihan lokasi fasilitas di form aduan
  
        return view('user.dashboard', compact('userReports', 'facilities'));
    }
    public function report()
{

    $totalMasuk = Report::whereIn('status', ['Pending', 'Proses'])->count();
    $totalSelesai = Report::where('status', 'Selesai')->count();

    $totalKeseluruhan = $totalMasuk + $totalSelesai;

    $persenSelesai = $totalKeseluruhan > 0 
        ? round(($totalSelesai / $totalKeseluruhan) * 100) 
        : 0;

    return view('welcome', compact('totalMasuk', 'totalSelesai', 'persenSelesai'));
}

    public function allReports(Request $request)
    {
        // 1. AMBIL DATA MASTER DROPDOWN UNTUK PANEL FILTER
        $categoriesList = \App\Models\Category::orderBy('name_category', 'asc')->get();
        
        // Tarik sub-kategori spesifik jika kategori induk sedang dipilih oleh user
        $facilitiesList = collect();
        if ($request->filled('category_id')) {
            $facilitiesList = \App\Models\Facility::where('category_id', $request->category_id)
                ->orderBy('name_facility', 'asc')
                ->get();
        } else {
            $facilitiesList = \App\Models\Facility::orderBy('name_facility', 'asc')->get();
        }

        // 2. LOGIKA FILTERISASI DATA TABEL PUBLIK (EKSPLORASI GLOBAL)
        $publicQuery = \App\Models\Report::with('facility.category');

        if ($request->filled('category_id')) {
            $publicQuery->whereHas('facility', function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }
        if ($request->filled('facility_id')) {
            $publicQuery->where('facility_id', $request->facility_id);
        }
        if ($request->filled('status_progress')) {
            $publicQuery->where('status', $request->status_progress);
        }

        $reports = $publicQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();


        // 3. LOGIKA FILTERISASI DATA TABEL PRIVASI (LAPORAN SAYA)
        if (\Illuminate\Support\Facades\Auth::check()) {
            $privateQuery = \App\Models\Report::with('facility.category')
                ->where('user_id', \Illuminate\Support\Facades\Auth::id());

            if ($request->filled('category_id')) {
                $privateQuery->whereHas('facility', function($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                });
            }
            if ($request->filled('facility_id')) {
                $privateQuery->where('facility_id', $request->facility_id);
            }
            if ($request->filled('status_progress')) {
                $privateQuery->where('status', $request->status_progress);
            }

            $myReports = $privateQuery->orderBy('created_at', 'desc')->get();
        } else {
            $myReports = collect();
        }


        // 4. STRUKTUR UTAMA: HITUNG DATA DIAGRAM BERDASARKAN BULAN BERJALAN INI
        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;

        $minggu1 = \App\Models\Report::whereMonth('date_report', $currentMonth)->whereYear('date_report', $currentYear)->whereRaw('DAY(date_report) BETWEEN 1 AND 7')->count();
        $minggu2 = \App\Models\Report::whereMonth('date_report', $currentMonth)->whereYear('date_report', $currentYear)->whereRaw('DAY(date_report) BETWEEN 8 AND 14')->count();
        $minggu3 = \App\Models\Report::whereMonth('date_report', $currentMonth)->whereYear('date_report', $currentYear)->whereRaw('DAY(date_report) BETWEEN 15 AND 21')->count();
        $minggu4 = \App\Models\Report::whereMonth('date_report', $currentMonth)->whereYear('date_report', $currentYear)->whereRaw('DAY(date_report) >= 22')->count();

        $maxAduan = max($minggu1, $minggu2, $minggu3, $minggu4, 1);

        // KETERANGAN DIAGRAM NAIK: Menarik rekap statistik total global real-time
        $totalLaporan = \App\Models\Report::count();
        $totalSelesai = \App\Models\Report::where('status', 'Selesai')->count();
        $totalMasuk = \App\Models\Report::whereIn('status', ['Pending', 'Proses'])->count();
        $persenSelesai = $totalLaporan > 0 ? round(($totalSelesai / $totalLaporan) * 100) : 0;

        $topFacilities = \App\Models\Report::select('facility_id', \Illuminate\Support\Facades\DB::raw('count(*) as total_damage'))
            ->with('facility')
            ->groupBy('facility_id')
            ->orderBy('total_damage', 'desc')
            ->take(3)
            ->get();

        return view('user.reports', compact(
            'categoriesList', 'facilitiesList', 'reports', 'myReports', 
            'minggu1', 'minggu2', 'minggu3', 'minggu4', 'maxAduan',
            'totalMasuk', 'totalSelesai', 'persenSelesai', 'topFacilities'
        ));
    }

    public function showProfile() 
    {
        // Mengamankan pemanggilan tentang kami agar ramah terhadap tamu anonim
        return view('about');
    }





    public function userProfileView()
    {
        $user = Auth::user();
        return view('user.profile', compact('user')); // Tetap di dalam folder user
    }

    public function create()
    {
        // Mengambil semua daftar fasilitas untuk pilihan dropdown di form
        $facilities = Facility::all();

        // Mengambil data kategori utama beserta sub-fasilitasnya untuk dropdown bertingkat
        $categories = Category::with('facilities')->get();
        return view('user.create-report', compact('categories'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'facility_id' => 'required|exists:facilities,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location_custom' => 'required|string|max:255', // Validasi lokasi ketikan manual
        'date_report' => 'required|date',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('reports', 'public');
    }

    \App\Models\Report::create([
        'user_id' => Auth::id(),
        'facility_id' => $request->facility_id,
        'title' => $request->title,
        'description' => $request->description,
        'location_custom' => $request->location_custom, // Memasukkan teks inputan user
        'date_report' => $request->date_report,
        'status' => 'Pending',
        'photo' => $photoPath
    ]);

    return redirect()->route('user.dashboard')->with('success', 'Laporan kerusakan berhasil dikirim!');
    }
    
    public function show($id)
    {
        $report = Report::with(['facility', 'histories.user'])
        ->where('user_id', Auth::id())
        ->findOrFail($id);
        $histories = \App\Models\History::with('user')
        ->where('report_id', $id)
        ->orderBy('date_update', 'desc')
        ->paginate(3, ['*'], 'history_page');
        
        return view('user.show-report', compact('report', 'histories'));    
    }
    
    // Menampilkan halaman profil user
    public function profile()
    {
        // Mengambil data user yang sedang login saat ini
        $user = Auth::user();
        return view('user.profile', compact('user'));
        }
        
    public function updateProfile(Request $request)
{
    $user = Auth::user();
        
    // 1. Validasi gabungan semua data inputan (termasuk file foto profil baru)
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'old_password' => 'nullable|string', // Wajib diisi jika ingin ganti password baru
        'password' => 'nullable|string|min:6|confirmed',
        'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi file gambar Anda
    ]);
            
    // 2. Update data teks dasar (Kolom 'class' dihapus dari update agar jabatannya terkunci aman)
    $user->name = $request->name;
    $user->email = $request->email;
            
    // 3. Jika user mengisi kolom password baru, periksa password lama & lakukan update
    if ($request->filled('password')) {
        // Validasi apakah password lama cocok dengan yang ada di database
        if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama yang Anda masukkan salah.'])->withInput();
        }
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
    }
    
    // 4. LOGIKA GABUNGAN: Proses simpan file foto profil baru dari Anda
    if ($request->hasFile('photo_profile')) {
        // Hapus file foto lama dari folder storage agar server tidak penuh (sesuai kode benar Anda)
        if ($user->photo && !str_contains($user->photo, 'http')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
        }

        // Simpan file foto profil yang baru ke folder public/storage/avatars
        $path = $request->file('photo_profile')->store('avatars', 'public');
        $user->photo = $path; // Amankan ke kolom photo database
    }
                
    $user->save();
                
    return redirect()->route('user.profile')->with('success', 'Profil dan foto Anda berhasil diperbarui!');
}


    // Menampilkan halaman khusus semua daftar laporan milik user yang sedang login
    public function reports()
    {
        $allPublicReports = Report::with('facility')
        ->orderBy('created_at', 'desc')
        ->take(10) // Mengambil 10 aduan publik terbaru untuk dipajang
        ->get();

    // 2. LOGIKA GRAFIK DIAGRAM CHART PRIBADI (MASUK & SELESAI)
    $totalMasuk = 0;   // Gabungan Pending + Proses
    $totalSelesai = 0; // Status Selesai
    $totalAduanSaya = 0;

    if (Auth::check()) {
        $myReports = Report::where('user_id', Auth::id())->get();
        $totalAduanSaya = $myReports->count();
        
        // Menghitung status aduan pribadi
        $totalMasuk = $myReports->whereIn('status', ['Pending', 'Proses'])->count();
        $totalSelesai = $myReports->where('status', 'Selesai')->count();
    }

    // 3. LOGIKA TOP 3 FASILITAS / SUB-KATEGORI PALING BANYAK LAPORANNYA
    // Mengelompokkan facility_id dari tabel reports, dihitung jumlahnya, diurutkan terbesar, diambil 3 teratas
    $topFacilities = Report::select('facility_id', DB::raw('count(*) as total_damage'))
        ->with('facility')
        ->groupBy('facility_id')
        ->orderBy('total_damage', 'desc')
        ->take(3)
        ->get();

        return view('user.reports', compact(
            'reports', 
            'monthsData', 
            'totalLaporan', 
            'laporanPending', 
            'laporanProses', 
            'laporanSelesai', 
            'laporanDitolak'
        ));
    }

    
}
