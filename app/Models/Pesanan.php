<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'nomor_pesanan',
        'tanggal_pesanan',
        'estimasi_ambil',
        'aktual_ambil',
        'jumlah_total',
        'status_pembayaran',
        'status_laundry',
        'catatan',
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // Relasi ke admin/user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke detail pesanan (untuk blade: $item->detail)
    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    // Relasi ke detail pesanan (untuk dashboard: $item->detailPesanan)
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

}
