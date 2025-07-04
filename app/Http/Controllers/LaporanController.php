<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pelanggan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal ?? now()->startOfMonth()->format('Y-m-d');
        $tanggal_akhir = $request->tanggal_akhir ?? now()->endOfMonth()->format('Y-m-d');

        $pesanan = \App\Models\Pesanan::whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir])
            ->with('pelanggan')
            ->orderBy('tanggal_pesanan')
            ->get();

        $total_pendapatan = $pesanan->sum('jumlah_total');
        $jumlah_pesanan = $pesanan->count();

        // ✅ Hitung pendapatan per hari untuk grafik
        $pendapatan_per_hari = \App\Models\Pesanan::selectRaw('DATE(tanggal_pesanan) as tanggal, SUM(jumlah_total) as total')
            ->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal')
            ->toArray();

        // ✅ Hitung jumlah pesanan per hari untuk grafik
        $pesanan_per_hari = \App\Models\Pesanan::selectRaw('DATE(tanggal_pesanan) as tanggal, COUNT(*) as jumlah')
            ->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('jumlah', 'tanggal')
            ->toArray();

        // ✅ Hitung status laundry untuk grafik pie/donut
        $status_laundry = \App\Models\Pesanan::selectRaw('status_laundry, COUNT(*) as jumlah')
            ->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir])
            ->groupBy('status_laundry')
            ->pluck('jumlah', 'status_laundry')
            ->toArray();

        return view('admin.laporan.index', compact(
            'pesanan', 'tanggal_awal', 'tanggal_akhir',
            'total_pendapatan', 'jumlah_pesanan',
            'pendapatan_per_hari', 'pesanan_per_hari', 'status_laundry'
        ));
    }

    public function cetak(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal ?? now()->startOfMonth()->format('Y-m-d');
        $tanggal_akhir = $request->tanggal_akhir ?? now()->endOfMonth()->format('Y-m-d');

        $pesanan = \App\Models\Pesanan::whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir])
            ->with('pelanggan')
            ->orderBy('tanggal_pesanan')
            ->get();

        $total_pendapatan = $pesanan->sum('jumlah_total');

        return view('admin.laporan.cetak', compact(
            'pesanan', 'tanggal_awal', 'tanggal_akhir', 'total_pendapatan'
        ));
    }

}
