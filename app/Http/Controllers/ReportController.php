<?php

namespace App\Http\Controllers;

use App\Models\Report; // Jangan lupa import Model Report di atas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        // Mengambil semua laporan beserta data user dan fasilitas terkait sekaligus
        $reports = Report::with(['user', 'facility'])->get();

        // Kirim variabel $reports ke file tampilan (view)
        return view('admin.report.index', compact('reports'));
    }

public function storeUserReport(Request $request)
{
    // 1. Validasi Input Data Form
    $request->validate([
        'title' => 'required|string|max:255',
        'facility_id' => 'required|exists:facilities,id',
        'description' => 'required|string',
        'evidence_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Batasi maksimal 2MB demi menghemat hosting
    ]);

    // 2. LOGIKA UNGGAH FOTO BUKTI YANG BENAR
    $imagePath = null;
    if ($request->hasFile('evidence_photo')) {
        // Menyimpan foto ke folder 'storage/app/public/reports' secara otomatis
        // Fungsi store() ini akan menghasilkan string nama acak yang unik (anti-bentrok)
        $imagePath = $request->file('evidence_photo')->store('reports', 'public');
    }

    // 3. Simpan Seluruh Data ke Database
    Report::create([
        'user_id' => Auth::id(),
        'facility_id' => $request->facility_id,
        'title' => $request->title,
        'description' => $request->description,
        'evidence_photo' => $imagePath, // Menyimpan string jalan pintas folder seperti: "reports/nama_file.jpg"
        'status' => 'Pending',
        'date_report' => now(),
    ]);

    return redirect()->route('user.report.index')->with('success', 'Laporan kerusakan fasilitas berhasil dikirim dan sedang menunggu validasi!');
}

}
