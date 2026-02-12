<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @auth
            @if (Auth::user()->role == 'dokter')
                <!-- Dashboard -->
                <li class="nav-item {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.dashboard') }}">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <!-- Daftar Pasien -->
                <li class="nav-item {{ request()->routeIs('dokter.konsultasi*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.konsultasi.index') }}">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title"> Konsultasi User</span>
                    </a>
                </li>

                <!-- Catatan Medis -->
                <li class="nav-item {{ request()->routeIs('dokter.catatan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.catatan.index') }}">
                        <i class="icon-paper menu-icon"></i>
                        <span class="menu-title">Buat Catatan Medis</span>
                    </a>
                </li>

                <!-- Data Obat -->
                <li class="nav-item {{ request()->routeIs('dokter.data-obat*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.data-obat.index') }}">
                        <i class="icon-bag menu-icon"></i>
                        <span class="menu-title">Data Obat</span>
                    </a>
                </li>

                <li class="nav-item nav-category">
                    <span class="nav-link">Akun</span>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-power menu-icon text-danger"></i>
                        <span class="menu-title text-danger">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endif
        @endauth
    </ul>
</nav>
