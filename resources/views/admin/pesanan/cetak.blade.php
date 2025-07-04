<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pesanan #{{ $pesanan->nomor_pesanan }}</title>
    <style>
        @media print {
            .no-print { display: none; }
        }
        
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        
        .nota-container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        
        .total-row {
            font-weight: bold;
            font-size: 16px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-selesai { background: #d4edda; color: #155724; }
        .status-proses { background: #fff3cd; color: #856404; }
        .status-dibatalkan { background: #f8d7da; color: #721c24; }
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">
        🖨️ Cetak Nota
    </button>
    
    <div class="nota-container">
        <div class="header">
            <h1>D'CLEAN LAUNDRY</h1>
            <p>Jl. Contoh No. 123, Kota</p>
            <p>Telp: (021) 1234-5678</p>
            <p>Email: info@dcleanlaundry.com</p>
        </div>
        
        <div class="info-section">
            <h3>INFORMASI PESANAN</h3>
            <div class="info-row">
                <span class="info-label">No. Pesanan:</span>
                <span>{{ $pesanan->nomor_pesanan }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal:</span>
                <span>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Estimasi Selesai:</span>
                <span>{{ $pesanan->estimasi_ambil ? \Carbon\Carbon::parse($pesanan->estimasi_ambil)->format('d/m/Y H:i') : '-' }}</span>
            </div>
        </div>
        
        <div class="info-section">
            <h3>DATA PELANGGAN</h3>
            <div class="info-row">
                <span class="info-label">Nama:</span>
                <span>{{ $pesanan->pelanggan->nama }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">No. HP:</span>
                <span>{{ $pesanan->pelanggan->telepon ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat:</span>
                <span>{{ $pesanan->pelanggan->alamat ?? '-' }}</span>
            </div>
        </div>
        
        <div class="info-section">
            <h3>STATUS</h3>
            <div class="info-row">
                <span class="info-label">Status Laundry:</span>
                <span class="status-badge 
                    @if($pesanan->status_laundry == 'selesai') status-selesai
                    @elseif($pesanan->status_laundry == 'dibatalkan') status-dibatalkan
                    @else status-proses
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $pesanan->status_laundry)) }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Pembayaran:</span>
                <span class="status-badge 
                    @if($pesanan->status_pembayaran == 'sudah_bayar') status-selesai
                    @elseif($pesanan->status_pembayaran == 'bayar_sebagian') status-proses
                    @else status-dibatalkan
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $pesanan->status_pembayaran)) }}
                </span>
            </div>
        </div>
        
        <div class="info-section">
            <h3>RINCIAN LAYANAN</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Layanan</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pesanan->detail && count($pesanan->detail))
                        @foreach($pesanan->detail as $detail)
                        <tr>
                            <td>{{ $detail->layanan->nama_layanan ?? '-' }}</td>
                            <td>{{ $detail->kuantitas }}</td>
                            <td>Rp {{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada detail layanan</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <th colspan="3" style="text-align: right;">TOTAL:</th>
                        <th>Rp {{ number_format($pesanan->jumlah_total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        @if($pesanan->catatan)
        <div class="info-section">
            <h3>CATATAN</h3>
            <p style="margin: 0; font-size: 14px;">{{ $pesanan->catatan }}</p>
        </div>
        @endif
        
        <div class="footer">
            <p>Terima kasih telah mempercayakan laundry Anda kepada kami!</p>
            <p>Simpan nota ini sebagai bukti transaksi</p>
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html> 