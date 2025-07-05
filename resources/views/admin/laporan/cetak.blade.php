<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 14px; }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 28px 0 18px 0;
            border-bottom: 6px solid #1565c0;
            background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%);
            border-radius: 0 0 24px 24px;
            position: relative;
            color: #fff;
            box-shadow: 0 4px 16px rgba(21,101,192,0.08);
        }
        .header h4 {
            margin: 0;
            color: #fff;
            font-weight: bold;
            letter-spacing: 2px;
            text-shadow: 0 2px 8px rgba(21,101,192,0.12);
        }
        .header .kop-subtitle {
            color: #e3f2fd;
            font-size: 15px;
            margin-bottom: 0;
        }
        .kop-logo {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
            height: 55px;
        }
        .table th, .table td { vertical-align: middle; }
        .table thead th {
            background: #1976d2 !important;
            color: #fff !important;
            border-color: #1565c0 !important;
        }
        .table tfoot td {
            background: #1565c0 !important;
            color: #fff !important;
            border-color: #1565c0 !important;
        }
        .total-row { font-weight: bold; }
        .ttd-area {
            width: 250px;
            float: right;
            text-align: center;
            margin-top: 60px;
        }
        .ttd-space {
            height: 70px;
        }
        @media print {
            .ttd-area {
                page-break-before: always;
                float: right;
                margin-top: 100px;
            }
            .table thead th,
            .table tfoot td {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo-laundry.png') }}" alt="Logo Laundry" class="kop-logo" onerror="this.style.display='none'">
        <h4>LAPORAN TRANSAKSI</h4>
        <p class="kop-subtitle">Jl. Contoh Alamat No. 123, Kota Laundry &bull; Telp: 0812-3456-7890</p>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}</p>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
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
                <td>{{ ucfirst(str_replace('_', ' ', $row->status_pembayaran)) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $row->status_laundry)) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-end">TOTAL PENDAPATAN</td>
                <td colspan="3">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="clear:both;"></div>
    <div class="ttd-area">
        <div>Kota Sungai Penuh, {{ date('d M Y') }}</div>
        <div>Owner Laundry</div>
        <div class="ttd-space"></div>
        <div style="font-weight:bold;text-decoration:underline;">Pak Budiman</div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
