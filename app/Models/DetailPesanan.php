<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'layanan_id',
        'kuantitas',
        'harga_saat_pesan',
        'subtotal',
        'catatan_item',
    ];

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Relasi ke Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
