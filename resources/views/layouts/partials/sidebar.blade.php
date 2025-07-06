<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/admin/dashboard') }}">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Data Master</span></li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pelanggan.index') }}">
                        <i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">Pelanggan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('layanan.index') }}">
                        <i data-feather="tag" class="feather-icon"></i>
                        <span class="hide-menu">Layanan</span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Transaksi</span></li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pesanan.index') }}">
                        <i data-feather="shopping-cart" class="feather-icon"></i>
                        <span class="hide-menu">Pesanan</span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Laporan</span></li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporan.index') }}">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">Laporan</span>
                    </a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Pengaturan</span></li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pengaturan.index') }}">
                        <i data-feather="settings" class="feather-icon"></i>
                        <span class="hide-menu">Pengaturan</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <li class="sidebar-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-link btn btn-link text-left">
                            <i data-feather="log-out" class="feather-icon"></i>
                            <span class="hide-menu">Logout</span>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
