<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');

            $table->string('nomor_pesanan')->unique();
            $table->dateTime('tanggal_pesanan');
            $table->dateTime('estimasi_ambil')->nullable();
            $table->dateTime('aktual_ambil')->nullable();
            $table->decimal('jumlah_total', 10, 2);

            $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar', 'bayar_sebagian'])->default('belum_bayar');
            $table->enum('status_laundry', [
                'menunggu',
                'proses_cuci',
                'proses_pengeringan',
                'proses_setrika',
                'siap_diambil',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');

            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
