@extends('layouts.master')

@section('title', 'Pengaturan')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Pengaturan</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Pengaturan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="w-100" style="max-width: 1000px;">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profil-tab" data-toggle="tab" href="#profil" role="tab" aria-controls="profil" aria-selected="true">
                                <i class="ti-user mr-2"></i>Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">
                                <i class="ti-email mr-2"></i>Email
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="ti-lock mr-2"></i>Password
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Tab Profil -->
                        <div class="tab-pane fade show active" id="profil" role="tabpanel" aria-labelledby="profil-tab">
                            <div class="row mt-4">
                                <div class="col-md-8">
                                    <form action="{{ route('pengaturan.profil') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                                   id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="foto">Foto Profil</label>
                                            <input type="file" class="form-control-file @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email_display">Email</label>
                                            <input type="email" class="form-control" id="email_display" 
                                                   value="{{ $user->email }}" readonly>
                                            <small class="form-text text-muted">Untuk mengubah email, gunakan tab Email di atas.</small>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-save mr-2"></i>Simpan Perubahan
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="profile-pic-wrapper">
                                        <img src="{{ $user->foto ? asset('image/'.$user->foto) : asset('template/assets/images/users/profile-pic.jpg') }}" 
                                             alt="Profile Picture" class="rounded-circle" width="150" height="150">
                                        <div class="mt-3">
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="ti-camera mr-1"></i>Ganti Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Email -->
                        <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                            <div class="row mt-4">
                                <div class="col-md-8">
                                    <form action="{{ route('pengaturan.email') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="email">Email Baru</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password_email">Password Saat Ini</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password_email" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Masukkan password Anda untuk mengkonfirmasi perubahan email.</small>
                                        </div>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="ti-email mr-2"></i>Update Email
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-info">
                                        <h6><i class="ti-info-alt mr-2"></i>Informasi</h6>
                                        <p class="mb-0">Untuk mengubah email, Anda harus memasukkan password saat ini sebagai verifikasi keamanan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Password -->
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <div class="row mt-4">
                                <div class="col-md-8">
                                    <form action="{{ route('pengaturan.password') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="current_password">Password Saat Ini</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                   id="current_password" name="current_password" required>
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">Password Baru</label>
                                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                                   id="new_password" name="new_password" required>
                                            @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" 
                                                   id="new_password_confirmation" name="new_password_confirmation" required>
                                        </div>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="ti-lock mr-2"></i>Update Password
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-warning">
                                        <h6><i class="ti-alert mr-2"></i>Peringatan</h6>
                                        <ul class="mb-0 pl-3">
                                            <li>Password minimal 8 karakter</li>
                                            <li>Gunakan kombinasi huruf dan angka</li>
                                            <li>Simpan password baru Anda dengan aman</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.profile-pic-wrapper {
    padding: 20px;
    border: 2px dashed #e9ecef;
    border-radius: 10px;
    background-color: #f8f9fa;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    border-bottom: 2px solid #007bff;
    color: #007bff;
    background: none;
}

.tab-content {
    padding: 20px 0;
}
</style>
@endsection 