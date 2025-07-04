@extends('layouts.master')
@section('title', 'Data Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Daftar Pelanggan</h4>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->telepon }}</td>
            <td>{{ $item->alamat }}</td>
            <td>
                <a href="{{ route('pelanggan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">Belum ada data pelanggan</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
