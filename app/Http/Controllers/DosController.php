<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosLog;

class DosController extends Controller
{
    public function index(Request $request)
    {
        // Simpan IP yang masuk
        DosLog::create([
            'ip_address' => $request->ip(),
            'accessed_at' => now(),
        ]);

        // Ambil semua log IP
        $logs = DosLog::orderBy('accessed_at', 'desc')->get();

        // Tampilkan ke view
        return view('dos.index', compact('logs'));
    }
    public function destroyAll()
    {
        DosLog::truncate(); // Hapus semua data
        return redirect()->route('dos.index')->with('success', 'Semua log berhasil dihapus.');
    }
}
