@extends('layouts.master')
@section('title', 'Detail Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Detail Pelanggan</h4>
    <div>
        <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pelanggan</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>
                <h4>{{ $pelanggan->nama }}</h4>
                <p class="text-muted">{{ $pelanggan->telepon }}</p>
                @if($pelanggan->alamat)
                <p class="text-muted">{{ $pelanggan->alamat }}</p>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('pesanan.create') }}?pelanggan_id={{ $pelanggan->id }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pesanan
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistik -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Statistik</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary">{{ $pesanan->count() }}</h4>
                        <small class="text-muted">Total Pesanan</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $pesanan->where('status_laundry', 'selesai')->count() }}</h4>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Pesanan</h5>
                <span class="badge bg-primary">{{ $pesanan->count() }} pesanan</span>
            </div>
            <div class="card-body">
                @if($pesanan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status Laundry</th>
                                <th>Status Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('pesanan.show', $item->id) }}" class="text-primary fw-bold">
                                        {{ $item->nomor_pesanan }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d/m/Y') }}</td>
                                <td class="text-success fw-bold">Rp {{ number_format($item->jumlah_total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $item->status_laundry == 'selesai' ? 'bg-success' : ($item->status_laundry == 'dibatalkan' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->status_laundry)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $item->status_pembayaran == 'sudah_bayar' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->status_pembayaran)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('pesanan.show', $item->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pesanan.edit', $item->id) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada pesanan</h6>
                    <p class="text-muted">Pelanggan ini belum memiliki riwayat pesanan</p>
                    <a href="{{ route('pesanan.create') }}?pelanggan_id={{ $pelanggan->id }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Pesanan Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 