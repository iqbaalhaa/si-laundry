@extends('layouts.master')
@section('title', 'Form Pelanggan')

@section('content')
<h4 class="mb-4">{{ isset($pelanggan) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</h4>

<form action="{{ isset($pelanggan) ? route('pelanggan.update', $pelanggan->id) : route('pelanggan.store') }}" method="POST">
    @csrf
    @if(isset($pelanggan)) @method('PUT') @endif

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" required>
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="telepon" value="{{ old('telepon') }}" class="form-control @error('telepon') is-invalid @enderror" required>
        @error('telepon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
