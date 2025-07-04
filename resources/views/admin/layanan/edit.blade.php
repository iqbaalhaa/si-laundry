@extends('layouts.master')
@section('title', 'Edit Layanan')

@section('content')
<h4 class="mb-4">Edit Layanan</h4>

<form action="{{ route('layanan.update', $layanan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nama_layanan" class="form-label">Nama Layanan</label>
        <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" required
               value="{{ old('nama_layanan', $layanan->nama_layanan) }}">
    </div>

    <div class="mb-3">
        <label for="harga_per_satuan" class="form-label">Harga per Satuan (Rp)</label>
        <input type="number" name="harga_per_satuan" id="harga_per_satuan" class="form-control" required
               value="{{ old('harga_per_satuan', $layanan->harga_per_satuan) }}">
    </div>

    <div class="mb-3">
        <label for="satuan" class="form-label">Satuan</label>
        <input type="text" name="satuan" id="satuan" class="form-control" required
               value="{{ old('satuan', $layanan->satuan) }}">
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
