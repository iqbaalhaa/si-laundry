@extends('layouts.master')
@section('title', 'Tambah Pesanan')

@section('content')
<h4 class="mb-4">Tambah Pesanan Baru</h4>

<form action="{{ route('pesanan.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Pelanggan</label>
        <select name="pelanggan_id" class="form-control" required>
            <option value="">-- Pilih Pelanggan --</option>
            @foreach ($pelanggan as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->no_hp }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Tanggal Pesanan</label>
        <input type="datetime-local" name="tanggal_pesanan" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
    </div>

    <div class="mb-3">
        <label>Estimasi Ambil</label>
        <input type="datetime-local" name="estimasi_ambil" class="form-control">
    </div>

    <h5>Layanan</h5>
    <div id="layanan-container">
        <div class="row mb-2 layanan-item">
            <div class="col-md-4">
                <select name="layanan_id[]" class="form-control" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach ($layanan as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_layanan }} (Rp {{ number_format($l->harga_per_satuan, 0, ',', '.') }}/{{ $l->satuan }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="kuantitas[]" class="form-control" placeholder="Kuantitas" step="0.1" min="0.1" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="catatan_item[]" class="form-control" placeholder="Catatan (opsional)">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-layanan">&times;</button>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-success btn-sm" id="add-layanan">+ Tambah Layanan</button>

    <div class="mb-3 mt-4">
        <label>Status Pembayaran</label>
        <select name="status_pembayaran" class="form-control" required>
            <option value="belum_bayar">Belum Bayar</option>
            <option value="sudah_bayar">Sudah Bayar</option>
            <option value="bayar_sebagian">Bayar Sebagian</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Status Laundry</label>
        <select name="status_laundry" class="form-control" required id="status-laundry-select">
            <option value="menunggu">Menunggu</option>
            <option value="proses_cuci">Proses Cuci</option>
            <option value="proses_pengeringan">Proses Pengeringan</option>
            <option value="proses_setrika">Proses Setrika</option>
            <option value="siap_diambil">Siap Diambil</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Catatan Pesanan</label>
        <textarea name="catatan" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
    document.getElementById('add-layanan').addEventListener('click', function () {
        let container = document.querySelector('#layanan-container');
        let item = container.querySelector('.layanan-item').cloneNode(true);
        item.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(item);
        updateStatusLaundryOptions();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-layanan')) {
            e.target.closest('.layanan-item').remove();
            updateStatusLaundryOptions();
        }
    });

    // --- STATUS LAUNDRY DINAMIS ---
    // Mapping status sesuai layanan
    const statusMap = {
        'cuci': [
            {value: 'menunggu', label: 'Menunggu'},
            {value: 'proses_cuci', label: 'Proses Cuci'},
            {value: 'proses_pengeringan', label: 'Proses Pengeringan'},
            {value: 'siap_diambil', label: 'Siap Diambil'},
            {value: 'selesai', label: 'Selesai'},
            {value: 'dibatalkan', label: 'Dibatalkan'},
        ],
        'setrika': [
            {value: 'menunggu', label: 'Menunggu'},
            {value: 'proses_setrika', label: 'Proses Setrika'},
            {value: 'siap_diambil', label: 'Siap Diambil'},
            {value: 'selesai', label: 'Selesai'},
            {value: 'dibatalkan', label: 'Dibatalkan'},
        ],
        'cuci_setrika': [
            {value: 'menunggu', label: 'Menunggu'},
            {value: 'proses_cuci', label: 'Proses Cuci'},
            {value: 'proses_pengeringan', label: 'Proses Pengeringan'},
            {value: 'proses_setrika', label: 'Proses Setrika'},
            {value: 'siap_diambil', label: 'Siap Diambil'},
            {value: 'selesai', label: 'Selesai'},
            {value: 'dibatalkan', label: 'Dibatalkan'},
        ]
    };

    // Ambil nama layanan dari select option
    function getSelectedLayananNames() {
        let selects = document.querySelectorAll('select[name="layanan_id[]"]');
        let names = [];
        selects.forEach(sel => {
            let selected = sel.options[sel.selectedIndex];
            if (selected && selected.text) {
                let nama = selected.text.toLowerCase();
                if (nama.includes('cuci') && !names.includes('cuci')) names.push('cuci');
                if (nama.includes('setrika') && !names.includes('setrika')) names.push('setrika');
            }
        });
        return names;
    }

    function updateStatusLaundryOptions() {
        let layanan = getSelectedLayananNames();
        let statusList = statusMap['cuci_setrika']; // default
        if (layanan.length === 1 && layanan[0] === 'cuci') statusList = statusMap['cuci'];
        else if (layanan.length === 1 && layanan[0] === 'setrika') statusList = statusMap['setrika'];
        else if (layanan.length === 2 && layanan.includes('cuci') && layanan.includes('setrika')) statusList = statusMap['cuci_setrika'];
        // Bisa tambah kombinasi lain di sini

        let select = document.getElementById('status-laundry-select');
        let current = select.value;
        select.innerHTML = '';
        statusList.forEach(opt => {
            let option = document.createElement('option');
            option.value = opt.value;
            option.textContent = opt.label;
            if (opt.value === current) option.selected = true;
            select.appendChild(option);
        });
    }

    // Trigger update saat layanan dipilih/diubah
    document.addEventListener('change', function(e) {
        if (e.target.matches('select[name="layanan_id[]"]')) {
            updateStatusLaundryOptions();
        }
    });
    // Inisialisasi awal
    updateStatusLaundryOptions();
</script>
@endsection
