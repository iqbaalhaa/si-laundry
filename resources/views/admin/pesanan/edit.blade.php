@extends('layouts.master')
@section('title', 'Edit Pesanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Pesanan #{{ $pesanan->nomor_pesanan }}</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pesanan.update', $pesanan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Data Pesanan -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Data Pesanan</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Pelanggan</label>
                                <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach($pelanggan as $p)
                                        <option value="{{ $p->id }}" {{ old('pelanggan_id', $pesanan->pelanggan_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }} - {{ $p->telepon }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pelanggan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Pesanan</label>
                                <input type="datetime-local" name="tanggal_pesanan" class="form-control @error('tanggal_pesanan') is-invalid @enderror" 
                                       value="{{ old('tanggal_pesanan', \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('Y-m-d\TH:i')) }}" required>
                                @error('tanggal_pesanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Estimasi Selesai</label>
                                <input type="datetime-local" name="estimasi_ambil" class="form-control @error('estimasi_ambil') is-invalid @enderror" 
                                       value="{{ old('estimasi_ambil', $pesanan->estimasi_ambil ? \Carbon\Carbon::parse($pesanan->estimasi_ambil)->format('Y-m-d\TH:i') : '') }}">
                                @error('estimasi_ambil')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Laundry</label>
                                <select name="status_laundry" class="form-select @error('status_laundry') is-invalid @enderror" required>
                                    <option value="menunggu" {{ old('status_laundry', $pesanan->status_laundry) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="proses_cuci" {{ old('status_laundry', $pesanan->status_laundry) == 'proses_cuci' ? 'selected' : '' }}>Proses Cuci</option>
                                    <option value="proses_pengeringan" {{ old('status_laundry', $pesanan->status_laundry) == 'proses_pengeringan' ? 'selected' : '' }}>Proses Pengeringan</option>
                                    <option value="proses_setrika" {{ old('status_laundry', $pesanan->status_laundry) == 'proses_setrika' ? 'selected' : '' }}>Proses Setrika</option>
                                    <option value="siap_diambil" {{ old('status_laundry', $pesanan->status_laundry) == 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                    <option value="selesai" {{ old('status_laundry', $pesanan->status_laundry) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ old('status_laundry', $pesanan->status_laundry) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status_laundry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Pembayaran</label>
                                <select name="status_pembayaran" class="form-select @error('status_pembayaran') is-invalid @enderror" required>
                                    <option value="belum_bayar" {{ old('status_pembayaran', $pesanan->status_pembayaran) == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                                    <option value="bayar_sebagian" {{ old('status_pembayaran', $pesanan->status_pembayaran) == 'bayar_sebagian' ? 'selected' : '' }}>Bayar Sebagian</option>
                                    <option value="sudah_bayar" {{ old('status_pembayaran', $pesanan->status_pembayaran) == 'sudah_bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                                </select>
                                @error('status_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan', $pesanan->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Detail Layanan -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Detail Layanan</h5>
                            <div id="layanan-container">
                                @if($pesanan->detail && count($pesanan->detail) > 0)
                                    @foreach($pesanan->detail as $index => $detail)
                                    <div class="layanan-item border rounded p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Layanan</label>
                                                <select name="layanan_id[]" class="form-select" required>
                                                    @foreach($layanan as $l)
                                                        <option value="{{ $l->id }}" {{ $detail->layanan_id == $l->id ? 'selected' : '' }}>
                                                            {{ $l->nama_layanan }} - Rp {{ number_format($l->harga_per_satuan, 0, ',', '.') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Kuantitas</label>
                                                <input type="number" name="kuantitas[]" class="form-control kuantitas-input" 
                                                       value="{{ $detail->kuantitas }}" step="0.1" min="0.1" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm d-block w-100 hapus-layanan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="form-label">Catatan Item</label>
                                                <input type="text" name="catatan_item[]" class="form-control" 
                                                       value="{{ $detail->catatan_item }}" placeholder="Catatan khusus untuk item ini">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="layanan-item border rounded p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Layanan</label>
                                                <select name="layanan_id[]" class="form-select" required>
                                                    <option value="">Pilih Layanan</option>
                                                    @foreach($layanan as $l)
                                                        <option value="{{ $l->id }}">
                                                            {{ $l->nama_layanan }} - Rp {{ number_format($l->harga_per_satuan, 0, ',', '.') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Kuantitas</label>
                                                <input type="number" name="kuantitas[]" class="form-control kuantitas-input" 
                                                       step="0.1" min="0.1" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm d-block w-100 hapus-layanan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="form-label">Catatan Item</label>
                                                <input type="text" name="catatan_item[]" class="form-control" 
                                                       placeholder="Catatan khusus untuk item ini">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <button type="button" class="btn btn-success" id="tambah-layanan">
                                <i class="fas fa-plus"></i> Tambah Layanan
                            </button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Pesanan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Tambah layanan baru
    $('#tambah-layanan').click(function() {
        var layananHtml = `
            <div class="layanan-item border rounded p-3 mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Layanan</label>
                        <select name="layanan_id[]" class="form-select" required>
                            <option value="">Pilih Layanan</option>
                            @foreach($layanan as $l)
                                <option value="{{ $l->id }}">
                                    {{ $l->nama_layanan }} - Rp {{ number_format($l->harga_per_satuan, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kuantitas</label>
                        <input type="number" name="kuantitas[]" class="form-control kuantitas-input" 
                               step="0.1" min="0.1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm d-block w-100 hapus-layanan">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <label class="form-label">Catatan Item</label>
                        <input type="text" name="catatan_item[]" class="form-control" 
                               placeholder="Catatan khusus untuk item ini">
                    </div>
                </div>
            </div>
        `;
        $('#layanan-container').append(layananHtml);
    });

    // Hapus layanan
    $(document).on('click', '.hapus-layanan', function() {
        if ($('.layanan-item').length > 1) {
            $(this).closest('.layanan-item').remove();
        } else {
            alert('Minimal harus ada 1 layanan!');
        }
    });
});
</script>
@endpush 