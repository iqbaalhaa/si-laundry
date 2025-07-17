<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Laundry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            font-family: 'Inter', sans-serif;
        }
        .modern-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 32px 0 rgba(80, 112, 255, 0.10), 0 1.5px 4px 0 rgba(60, 72, 88, 0.08);
            padding: 2.5rem 2rem;
        }
        .modern-title {
            font-weight: 600;
            color: #3b3b5c;
            letter-spacing: 1px;
        }
        .modern-input {
            border-radius: 12px;
            box-shadow: 0 2px 8px 0 rgba(80, 112, 255, 0.07);
            border: 1px solid #dbeafe;
        }
        .modern-btn {
            border-radius: 12px;
            background: linear-gradient(90deg, #6366f1 0%, #38bdf8 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 8px 0 rgba(80, 112, 255, 0.10);
            transition: background 0.2s;
        }
        .modern-btn:hover {
            background: linear-gradient(90deg, #38bdf8 0%, #6366f1 100%);
        }
        .status-step {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }
        .status-step .circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #e0e7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #6366f1;
            margin: 0 8px;
            font-weight: 600;
            box-shadow: 0 2px 8px 0 rgba(80, 112, 255, 0.07);
            position: relative;
            z-index: 1;
        }
        .status-step .circle.checked {
            background: #38bdf8;
            color: #fff;
            animation: pulse 0.7s;
        }
        .status-step .circle.active {
            background: #6366f1;
            color: #fff;
            box-shadow: 0 0 0 4px #c7d2fe;
            animation: pulse 1s infinite alternate;
        }
        .status-step .circle.bg-danger {
            background: #ef4444 !important;
            color: #fff !important;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 #c7d2fe; }
            100% { box-shadow: 0 0 0 8px #c7d2fe33; }
        }
        .status-step .line {
            flex: 1;
            height: 6px;
            background: #e0e7ff;
            border-radius: 3px;
            position: relative;
            top: -2px;
        }
        .status-step .line.active {
            background: linear-gradient(90deg, #6366f1 0%, #38bdf8 100%);
        }
        .status-step .line.bg-danger {
            background: #ef4444 !important;
        }
        .modern-table td {
            padding: 8px 16px;
            font-size: 1rem;
            color: #374151;
        }
        .modern-label {
            font-size: 13px;
            color: #6366f1;
            margin-top: 5px;
            text-align: center;
            font-weight: 500;
        }
        @media (max-width: 600px) {
            .modern-card { padding: 1.2rem 0.5rem; }
            .status-step .circle { width: 32px; height: 32px; font-size: 15px; }
            .modern-table td { font-size: 0.9rem; }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form method="POST" action="{{ route('cek-status.cek') }}"
                    class="mb-4 d-flex align-items-center gap-2">
                    @csrf
                    <input type="text" name="kode" class="form-control form-control-lg modern-input"
                        placeholder="Input Nomor Pesanan" value="{{ old('kode', $kode ?? '') }}" required>
                    <button class="btn btn-primary btn-lg modern-btn" type="submit">Cari!</button>
                </form>
                @if (isset($kode))
                    <div class="text-muted mb-4" style="font-size:13px;">Input 240421100510001 untuk demo</div>
                @endif
                <div class="modern-card shadow p-4">
                    <h3 class="text-center mb-4 modern-title">Status Laundry</h3>
                    @isset($pesanan)
                        @php
                            $statusKeys = array_keys($statusList ?? [
                                'menunggu' => 'Menunggu',
                                'proses_cuci' => 'Proses Cuci',
                                'proses_pengeringan' => 'Proses Pengeringan',
                                'proses_setrika' => 'Proses Setrika',
                                'siap_diambil' => 'Siap Diambil',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ]);
                            $currentStatus = $pesanan->status_laundry;
                            $currentIndex = array_search($currentStatus, $statusKeys);
                        @endphp
                        @if($currentStatus === 'dibatalkan')
                            <div class="alert alert-danger text-center">Pesanan ini <b>DIBATALKAN</b>.</div>
                        @endif
                        <div class="status-step mb-4">
                            @php
                                $icons = [
                                    'menunggu' => '⏳',
                                    'proses_cuci' => '🧺',
                                    'proses_pengeringan' => '💧',
                                    'proses_setrika' => '🧼',
                                    'siap_diambil' => '📦',
                                    'selesai' => '✅',
                                    'dibatalkan' => '❌',
                                ];
                                // Selalu exclude 'dibatalkan' dari loop
                                $showStatusKeys = array_filter($statusKeys, function($s) { return $s !== 'dibatalkan'; });
                            @endphp
                            @foreach($showStatusKeys as $i => $status)
                                <div class="circle @if($i < $currentIndex) checked @elseif($i == $currentIndex && $currentStatus !== 'dibatalkan') active @endif">
                                    {!! $icons[$status] ?? '' !!}
                                </div>
                                @if($loop->index < count($showStatusKeys) - 1)
                                    <div class="line @if($i < $currentIndex && $currentStatus !== 'dibatalkan') active @endif"></div>
                                @endif
                            @endforeach
                            @if($currentStatus === 'dibatalkan')
                                <div class="circle bg-danger">{!! $icons['dibatalkan'] !!}</div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            @php
                                $showStatusList = $statusList ?? [];
                                if ($currentStatus !== 'dibatalkan') {
                                    unset($showStatusList['dibatalkan']);
                                }
                            @endphp
                            @foreach($showStatusList as $label)
                                <div class="modern-label flex-fill">{{ $label }}</div>
                            @endforeach
                            @if($currentStatus === 'dibatalkan')
                                <div class="modern-label flex-fill">Dibatalkan</div>
                            @endif
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <table class="table table-borderless w-auto mx-auto modern-table">
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td>{{ $pelanggan->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{ $pesanan->created_at ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @elseif(isset($kode))
                        <div class="alert alert-danger text-center">Pesanan dengan kode <b>{{ $kode }}</b> tidak
                            ditemukan.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
