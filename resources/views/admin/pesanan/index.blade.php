@extends('layouts.master')
@section('title', 'Daftar Pesanan')

@section('content')
<h4 class="mb-4">Daftar Pesanan</h4>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<style>
    .pesanan-card {
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.10);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
        border: none;
    }
    .pesanan-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    }
    .pesanan-header {
        background: linear-gradient(90deg, #4e73df 0%, #1cc88a 100%);
        color: #fff;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .pesanan-header .icon {
        font-size: 1.7rem;
        margin-right: 10px;
    }
    .pesanan-status {
        font-size: 0.95rem;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 12px;
    }
    .pesanan-card .card-body {
        background: #f8f9fc;
    }
    .pesanan-card .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .pesanan-card .btn {
        border-radius: 8px;
        font-size: 0.95rem;
        padding: 6px 18px;
    }
    .pesanan-card .btn-warning {
        color: #fff;
        background: linear-gradient(90deg, #f6c23e 0%, #e74a3b 100%);
        border: none;
    }
    .pesanan-card .btn-danger {
        background: linear-gradient(90deg, #e74a3b 0%, #f6c23e 100%);
        border: none;
    }
    .pesanan-card .btn-warning:hover, .pesanan-card .btn-danger:hover {
        opacity: 0.85;
    }
</style>

<div class="row">
    @forelse ($data as $item)
    <div class="col-md-4 mb-4">
        <div class="card pesanan-card h-100">
            <div class="pesanan-header">
                <div class="d-flex align-items-center">
                    <span class="icon"><i class="fas fa-tshirt"></i></span>
                    <span class="fw-bold">#{{ $item->nomor_pesanan }}</span>
                </div>
                <span class="pesanan-status
                    @if($item->status_laundry == 'selesai') bg-success
                    @elseif($item->status_laundry == 'proses_cuci' || $item->status_laundry == 'proses_pengeringan' || $item->status_laundry == 'proses_setrika') bg-warning text-dark
                    @elseif($item->status_laundry == 'dibatalkan') bg-danger
                    @else bg-secondary
                    @endif">
                    <i class="fas
                        @if($item->status_laundry == 'selesai') fa-check-circle
                        @elseif($item->status_laundry == 'dibatalkan') fa-times-circle
                        @else fa-sync-alt
                        @endif"></i>
                    {{ ucfirst(str_replace('_', ' ', $item->status_laundry)) }}
                </span>
            </div>
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-user-circle me-1"></i> {{ $item->pelanggan->nama }}</h5>
                <p class="card-text mb-1"><strong><i class="fas fa-phone-alt me-1"></i> No HP:</strong> {{ $item->pelanggan->telepon ?? '-' }}</p>
                <p class="card-text mb-1"><strong><i class="fas fa-calendar-alt me-1"></i> Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d M Y H:i') }}</p>
                <p class="card-text mb-1"><strong><i class="fas fa-money-bill-wave me-1"></i> Total:</strong> Rp {{ number_format($item->jumlah_total, 0, ',', '.') }}</p>
                <p class="card-text">
                    <strong><i class="fas fa-wallet me-1"></i> Status Pembayaran:</strong>
                    <span class="badge 
                        @if($item->status_pembayaran == 'sudah_bayar') bg-success
                        @elseif($item->status_pembayaran == 'bayar_sebagian') bg-warning text-dark
                        @else bg-danger
                        @endif">
                        <i class="fas
                            @if($item->status_pembayaran == 'sudah_bayar') fa-check
                            @elseif($item->status_pembayaran == 'bayar_sebagian') fa-hourglass-half
                            @else fa-times
                            @endif"></i>
                        {{ ucfirst(str_replace('_', ' ', $item->status_pembayaran)) }}
                    </span>
                </p>
            </div>
            <div class="card-footer d-flex justify-content-between bg-white border-0">
                <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                    <i class="fas fa-eye me-1"></i> Detail
                </button>
                <button type="button" class="btn btn-success me-2" onclick="cetakNota({{ $item->id }})">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
                <form action="{{ route('pesanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Pesanan #{{ $item->nomor_pesanan }}</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row mb-2">
              <div class="col-md-6">
                <p><strong>Nama Pelanggan:</strong> {{ $item->pelanggan->nama }}</p>
                <p><strong>No HP:</strong> {{ $item->pelanggan->telepon ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $item->pelanggan->alamat ?? '-' }}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Tanggal Pesanan:</strong> {{ \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d M Y H:i') }}</p>
                <p><strong>Status Laundry:</strong>
                  <form class="form-update-status-laundry d-inline" data-id="{{ $item->id }}">
                    <select name="status_laundry" class="form-select form-select-sm d-inline w-auto status-laundry-select" style="display:inline-block;">
                      <option value="proses_cuci" @if($item->status_laundry=='proses_cuci') selected @endif>Proses Cuci</option>
                      <option value="proses_pengeringan" @if($item->status_laundry=='proses_pengeringan') selected @endif>Proses Pengeringan</option>
                      <option value="proses_setrika" @if($item->status_laundry=='proses_setrika') selected @endif>Proses Setrika</option>
                      <option value="selesai" @if($item->status_laundry=='selesai') selected @endif>Selesai</option>
                      <option value="dibatalkan" @if($item->status_laundry=='dibatalkan') selected @endif>Dibatalkan</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary ms-2 btn-update-status">Simpan</button>
                  </form>
                </p>
                <p><strong>Status Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $item->status_pembayaran)) }}</p>
              </div>
            </div>
            <hr>
            <h6>Rincian Layanan:</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th>Layanan</th>
                    <th>Qty (kg)</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  @if($item->detail && count($item->detail))
                      @foreach($item->detail as $detail)
                      <tr>
                        <td>{{ $detail->layanan->nama_layanan ?? '-' }}</td>
                        <td>{{ $detail->kuantitas }}</td>
                        <td>Rp {{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                      </tr>
                      @endforeach
                  @else
                      <tr><td colspan="4" class="text-center">Tidak ada detail layanan</td></tr>
                  @endif
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th>Rp {{ number_format($item->jumlah_total, 0, ',', '.') }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('pesanan.edit', $item->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit Pesanan
            </a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">Belum ada pesanan</div>
    </div>
    @endforelse
</div>
@endsection

@push('styles')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
@endpush

@push('scripts')
<script>
// Fungsi untuk cetak nota
function cetakNota(pesananId) {
    window.open('/admin/pesanan/' + pesananId + '/cetak', '_blank');
}

$(document).on('submit', '.form-update-status-laundry', function(e) {
    e.preventDefault();
    var form = $(this);
    var id = form.data('id');
    var status = form.find('select[name="status_laundry"]').val();
    var btn = form.find('.btn-update-status');
    btn.prop('disabled', true).text('Menyimpan...');
    
    $.ajax({
        url: '/admin/pesanan/' + id + '/update-status-laundry',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status_laundry: status
        },
        success: function(res) {
            btn.prop('disabled', false).text('Simpan');
            
            // Update badge status di card
            var card = form.closest('.modal').closest('.col-md-4').find('.pesanan-status');
            var statusText = status.replace(/_/g, ' ');
            statusText = statusText.charAt(0).toUpperCase() + statusText.slice(1);
            
            // Update text
            card.text(statusText);
            
            // Update warna badge
            card.removeClass('bg-success bg-warning bg-danger bg-secondary text-dark');
            if (status == 'selesai') {
                card.addClass('bg-success');
            } else if (status == 'proses_cuci' || status == 'proses_pengeringan' || status == 'proses_setrika') {
                card.addClass('bg-warning text-dark');
            } else if (status == 'dibatalkan') {
                card.addClass('bg-danger');
            } else {
                card.addClass('bg-secondary');
            }
            
            // Update icon
            var icon = card.find('i');
            icon.removeClass('fa-check-circle fa-times-circle fa-sync-alt');
            if (status == 'selesai') {
                icon.addClass('fa-check-circle');
            } else if (status == 'dibatalkan') {
                icon.addClass('fa-times-circle');
            } else {
                icon.addClass('fa-sync-alt');
            }
            
            // Tampilkan notifikasi
            alert('Status laundry berhasil diupdate!');
        },
        error: function() {
            btn.prop('disabled', false).text('Simpan');
            alert('Gagal update status!');
        }
    });
});
</script>
@endpush
