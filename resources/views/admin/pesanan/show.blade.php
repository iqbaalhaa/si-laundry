@extends('layouts.master')
@section('title', 'Detail Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Detail Pesanan</h4>
    <div>
        <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Kode Pesanan:</strong></td>
                                <td>{{ $pesanan->nomor_pesanan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Pesanan:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Estimasi Ambil:</strong></td>
                                <td>
                                    @if($pesanan->estimasi_ambil)
                                        {{ \Carbon\Carbon::parse($pesanan->estimasi_ambil)->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">Belum diatur</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="text-success fw-bold">Rp {{ number_format($pesanan->jumlah_total, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Status Laundry:</strong></td>
                                <td>
                                    <span class="badge {{ $pesanan->status_laundry == 'selesai' ? 'bg-success' : ($pesanan->status_laundry == 'dibatalkan' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $pesanan->status_laundry)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status Pembayaran:</strong></td>
                                <td>
                                    <span class="badge {{ $pesanan->status_pembayaran == 'sudah_bayar' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst(str_replace('_', ' ', $pesanan->status_pembayaran)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat Oleh:</strong></td>
                                <td>{{ $pesanan->user->name ?? 'Admin' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat Pada:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($pesanan->catatan)
                <div class="mt-3">
                    <strong>Catatan:</strong>
                    <div class="alert alert-info mt-2">
                        {{ $pesanan->catatan }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle fa-3x text-primary"></i>
                </div>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $pesanan->pelanggan->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td>{{ $pesanan->pelanggan->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td>{{ $pesanan->pelanggan->alamat ?? '-' }}</td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="{{ route('pelanggan.show', $pesanan->pelanggan->id) }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-eye"></i> Lihat Detail Pelanggan
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Timeline Status -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Timeline Status</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Pesanan Dibuat</h6>
                            <p class="timeline-text">{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($pesanan->status_laundry != 'menunggu')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Status: {{ ucfirst(str_replace('_', ' ', $pesanan->status_laundry)) }}</h6>
                            <p class="timeline-text">Pesanan sedang diproses</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($pesanan->status_laundry == 'selesai')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Selesai</h6>
                            <p class="timeline-text">Pesanan telah selesai diproses</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    padding-left: 10px;
}

.timeline-title {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
}

.timeline-text {
    margin: 0;
    font-size: 0.8rem;
    color: #6c757d;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -29px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
</style>
@endsection 