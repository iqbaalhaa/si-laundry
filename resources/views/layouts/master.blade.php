<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/extra-libs/c3/c3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/libs/chartist/dist/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/style.min.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Loader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        {{-- Header --}}
        @include('layouts.partials.header')

        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by D'Clean Laundry. 2025 Developed by <a href="#">Kesi</a>.
            </footer>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('template/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('template/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('template/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('template/dist/js/custom.min.js') }}"></script>

    <!-- Optional Dashboard Scripts -->
    <script src="{{ asset('template/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('template/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}">
    </script>
    <script src="{{ asset('template/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('template/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('template/dist/js/pages/dashboards/dashboard1.min.js') }}"></script>

    @stack('scripts')

    <!-- Bootstrap 5 JS Bundle CDN untuk modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
