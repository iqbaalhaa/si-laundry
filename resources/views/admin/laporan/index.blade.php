@extends('layouts.master')
@section('title', 'Laporan Transaksi')

@section('content')
<h4 class="mb-4 fw-bold text-primary">📊 Laporan Transaksi</h4>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                📈 Pendapatan Per Hari
            </div>
            <div class="card-body">
                <canvas id="pendapatanChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                📦 Jumlah Pesanan Per Hari
            </div>
            <div class="card-body">
                <canvas id="pesananChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold">
                🟢 Status Laundry
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>


<form method="GET" action="{{ route('laporan.index') }}" class="row g-3 mb-4">
    <div class="col-md-4">
        <label>Tanggal Awal</label>
        <input type="date" name="tanggal_awal" class="form-control" value="{{ $tanggal_awal }}">
    </div>
    <div class="col-md-4">
        <label>Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggal_akhir }}">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i> Filter</button>
    </div>
</form>
<form method="POST" action="{{ route('laporan.cetak') }}" target="_blank" class="d-inline">
    @csrf
    <input type="hidden" name="tanggal_awal" value="{{ $tanggal_awal }}">
    <input type="hidden" name="tanggal_akhir" value="{{ $tanggal_akhir }}">
    <button type="submit" class="btn btn-outline-danger mb-3">
        <i class="fa-solid fa-print me-1"></i> Cetak PDF
    </button>
</form>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <h6 class="fw-bold text-primary">Total Pendapatan</h6>
                <h3 class="fw-bold text-success">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <h6 class="fw-bold text-success">Jumlah Pesanan</h6>
                <h3 class="fw-bold text-success">{{ $jumlah_pesanan }}</h3>
            </div>
        </div>
    </div>
</div>


<h5 class="mb-3">📋 Daftar Pesanan</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nomor Pesanan</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Status Pembayaran</th>
                <th>Status Laundry</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal_pesanan)->format('d M Y') }}</td>
                <td>{{ $row->nomor_pesanan }}</td>
                <td>{{ $row->pelanggan->nama }}</td>
                <td>Rp {{ number_format($row->jumlah_total, 0, ',', '.') }}</td>
                <td>
                    <span class="badge 
                        @if($row->status_pembayaran == 'sudah_bayar') bg-success
                        @elseif($row->status_pembayaran == 'bayar_sebagian') bg-warning text-dark
                        @else bg-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $row->status_pembayaran)) }}
                    </span>
                </td>
                <td>
                    <span class="badge 
                        @if($row->status_laundry == 'selesai') bg-success
                        @elseif(str_contains($row->status_laundry, 'proses')) bg-warning text-dark
                        @elseif($row->status_laundry == 'dibatalkan') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $row->status_laundry)) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pendapatan Per Hari
    const ctxPendapatan = document.getElementById('pendapatanChart').getContext('2d');
    new Chart(ctxPendapatan, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($pendapatan_per_hari)) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode(array_values($pendapatan_per_hari)) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Jumlah Pesanan Per Hari
    const ctxPesanan = document.getElementById('pesananChart').getContext('2d');
    new Chart(ctxPesanan, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($pesanan_per_hari)) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode(array_values($pesanan_per_hari)) !!},
                backgroundColor: 'rgba(28, 200, 138, 0.7)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Status Laundry (Pie Chart)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($status_laundry)) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode(array_values($status_laundry)) !!},
                backgroundColor: [
                    '#1cc88a', // selesai
                    '#f6c23e', // proses
                    '#e74a3b', // dibatalkan
                    '#858796'  // lainnya
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
