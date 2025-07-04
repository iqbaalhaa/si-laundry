@extends('layouts.master')
@section('title', 'Tambah Pesanan')

@section('content')
<h4 class="mb-4">Tambah Pesanan Baru</h4>

<form action="{{ route('pesanan.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Pelanggan</label>
        <select name="pelanggan_id" class="form-control" required>
            <option value="">-- Pilih Pelanggan --</option>
            @foreach ($pelanggan as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->no_hp }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Tanggal Pesanan</label>
        <input type="datetime-local" name="tanggal_pesanan" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
    </div>

    <div class="mb-3">
        <label>Estimasi Ambil</label>
        <input type="datetime-local" name="estimasi_ambil" class="form-control">
    </div>

    <h5>Layanan</h5>
    <div id="layanan-container">
        <div class="row mb-2 layanan-item">
            <div class="col-md-4">
                <select name="layanan_id[]" class="form-control" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach ($layanan as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_layanan }} (Rp {{ number_format($l->harga_per_satuan, 0, ',', '.') }}/{{ $l->satuan }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="kuantitas[]" class="form-control" placeholder="Kuantitas" step="0.1" min="0.1" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="catatan_item[]" class="form-control" placeholder="Catatan (opsional)">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-layanan">&times;</button>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-success btn-sm" id="add-layanan">+ Tambah Layanan</button>

    <div class="mb-3 mt-4">
        <label>Status Pembayaran</label>
        <select name="status_pembayaran" class="form-control" required>
            <option value="belum_bayar">Belum Bayar</option>
            <option value="sudah_bayar">Sudah Bayar</option>
            <option value="bayar_sebagian">Bayar Sebagian</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Status Laundry</label>
        <select name="status_laundry" class="form-control" required>
            <option value="menunggu">Menunggu</option>
            <option value="proses_cuci">Proses Cuci</option>
            <option value="proses_pengeringan">Proses Pengeringan</option>
            <option value="proses_setrika">Proses Setrika</option>
            <option value="siap_diambil">Siap Diambil</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Catatan Pesanan</label>
        <textarea name="catatan" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
    document.getElementById('add-layanan').addEventListener('click', function () {
        let container = document.querySelector('#layanan-container');
        let item = container.querySelector('.layanan-item').cloneNode(true);
        item.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(item);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-layanan')) {
            e.target.closest('.layanan-item').remove();
        }
    });
</script>
@endsection
