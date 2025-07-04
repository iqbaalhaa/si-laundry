<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SI Laundry</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/assets/images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            overflow: hidden;
        }

        .login-image {
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            min-height: 550px;
            height: 200px;
            /* Membatasi tinggi agar tidak terlalu tinggi dan space bawah tidak kosong */
        }

        .login-image img {
            max-width: 98%;
            max-height: 450px;
            margin: auto;
            display: block;
        }

        .brand-logo {
            width: 120px;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #60a5fa 0%, #6366f1 100%);
        }

        .btn-warning {
            background: linear-gradient(90deg, #fbbf24 0%, #f59e42 100%);
            border: none;
            color: #fff;
        }

        .btn-warning:hover {
            background: linear-gradient(90deg, #f59e42 0%, #fbbf24 100%);
            color: #fff;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
        }

        .alert {
            border-radius: 0.75rem;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card login-card shadow-lg w-100" style="max-width: 900px;">
            <div class="row g-0">
                <div class="col-md-6 login-image d-none d-md-flex">
                    <img src="{{ asset('template/assets/images/big/laundry.png') }}" alt="Laundry" />
                </div>
                <div class="col-md-6 bg-white p-5 d-flex flex-column justify-content-center">
                    <div class="text-center">
                        <img src="{{ asset('template/assets/images/big/logodclean.png') }}" alt="Logo"
                            class="brand-logo">
                        <h2 class="mb-2 fw-bold" style="color:#6366f1;">SI Laundry</h2>
                        <p class="mb-4 text-muted">Masukkan Email dan Password</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" name="email" type="email" 
                                   value="{{ old('email') }}"
                                   placeholder="Masukkan email anda">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" name="password" type="password"
                                   placeholder="Masukkan password anda">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Login</button>
                    </form>
                    <a href="{{ route('cek-status.index') }}" class="btn btn-warning btn-lg w-100">Cek Status
                        Laundry</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('template/assets/libs/jquery/dist/jquery.min.js') }} "></script>
    <script src="{{ asset('template/assets/libs/popper.js/dist/umd/popper.min.js') }} "></script>
    <script src="{{ asset('template/assets/libs/bootstrap/dist/js/bootstrap.min.js') }} "></script>
    <script>
        $(".preloader ").fadeOut();
    </script>
</body>

</html>
