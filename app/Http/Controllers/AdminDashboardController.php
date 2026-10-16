<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Carbon\Carbon;
use App\Models\Report;
use App\Models\History;
use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AdminDashboardController extends Controller
{
    public function dashboard(Request $request)
{
    $reports = Report::with(['user', 'facility'])->orderBy('created_at', 'desc')->get();

        $totalLaporan = $reports->count();
        $laporanPending = $reports->where('status', 'Pending')->count();
        $laporanProses  = $reports->where('status', 'Proses')->count();
        $laporanSelesai = $reports->where('status', 'Selesai')->count();
        $laporanDitolak = $reports->where('status', 'Tolak')->count();

        $latestReports = $reports->take(3);
        
    $selectedYear = $request->get('year', date('Y'));
    $selectedRange = $request->get('range', 'all');

    $availableYears = \App\Models\Report::selectRaw('YEAR(date_report) as year')
                        ->distinct()
                        ->orderBy('year', 'desc')
                        ->pluck('year');
    
    if($availableYears->isEmpty()) {
        $availableYears = collect([date('Y')]);
    }

    $allMonthsLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $chartData = [];

    if ($selectedRange === 'last_3_months') {
        $currentMonth = (int)date('n');
        $currentYear = (int)date('Y');
        
        $endMonth = ($selectedYear == $currentYear) ? $currentMonth : 12;
        $startMonth = max(1, $endMonth - 2);

        for ($m = $startMonth; $m <= $endMonth; $m++) {
            $count = \App\Models\Report::whereYear('date_report', $selectedYear)
                        ->whereMonth('date_report', $m)->count();
            $chartData[] = ['val' => $count, 'label' => $allMonthsLabels[$m - 1]];
        }
    } else {
        for ($m = 1; $m <= 12; $m++) {
            $count = \App\Models\Report::whereYear('date_report', $selectedYear)
                        ->whereMonth('date_report', $m)->count();
            $chartData[] = ['val' => $count, 'label' => $allMonthsLabels[$m - 1]];
        }
    }

    if ($request->ajax()) {
        return response()->json([
            'chartData' => $chartData
        ]);
    }

    $monthlyData = array_column($chartData, 'val');
    $monthsLabels = array_column($chartData, 'label');

    return view('admin.dashboard', compact(
        'monthlyData', 'monthsLabels', 'selectedYear', 'availableYears', 'selectedRange','totalLaporan', 'laporanPending', 'laporanProses', 'laporanSelesai', 'laporanDitolak', 'latestReports'
    ));
}

    public function allReports(Request $request)
    {
        $categoriesList = Category::all();
        $facilitiesList = Facility::all();

        $query = Report::with(['user', 'facility.category', 'histories']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('location_custom', 'LIKE', '%' . $search . '%')
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('category_id')) {
            $categoryId = $request->input('category_id');
            $query->whereHas('facility', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        if ($request->filled('facility_id')) {
            $facilityId = $request->input('facility_id');
            $query->where('facility_id', $facilityId);
        }

        if ($request->filled('role_type')) {
            $roleType = $request->input('role_type');
            $query->whereHas('user', function ($q) use ($roleType) {
                if ($roleType === 'siswa') {
                    // Asumsi kolom nis ada di tabel users
                    $q->whereNotNull('nis')->where('nis', '!=', '');
                } elseif ($roleType === 'guru') {
                    // Asumsi kolom nip ada di tabel users
                    $q->whereNotNull('nip')->where('nip', '!=', '');
                }
            });
        }

        if ($request->filled('month')) {
            $month = $request->input('month'); // Format dari input month adalah YYYY-MM
            $query->whereYear('date_report', substr($month, 0, 4))
                ->whereMonth('date_report', substr($month, 5, 2));
        }

        $reports = $query->latest('date_report')->paginate(10)->withQueryString();

        $reports->getCollection()->transform(function ($report) {
            $nis = $report->user->nis ?? null;
            $nip = $report->user->nip ?? null;

            if (!empty($nis)) {
                $report->pelapor_jabatan = 'SISWA';
            } elseif (!empty($nip)) {
                $report->pelapor_jabatan = 'GURU';
            } else {
                $report->pelapor_jabatan = $report->user->class ? strtoupper($report->user->class) : 'STAFF';
            }
            return $report;
        });


        if ($request->has('export') && $request->export === 'excel') {
        $reportsForExport = $query->latest('date_report')->take(20)->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Laporan');

        // 1. Tentukan Header
        $headers = ['A1'=>'Fasilitas Utama', 'B1'=>'Sub-Fasilitas', 'C1'=>'Lokasi', 'D1'=>'Judul Laporan', 'E1'=>'Pelapor', 'F1'=>'Jabatan', 'G1'=>'Tanggal Dilaporkan'];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF046D64']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        $row = 2; // Mulai dari baris ke-2
        foreach ($reportsForExport as $r) {
            // Deteksi Jabatan
            $nis = $r->user->nis ?? null;
            $nip = $r->user->nip ?? null;
            
            if (!empty($nis)) {
                $pelaporType = 'Siswa';
            } elseif (!empty($nip)) {
                $pelaporType = 'Guru';
            } else {
                $pelaporType = $r->user->class ? strtoupper($r->user->class) : 'Staff';
            }

            $sheet->setCellValue('A'.$row, $r->facility->category->name_category ?? '-');
            $sheet->setCellValue('B'.$row, $r->facility->name_facility ?? '-');
            $sheet->setCellValue('C'.$row, $r->location_custom ?? $r->facility->location ?? '-');
            $sheet->setCellValue('D'.$row, $r->title ?? '-');
            $sheet->setCellValue('E'.$row, $r->user->name ?? 'Unknown');
            $sheet->setCellValue('F'.$row, $pelaporType);
            $sheet->setCellValue('G'.$row, \Carbon\Carbon::parse($r->date_report)->format('d-m-Y'));

            $sheet->getStyle('A'.$row.':G'.$row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle('F'.$row.':G'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'Laporan_Sarpras_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

        return view('admin.reports', compact('reports', 'categoriesList', 'facilitiesList'));
    }

    public function destroyReport($id)
    {
    $report = \App\Models\Report::findOrFail($id);
    
    if ($report->photo) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($report->photo);
    }
    
    $report->delete();
    
    return redirect()->route('admin.dashboard')->with('success', 'Berkas laporan kerusakan berhasil dihapus secara permanen!');
    }

    public function facilitiesIndex()
    {
        $categories = Category::withCount('facilities')->get();
        return view('admin.facilities.index', compact('categories'));

    }

    public function facilitiesShow(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $search = $request->input('search');

        $subCategories = Facility::where('category_id', $id)
            ->withCount('reports') 
            ->when($search, function($query, $search) {
                return $query->where('name_facility', 'like', '%' . $search . '%')
            ->orWhere('location', 'like', '%' . $search . '%');
            })
            ->get();

        return view('admin.facilities.show', compact('category', 'subCategories', 'search'));
    }

    public function facilitiesStore(Request $request)
    {
        if ($request->input('form_type') === 'category') {
            $request->validate([
                'name_category' => 'required|string|max:255',
                'description_category' => 'nullable|string',
                'image_category' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $imageName = 'default-facility.jpg';
            if ($request->hasFile('image_category')) {
                $imageName = time() . '.' . $request->file('image_category')->getClientOriginalExtension();
                $request->file('image_category')->move(public_path('images/facilities'), $imageName);
            }

            Category::create([
                'name_category' => $request->name_category,
                'description_category' => $request->description_category,
                'image_category' => $imageName
            ]);

            return redirect()->route('admin.facility.index')->with('success', 'Kategori Utama Sarpras Baru Berhasil Ditambahkan!');
        } else {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name_facility' => 'required|string|max:255',
                'location' => 'required|string|max:255'
            ]);

            Facility::create([
                'category_id' => $request->category_id,
                'name_facility' => strtoupper($request->name_facility), // Otomatis diset huruf besar
                'location' => $request->location,
                'condition' => 'Rusak Ringan'
            ]);

            return redirect()->route('admin.facility.show', $request->category_id)->with('success', 'Sub-Kategori Ruangan Baru Berhasil Ditambahkan!');
        }
    }

    public function showReport($id)
    {
        $report = Report::with(['user', 'facility'])->findOrFail($id);
        
        $histories = \App\Models\History::with('user')
            ->where('report_id', $id)
            ->orderBy('date_update', 'desc')
            ->paginate(3, ['*'], 'history_page');
    
        return view('admin.show-report', compact('report', 'histories'));
    }
    

    public function updateStatus(Request $request, $id)
    {
    $request->validate([
        'status' => 'required|in:Pending,Proses,Selesai,Tolak',
        'note' => 'nullable|string',
        'photo_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    date_default_timezone_set('Asia/Jakarta');
    $report = Report::findOrFail($id);

    $report->status = $request->status;
    $report->save();

    $photoPath = null;
    if ($request->status === 'Selesai' && $request->hasFile('photo_proof')) {
        $photoPath = $request->file('photo_proof')->store('reports_completed', 'public');
    }

    History::create([
        'report_id' => $report->id,
        'user_id' => Auth::id(),
        'note' => $request->note ?? "Status laporan diubah oleh Admin menjadi '" . $request->status . "'.",
        'photo' => $photoPath, // <-- Path foto tersimpan aman di sini
        'date_update' => now()
    ]);

    return redirect()->route('admin.show-report', $report->id)->with('success', 'Tanggapan dan status laporan berhasil diperbarui!');
    }

    public function userProfileView()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin')); // Tetap di dalam folder user
    }
        
    public function updateProfile(Request $request)
    {
    $admin = Auth::user();
        
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'old_password' => 'nullable|string', // Wajib diisi jika ingin ganti password baru
        'password' => 'nullable|string|min:6|confirmed',
        'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi file gambar Anda
    ]);
            
    $admin->name = $request->name;
    $admin->email = $request->email;
            
    if ($request->filled('password')) { 
        if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $admin->password)) {
            return back()->withErrors(['old_password' => 'Password lama yang Anda masukkan salah.'])->withInput();
        }
        $admin->password = \Illuminate\Support\Facades\Hash::make($request->password);
    }
    
    if ($request->hasFile('photo_profile')) {
        // Hapus file foto lama dari folder storage agar server tidak penuh (sesuai kode benar Anda)
        if ($admin->photo && !str_contains($user->photo, 'http')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($admin->photo);
        }

        $path = $request->file('photo_profile')->store('avatars', 'public');
        $admin->photo = $path; // Amankan ke kolom photo database
    }
                
    $admin->save();
                
    return redirect()->route('admin.profile.update')->with('success', 'Profil dan foto Anda berhasil diperbarui!');
    }


    public function about() {
        return view('admin.about');
    }

    public function settings() {
        return view('admin.settings');
    }

    public function welcome() {
    return view('welcome');
 
   }
    public function usersIndex()
    {
    
        $allUsers = User::where('role', 'user')
            ->withCount('reports')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.manauser', compact('allUsers'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        if (isset($user->is_active)) {
            $user->is_active = !$user->is_active;
        } else {
            if (str_contains($user->name, '[DIBLOKIR]')) {
                $user->name = str_replace(' [DIBLOKIR]', '', $user->name);
            } else {
                $user->name = $user->name . ' [DIBLOKIR]';
            }
        }
        
        $user->save();

        return redirect()->back()->with('success', 'Status hak akses akun ' . $user->name . ' berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo && !str_contains($user->photo, 'http')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
        }

        $user->reports()->delete();
        
        $user->delete();

        return redirect()->back()->with('success', 'Akun palsu/usil milik ' . $user->name . ' beserta seluruh riwayat aduannya telah dimusnahkan secara permanen!');
    }


    public function destroy_category($id)
    {
        try {
            $category = \App\Models\Category::findOrFail($id);

            \Illuminate\Support\Facades\DB::beginTransaction();

            $facilityIds = $category->facilities()->pluck('id');

            if ($facilityIds->isNotEmpty()) {

                \App\Models\Report::whereIn('facility_id', $facilityIds)->delete();

                \App\Models\Facility::whereIn('id', $facilityIds)->delete();
            }

            if ($category->image_category && \Illuminate\Support\Facades\Storage::disk('public')->exists('images/facilities/' . $category->image_category)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('images/facilities/' . $category->image_category);
            }

            $category->delete();

            \Illuminate\Support\Facades\DB::commit();

            return back()->with('success', 'Kategori utama, sub-ruangan, dan seluruh laporan terkait berhasil dihapus permanen.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            
            return back()->with('error', 'Gagal menghapus kategori! Pastikan tidak ada data yang terkunci. (Pesan sistem: ' . $e->getMessage() . ')');
        }
    }

    public function destroy($id)
    {
        $facility = \App\Models\Facility::findOrFail($id);
        
        // if ($facility->reports()->count() > 0) {
        //     return back()->with('error', 'Gagal menghapus! Ruangan ini masih memiliki laporan kerusakan.');
        // }

        $facility->delete();

        return back()->with('success', 'Sub-kategori ruangan berhasil dihapus secara permanen.');
    }

}