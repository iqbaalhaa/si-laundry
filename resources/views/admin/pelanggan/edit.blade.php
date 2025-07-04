@extends('layouts.master')
@section('title', 'Edit Pelanggan')

@section('content')
<h4 class="mb-4">Edit Pelanggan</h4>

<form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $pelanggan->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="telepon" value="{{ old('telepon', $pelanggan->telepon) }}" class="form-control @error('telepon') is-invalid @enderror" required>
        @error('telepon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $pelanggan->alamat) }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection 