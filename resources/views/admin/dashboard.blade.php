@extends('layouts.master')

@section('title', 'Dashboard')

@push('styles')
<style>
    .card-group .card {
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .card-group .card:not(:last-child) {
        border-right: 1px solid #e9ecef;
    }
    .opacity-7 {
        opacity: 0.7;
    }
    .border-left-line {
        border-left: 2px solid #e9ecef;
        padding-left: 20px;
    }
    .btn-circle {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .progress {
        background-color: #f8f9fa;
    }
    .progress-bar {
        background-color: #007bff;
    }
    .chart-container {
        position: relative;
        height: 220px;
        min-height: 200px;
        width: 100%;
        overflow: hidden;
    }
    .chart-container canvas {
        width: 100% !important;
        height: 100% !important;
        max-height: 220px;
    }
    .quick-menu-card {
        transition: box-shadow 0.2s, transform 0.2s;
        cursor: pointer;
        border-radius: 1rem;
    }
    .quick-menu-card:hover {
        box-shadow: 0 0 0.5rem #007bff33, 0 2px 8px #00000022;
        transform: translateY(-4px) scale(1.03);
    }
    .card,
    .quick-menu-card {
        box-shadow: 0 2px 16px 0 #00000018, 0 1.5px 6px 0 #007bff22;
        border-radius: 1.1rem;
        transition: box-shadow 0.25s, transform 0.22s;
    }
    .card:hover,
    .quick-menu-card:hover {
        box-shadow: 0 8px 32px 0 #007bff33, 0 4px 16px 0 #00000022;
        transform: translateY(-6px) scale(1.03);
        z-index: 2;
    }
</style>
@endpush

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Selamat Datang, {{ Auth::user()->nama }}</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <br>
        <div class="col-5 align-self-center">
            <div class="customize-input float-right">
                <select class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius">
                    <option selected>{{ date('M Y') }}</option>
                    <option value="1">{{ date('M Y', strtotime('-1 month')) }}</option>
                    <option value="2">{{ date('M Y', strtotime('-2 month')) }}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<br>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- *************************************************************** -->
    <!-- Start First Cards -->
    <!-- *************************************************************** -->
    <div class="card-group">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ \App\Models\Pelanggan::count() }}</h2>
                            <span class="badge badge-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none">+12%</span>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Pelanggan</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">Rp {{ number_format(\App\Models\Pesanan::where('status_laundry', 'selesai')->sum('jumlah_total'), 0, ',', '.') }}</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Pendapatan</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ \App\Models\Pesanan::whereIn('status_laundry', ['proses_cuci','proses_pengeringan','proses_setrika'])->count() }}</h2>
                            <span class="badge badge-warning font-12 text-white font-weight-medium badge-pill ml-2 d-md-none d-lg-block">Sedang Proses</span>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pesanan Proses</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="clock"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">{{ \App\Models\Pesanan::where('status_laundry', 'menunggu')->count() }}</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pesanan Baru</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="package"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End First Cards -->
    <!-- *************************************************************** -->
    
    <div class="row mb-4">
        <div class="col">
            <a href="{{ route('pesanan.create') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100 quick-menu-card">
                    <div class="card-body">
                        <i class="fas fa-plus fa-2x text-success mb-2"></i>
                        <div class="font-weight-bold">Tambah Pesanan</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('pesanan.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100 quick-menu-card">
                    <div class="card-body">
                        <i class="fas fa-list fa-2x text-primary mb-2"></i>
                        <div class="font-weight-bold">Lihat Pesanan</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('pelanggan.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100 quick-menu-card">
                    <div class="card-body">
                        <i class="fas fa-users fa-2x text-info mb-2"></i>
                        <div class="font-weight-bold">Pelanggan</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('layanan.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100 quick-menu-card">
                    <div class="card-body">
                        <i class="fas fa-tags fa-2x text-warning mb-2"></i>
                        <div class="font-weight-bold">Layanan</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('laporan.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100 quick-menu-card">
                    <div class="card-body">
                        <i class="fas fa-file-alt fa-2x text-dark mb-2"></i>
                        <div class="font-weight-bold">Laporan</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- *************************************************************** -->
    <!-- Start Sales Charts Section -->
    <!-- *************************************************************** -->
    <div class="row align-items-stretch">
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title">Status Pesanan</h4>
                    @php
                        $selesai = \App\Models\Pesanan::where('status_laundry', 'selesai')->count();
                        $proses = \App\Models\Pesanan::whereIn('status_laundry', ['proses_cuci','proses_pengeringan','proses_setrika'])->count();
                        $baru = \App\Models\Pesanan::where('status_laundry', 'menunggu')->count();
                        $total = $selesai + $proses + $baru;
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-check-circle text-success"></i> Selesai</span>
                            <span class="font-weight-bold text-success">{{ $selesai }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $total > 0 ? ($selesai/$total*100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-sync text-warning"></i> Proses</span>
                            <span class="font-weight-bold text-warning">{{ $proses }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $total > 0 ? ($proses/$total*100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-clock text-info"></i> Baru</span>
                            <span class="font-weight-bold text-info">{{ $baru }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: {{ $total > 0 ? ($baru/$total*100) : 0 }}%"></div>
                        </div>
                    </div>
                    <a href="{{ route('pesanan.index') }}" class="btn btn-primary btn-block mt-4">
                        Lihat Semua Pesanan
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title">Pendapatan Bulanan</h4>
                    <div class="chart-container mt-4 flex-grow-1">
                        <canvas id="pendapatan-chart"></canvas>
                    </div>
                    <ul class="list-inline text-center mt-5 mb-2 mt-auto">
                        <li class="list-inline-item text-muted font-italic">Pendapatan 6 bulan terakhir</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title mb-4">Layanan Terpopuler</h4>
                    <div class="chart-container flex-grow-1" style="height:220px">
                        <canvas id="layanan-chart"></canvas>
                    </div>
                    <div class="row mb-3 align-items-center mt-1 mt-5 mt-auto">
                        @php
                            $layananPopuler = \App\Models\DetailPesanan::selectRaw('layanan_id, COUNT(*) as total')
                                ->with('layanan')
                                ->groupBy('layanan_id')
                                ->orderBy('total', 'desc')
                                ->limit(4)
                                ->get();
                        @endphp
                        @if($layananPopuler->count() > 0)
                            @foreach($layananPopuler as $index => $layanan)
                            <div class="col-4 text-right">
                                <span class="text-muted font-14">{{ $layanan->layanan->nama_layanan }}</span>
                            </div>
                            <div class="col-5">
                                <div class="progress" style="height: 5px;">
                                    @php
                                        $maxTotal = $layananPopuler->max('total');
                                        $percentage = ($layanan->total / $maxTotal) * 100;
                                    @endphp
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-3 text-right">
                                <span class="mb-0 font-14 text-dark font-weight-medium">{{ $layanan->total }}</span>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center">
                                <span class="text-muted font-14">Belum ada data layanan</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Sales Charts Section -->
    <!-- *************************************************************** -->
    
    <!-- *************************************************************** -->
    <!-- Start Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title mb-0">Statistik Pesanan</h4>
                        <div class="ml-auto">
                            <div class="dropdown sub-dropdown">
                                <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                    id="dd1" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                    <a class="dropdown-item" href="{{ route('pesanan.index') }}">Lihat Semua</a>
                                    <a class="dropdown-item" href="{{ route('pesanan.create') }}">Tambah Pesanan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-4 mb-5">
                        <div class="chart-container stats ct-charts position-relative" style="height: 250px;">
                            <canvas id="pesanan-chart"></canvas>
                        </div>
                    </div>
                    <ul class="list-inline text-center mt-4 mb-0">
                        <li class="list-inline-item text-muted font-italic">Pesanan 7 hari terakhir</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas Terbaru</h4>
                    <div class="mt-4 activity">
                        @php
                            $pesananTerbaru = \App\Models\Pesanan::with('pelanggan')->orderBy('created_at', 'desc')->limit(3)->get();
                        @endphp
                        @if($pesananTerbaru->count() > 0)
                            @foreach($pesananTerbaru as $pesanan)
                            <div class="d-flex align-items-start border-left-line pb-3">
                                <div>
                                    <a href="javascript:void(0)" class="btn btn-info btn-circle mb-2 btn-item">
                                        <i data-feather="shopping-bag"></i>
                                    </a>
                                </div>
                                <div class="ml-3 mt-2">
                                    <h5 class="text-dark font-weight-medium mb-2">Pesanan Baru!</h5>
                                    <p class="font-14 mb-2 text-muted">{{ $pesanan->pelanggan->nama }} baru membuat pesanan<br>
                                        dengan total Rp {{ number_format($pesanan->jumlah_total, 0, ',', '.') }}
                                    </p>
                                    <span class="font-weight-light font-14 text-muted">{{ $pesanan->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="d-flex align-items-start border-left-line pb-3">
                                <div>
                                    <a href="javascript:void(0)" class="btn btn-info btn-circle mb-2 btn-item">
                                        <i data-feather="info"></i>
                                    </a>
                                </div>
                                <div class="ml-3 mt-2">
                                    <h5 class="text-dark font-weight-medium mb-2">Belum ada aktivitas</h5>
                                    <p class="font-14 mb-2 text-muted">Belum ada pesanan baru<br>dalam sistem</p>
                                    <span class="font-weight-light font-14 text-muted">Sekarang</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="d-flex align-items-start border-left-line">
                            <div>
                                <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                    <i data-feather="bell"></i>
                                </a>
                            </div>
                            <div class="ml-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">Sistem Laundry</h5>
                                <p class="font-14 mb-2 text-muted">Selamat datang di sistem laundry<br>yang terintegrasi</p>
                                <span class="font-weight-light font-14 mb-1 d-block text-muted">Sekarang</span>
                                <a href="{{ route('pesanan.index') }}" class="font-14 border-bottom pb-1 border-info">Lihat Semua Pesanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    
    <!-- *************************************************************** -->
    <!-- Start Top Leader Table -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Pesanan Terbaru</h4>
                        <div class="ml-auto">
                            <a href="{{ route('pesanan.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Pelanggan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Layanan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Status</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Total</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $pesananTable = \App\Models\Pesanan::with(['pelanggan', 'detailPesanan.layanan'])->orderBy('created_at', 'desc')->limit(5)->get();
                                @endphp
                                @if($pesananTable->count() > 0)
                                    @foreach($pesananTable as $pesanan)
                                    <tr>
                                        <td class="border-top-0 px-2 py-4">
                                            <div class="d-flex no-block align-items-center">
                                                <div class="mr-3">
                                                    <div class="btn btn-primary rounded-circle btn-circle font-12">
                                                        {{ strtoupper(substr($pesanan->pelanggan->nama, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $pesanan->pelanggan->nama }}</h5>
                                                    <span class="text-muted font-14">{{ $pesanan->pelanggan->telepon }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14">
                                            @foreach($pesanan->detailPesanan as $detail)
                                                {{ $detail->layanan->nama_layanan }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </td>
                                        <td class="border-top-0 px-2 py-4">
                                            @if($pesanan->status_laundry == 'menunggu')
                                                <span class="badge badge-info">Baru</span>
                                            @elseif($pesanan->status_laundry == 'proses_cuci')
                                                <span class="badge badge-warning">Proses</span>
                                            @else
                                                <span class="badge badge-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="border-top-0 font-weight-medium text-dark px-2 py-4">
                                            Rp {{ number_format($pesanan->jumlah_total, 0, ',', '.') }}
                                        </td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14">
                                            {{ $pesanan->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada data pesanan
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Top Leader Table -->
    <!-- *************************************************************** -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Initialize Feather Icons
if (typeof feather !== 'undefined') {
    feather.replace();
}

// Debug: Check if Chart.js is loaded
console.log('Chart.js loaded:', typeof Chart !== 'undefined');

// Pendapatan Chart (Line)
const pendapatanCtx = document.getElementById('pendapatan-chart');
console.log('Pendapatan canvas element:', pendapatanCtx);

if (pendapatanCtx && typeof Chart !== 'undefined') {
    @php
        $pendapatanData = [];
        $bulanLabels = [];
        $hasPendapatanData = false;
        
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $pendapatan = \App\Models\Pesanan::where('status_laundry', 'selesai')
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->sum('jumlah_total');
            
            if ($pendapatan > 0) $hasPendapatanData = true;
            
            $pendapatanData[] = $pendapatan;
            $bulanLabels[] = $bulan->format('M Y');
        }
    @endphp
    
    console.log('Pendapatan data:', {!! json_encode($pendapatanData) !!});
    console.log('Bulan labels:', {!! json_encode($bulanLabels) !!});
    console.log('Has data:', {!! json_encode($hasPendapatanData) !!});
    
    @if($hasPendapatanData)
    try {
        new Chart(pendapatanCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($bulanLabels) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($pendapatanData) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });
        console.log('Pendapatan chart created successfully');
    } catch (error) {
        console.error('Error creating pendapatan chart:', error);
        pendapatanCtx.style.display = 'none';
        pendapatanCtx.parentElement.innerHTML = '<div class="text-center text-muted mt-4">Error loading chart: ' + error.message + '</div>';
    }
    @else
    // Tampilkan pesan jika tidak ada data
    pendapatanCtx.style.display = 'none';
    pendapatanCtx.parentElement.innerHTML = '<div class="text-center text-muted mt-4">Belum ada data pendapatan dalam 6 bulan terakhir</div>';
    @endif
} else {
    console.error('Chart.js not loaded or canvas element not found');
    if (pendapatanCtx) {
        pendapatanCtx.style.display = 'none';
        pendapatanCtx.parentElement.innerHTML = '<div class="text-center text-muted mt-4">Chart.js tidak dapat dimuat</div>';
    }
}

// Layanan Chart (Bar)
const layananCtx = document.getElementById('layanan-chart');
if (layananCtx) {
    @php
        $layananData = \App\Models\DetailPesanan::selectRaw('layanan_id, COUNT(*) as total')
            ->with('layanan')
            ->groupBy('layanan_id')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();
    @endphp
    
    @if($layananData->count() > 0)
    new Chart(layananCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($layananData->pluck('layanan.nama_layanan')) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode($layananData->pluck('total')) !!},
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @else
    // Tampilkan pesan jika tidak ada data
    layananCtx.style.display = 'none';
    layananCtx.parentElement.innerHTML = '<div class="text-center text-muted mt-4">Belum ada data layanan</div>';
    @endif
}

// Pesanan Chart (Line)
const pesananCtx = document.getElementById('pesanan-chart');
if (pesananCtx) {
    @php
        $last7Days = [];
        $hasData = false;
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = \App\Models\Pesanan::whereDate('created_at', $date)->count();
            if ($count > 0) $hasData = true;
            $last7Days[] = [
                'date' => $date->format('d/m'),
                'count' => $count
            ];
        }
    @endphp
    
    @if($hasData)
    new Chart(pesananCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(collect($last7Days)->pluck('date')) !!},
            datasets: [{
                label: 'Pesanan',
                data: {!! json_encode(collect($last7Days)->pluck('count')) !!},
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    @else
    // Tampilkan pesan jika tidak ada data
    pesananCtx.style.display = 'none';
    pesananCtx.parentElement.innerHTML = '<div class="text-center text-muted mt-4">Belum ada data pesanan dalam 7 hari terakhir</div>';
    @endif
}
</script>
@endsection
