@extends('layouts.master')
@section('title', 'Tambah Layanan')

@section('content')
<h4 class="mb-4">Tambah Layanan Baru</h4>

<form action="{{ route('layanan.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nama_layanan" class="form-label">Nama Layanan</label>
        <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" required
               value="{{ old('nama_layanan') }}">
    </div>

    <div class="mb-3">
        <label for="harga_per_satuan" class="form-label">Harga per Satuan (Rp)</label>
        <input type="number" name="harga_per_satuan" id="harga_per_satuan" class="form-control" required
               value="{{ old('harga_per_satuan') }}">
    </div>

    <div class="mb-3">
        <label for="satuan" class="form-label">Satuan</label>
        <input type="text" name="satuan" id="satuan" class="form-control" required
               value="{{ old('satuan', 'kg') }}">
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
