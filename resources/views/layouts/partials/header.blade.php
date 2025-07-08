<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <div class="navbar-brand">
                <a href="{{ url('/admin/dashboard') }}">
                    <b class="logo-icon">
                        <img src="{{ asset('template/assets/images/big/logodclean.png') }}" alt="homepage"
                            class="dark-logo" />
                        <img src="{{ asset('template/assets/images/big/logodclean.png') }}" alt="homepage"
                            class="light-logo" />
                    </b>
                    <span class="logo-title ml-2" style="
                        font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
                        font-weight: 700;
                        font-size: 1.5rem;
                        background: linear-gradient(90deg, #222 40%, #007bff 100%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                        text-fill-color: transparent;
                        letter-spacing: 1px;
                        ">D'Clean</span>
                </a>
            </div>
            <a class="topbartoggler d-block d-md-none" href="javascript:void(0)" data-toggle="collapse"
                data-target="#navbarSupportedContent">
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#"
                        data-toggle="dropdown">
                        <img src="{{ Auth::user()->foto ? asset('image/' . Auth::user()->foto) : asset('template/assets/images/users/profile-pic.jpg') }}" alt="user"
                            class="rounded-circle" width="40">
                        <span class="ml-2 d-none d-lg-inline-block">Hi, {{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('pengaturan.index') }}"><i data-feather="settings"
                                class="svg-icon mr-2 ml-1"></i> Pengaturan</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"><i data-feather="power"
                                    class="svg-icon mr-2 ml-1"></i> Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
