<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if(Auth::check() && Auth::user()->role == 'staff')
        
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('staff.pembelian.index', 'staff.pembelian.show') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.pembelian.index') }}">
                <i class="fas fa-receipt menu-icon"></i>
                <span class="menu-title">Pesanan User</span>
            </a>
        </li>

        <!-- Barang Masuk -->
        <li class="nav-item {{ request()->routeIs('staff.barang-masuk.index', 'staff.barang-masuk.create', 'staff.barang-masuk.store', 'staff.barang-masuk.show', 'staff.barang-masuk.edit', 'staff.barang-masuk.update', 'staff.barang-masuk.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.barang-masuk.index') }}">
                <i class="fas fa-truck-loading menu-icon"></i>
                <span class="menu-title">Barang Masuk</span>
            </a>
        </li>

        <!-- Barang Keluar -->
        <li class="nav-item {{ request()->routeIs('staff.barang-keluar.index', 'staff.barang-keluar.create', 'staff.barang-keluar.store', 'staff.barang-keluar.show', 'staff.barang-keluar.edit', 'staff.barang-keluar.update', 'staff.barang-keluar.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.barang-keluar.index') }}">
                <i class="fas fa-box-open menu-icon"></i>
                <span class="menu-title">Barang Keluar</span>
            </a>
        </li>

        <!-- Obat -->
        <li class="nav-item {{ request()->routeIs('staff.obat.index', 'staff.obat.create', 'staff.obat.store', 'staff.obat.show', 'staff.obat.edit', 'staff.obat.update', 'staff.obat.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('staff.obat.index') }}">
                <i class="fas fa-pills menu-icon"></i>
                <span class="menu-title">Mengelola Obat</span>
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

        @else
        <!-- Jika bukan staff, tampilkan pesan -->
        <li class="nav-item">
            <div class="nav-link text-center">
                <div class="alert alert-warning m-3">
                    <i class="icon-ban menu-icon"></i>
                    <p class="mb-0">Akses Terbatas</p>
                    <small>Anda tidak memiliki akses ke menu ini</small>
                </div>
            </div>
        </li>
        @endif
    </ul>
</nav>
