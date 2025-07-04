<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h4 { margin: 0; }
        .table th, .table td { vertical-align: middle; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h4>LAPORAN TRANSAKSI</h4>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}</p>
    </div>

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

    <script>
        window.print();
    </script>
</body>
</html>
