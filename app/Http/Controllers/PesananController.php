<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\DetailPesanan;

class PesananController extends Controller
{
    public function index()
    {
        $data = Pesanan::with('pelanggan')->latest()->get();
        return view('admin.pesanan.index', compact('data'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $layanan = Layanan::all();
        return view('admin.pesanan.create', compact('pelanggan', 'layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'tanggal_pesanan' => 'required|date',
            'estimasi_ambil' => 'nullable|date|after_or_equal:tanggal_pesanan',
            'status_pembayaran' => 'required|in:belum_bayar,sudah_bayar,bayar_sebagian',
            'status_laundry' => 'required|in:menunggu,proses_cuci,proses_pengeringan,proses_setrika,siap_diambil,selesai,dibatalkan',
            'layanan_id.*' => 'required|exists:layanan,id',
            'kuantitas.*' => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan ke tabel pesanan
            $pesanan = Pesanan::create([
                'pelanggan_id' => $request->pelanggan_id,
                'user_id' => auth()->id(), // admin yang input
                'nomor_pesanan' => 'INV-' . time(),
                'tanggal_pesanan' => $request->tanggal_pesanan,
                'estimasi_ambil' => $request->estimasi_ambil,
                'jumlah_total' => 0, // hitung nanti
                'status_pembayaran' => $request->status_pembayaran,
                'status_laundry' => $request->status_laundry,
                'catatan' => $request->catatan,
            ]);

            $jumlah_total = 0;

            // Simpan detail pesanan
            foreach ($request->layanan_id as $index => $layanan_id) {
                $layanan = Layanan::findOrFail($layanan_id);
                $kuantitas = $request->kuantitas[$index];
                $subtotal = $layanan->harga_per_satuan * $kuantitas;

                $jumlah_total += $subtotal;

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'layanan_id' => $layanan_id,
                    'kuantitas' => $kuantitas,
                    'harga_saat_pesan' => $layanan->harga_per_satuan,
                    'subtotal' => $subtotal,
                    'catatan_item' => $request->catatan_item[$index] ?? null,
                ]);
            }

            // Update total di tabel pesanan
            $pesanan->update(['jumlah_total' => $jumlah_total]);
        });

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil disimpan.');
    }

    public function edit(Pesanan $pesanan)
    {
        $pelanggan = Pelanggan::all();
        $layanan = Layanan::all();
        $pesanan->load(['detail.layanan', 'pelanggan']);
        return view('admin.pesanan.edit', compact('pesanan', 'pelanggan', 'layanan'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'tanggal_pesanan' => 'required|date',
            'estimasi_ambil' => 'nullable|date|after_or_equal:tanggal_pesanan',
            'status_pembayaran' => 'required|in:belum_bayar,sudah_bayar,bayar_sebagian',
            'status_laundry' => 'required|in:menunggu,proses_cuci,proses_pengeringan,proses_setrika,siap_diambil,selesai,dibatalkan',
            'layanan_id.*' => 'required|exists:layanan,id',
            'kuantitas.*' => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request, $pesanan) {
            // Update data pesanan
            $pesanan->update([
                'pelanggan_id' => $request->pelanggan_id,
                'tanggal_pesanan' => $request->tanggal_pesanan,
                'estimasi_ambil' => $request->estimasi_ambil,
                'status_pembayaran' => $request->status_pembayaran,
                'status_laundry' => $request->status_laundry,
                'catatan' => $request->catatan,
            ]);

            // Hapus detail pesanan lama
            $pesanan->detail()->delete();

            $jumlah_total = 0;

            // Buat detail pesanan baru
            foreach ($request->layanan_id as $index => $layanan_id) {
                $layanan = Layanan::findOrFail($layanan_id);
                $kuantitas = $request->kuantitas[$index];
                $subtotal = $layanan->harga_per_satuan * $kuantitas;

                $jumlah_total += $subtotal;

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'layanan_id' => $layanan_id,
                    'kuantitas' => $kuantitas,
                    'harga_saat_pesan' => $layanan->harga_per_satuan,
                    'subtotal' => $subtotal,
                    'catatan_item' => $request->catatan_item[$index] ?? null,
                ]);
            }

            // Update total di tabel pesanan
            $pesanan->update(['jumlah_total' => $jumlah_total]);
        });

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diupdate.');
    }

    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Update status laundry via AJAX
     */
    public function updateStatusLaundry(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status_laundry' => 'required|in:menunggu,proses_cuci,proses_pengeringan,proses_setrika,siap_diambil,selesai,dibatalkan'
        ]);

        $pesanan->update([
            'status_laundry' => $request->status_laundry
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status laundry berhasil diupdate',
            'status_laundry' => $request->status_laundry
        ]);
    }

    /**
     * Cetak nota pesanan
     */
    public function cetak(Pesanan $pesanan)
    {
        $pesanan->load(['pelanggan', 'detail.layanan']);
        return view('admin.pesanan.cetak', compact('pesanan'));
    }
}
