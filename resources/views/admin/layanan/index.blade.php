@extends('layouts.master')
@section('title', 'Data Layanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Daftar Layanan</h4>
    <a href="{{ route('layanan.create') }}" class="btn btn-primary">Tambah Layanan</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Nama Layanan</th>
            <th>Harga per Satuan</th>
            <th>Satuan</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_layanan }}</td>
            <td>Rp {{ number_format($item->harga_per_satuan, 0, ',', '.') }}</td>
            <td>{{ $item->satuan }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td>
                <a href="{{ route('layanan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('layanan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus layanan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada data layanan</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
