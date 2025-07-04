<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'satuan',
        'harga_per_satuan',
        'deskripsi',
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'layanan_id');
    }
    
}
