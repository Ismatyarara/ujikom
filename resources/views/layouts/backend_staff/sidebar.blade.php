<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Penjualan Obat -->
        <li class="nav-item {{ request()->routeIs('staff.penjualan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.penjualan.index') }}">
                <i class="fas fa-cash-register menu-icon"></i>
                <span class="menu-title">Penjualan Obat</span>
            </a>
        </li>

        <!-- Data Pembelian Obat -->
        <li class="nav-item {{ request()->routeIs('staff.pembelian.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.pembelian.index') }}">
                <i class="fas fa-shopping-cart menu-icon"></i>
                <span class="menu-title">Data Pembelian Obat</span>
            </a>
        </li>

        <!-- Barang Masuk -->
        <li class="nav-item {{ request()->routeIs('staff.barang-masuk.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.barang-masuk.index') }}">
                <i class="fas fa-truck-loading menu-icon"></i>
                <span class="menu-title">Barang Masuk</span>
            </a>
        </li>

        <!-- Barang Keluar -->
        <li class="nav-item {{ request()->routeIs('staff.barang-keluar.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.barang-keluar.index') }}">
                <i class="fas fa-box-open menu-icon"></i>
                <span class="menu-title">Barang Keluar</span>
            </a>
        </li>

        <!-- Divider -->
        <li class="nav-item nav-category">
            <span class="nav-link">Pengaturan</span>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                <i class="icon-power menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>
