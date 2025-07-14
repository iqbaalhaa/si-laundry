<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Layanan;

class StatusLaundryController extends Controller
{
    public function index()
    {
        return view('cek-status');
    }

    public function cek(Request $request)
    {
        $kode = $request->input('kode');
        $pesanan = DB::table('pesanan')->where('nomor_pesanan', $kode)->first();
        $pelanggan = null;
        $statusList = [];
        if ($pesanan) {
            $pelanggan = DB::table('pelanggan')->where('id', $pesanan->pelanggan_id)->first();
            // Ambil layanan yang dipilih pada pesanan
            $detailLayanan = DetailPesanan::where('pesanan_id', $pesanan->id)->with('layanan')->get();
            $layananNames = $detailLayanan->pluck('layanan.nama_layanan')->map(function($v) { return strtolower($v); })->toArray();

            // Logika status berdasarkan layanan
            if (in_array('cuci', $layananNames) && in_array('setrika', $layananNames)) {
                // Cuci + Setrika
                $statusList = [
                    'menunggu' => 'Menunggu',
                    'proses_cuci' => 'Proses Cuci',
                    'proses_pengeringan' => 'Proses Pengeringan',
                    'proses_setrika' => 'Proses Setrika',
                    'siap_diambil' => 'Siap Diambil',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan',
                ];
            } elseif (in_array('cuci', $layananNames)) {
                // Hanya Cuci
                $statusList = [
                    'menunggu' => 'Menunggu',
                    'proses_cuci' => 'Proses Cuci',
                    'proses_pengeringan' => 'Proses Pengeringan',
                    'siap_diambil' => 'Siap Diambil',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan',
                ];
            } elseif (in_array('setrika', $layananNames)) {
                // Hanya Setrika
                $statusList = [
                    'menunggu' => 'Menunggu',
                    'proses_setrika' => 'Proses Setrika',
                    'siap_diambil' => 'Siap Diambil',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan',
                ];
            } else {
                // Default (semua status)
                $statusList = [
                    'menunggu' => 'Menunggu',
                    'proses_cuci' => 'Proses Cuci',
                    'proses_pengeringan' => 'Proses Pengeringan',
                    'proses_setrika' => 'Proses Setrika',
                    'siap_diambil' => 'Siap Diambil',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan',
                ];
            }
        }
        return view('cek-status', compact('pesanan', 'kode', 'pelanggan', 'statusList'));
    }
}
