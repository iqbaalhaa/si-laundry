<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($pesanan) {
            $pelanggan = DB::table('pelanggan')->where('id', $pesanan->pelanggan_id)->first();
        }
        return view('cek-status', compact('pesanan', 'kode', 'pelanggan'));
    }
}
