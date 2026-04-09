<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Spesialisasi -->
        <li class="nav-item {{ request()->routeIs('admin.spesialisasi.index', 'admin.spesialisasi.create', 'admin.spesialisasi.store', 'admin.spesialisasi.show', 'admin.spesialisasi.edit', 'admin.spesialisasi.update', 'admin.spesialisasi.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.spesialisasi.index') }}">
                <i class="fas fa-stethoscope menu-icon"></i>
                <span class="menu-title">Data Spesialisasi</span>
            </a>
        </li>

        <!-- Dokter -->
        <li class="nav-item {{ request()->routeIs('admin.dokter.index', 'admin.dokter.create', 'admin.dokter.store', 'admin.dokter.show', 'admin.dokter.edit', 'admin.dokter.update', 'admin.dokter.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dokter.index') }}">
                <i class="fas fa-user-md menu-icon"></i>
                <span class="menu-title">Data Dokter</span>
            </a>
        </li>

        <!-- Staff -->
        <li class="nav-item {{ request()->routeIs('admin.staff.index', 'admin.staff.create', 'admin.staff.store', 'admin.staff.show', 'admin.staff.edit', 'admin.staff.update', 'admin.staff.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.staff.index') }}">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Data Staff</span>
            </a>
        </li>

        <!-- Obat -->
        <li class="nav-item {{ request()->routeIs('admin.obat.index', 'admin.obat.create', 'admin.obat.store', 'admin.obat.show', 'admin.obat.edit', 'admin.obat.update', 'admin.obat.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.obat.index') }}">
                <i class="fas fa-pills menu-icon"></i>
                <span class="menu-title">Data Obat</span>
            </a>
        </li>

        <!-- Monitoring Pembelian -->
        <li class="nav-item {{ request()->routeIs('admin.obat.pembelian*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.obat.pembelian') }}">
                <i class="fas fa-shopping-cart menu-icon"></i>
                <span class="menu-title">Monitoring Pembelian</span>
            </a>
        </li>

        <!-- Users -->
        <li class="nav-item {{ request()->routeIs('admin.users.index', 'admin.users.create', 'admin.users.store', 'admin.users.show', 'admin.users.edit', 'admin.users.update', 'admin.users.destroy') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Data User</span>
            </a>
        </li>

        <!-- Divider -->
        <li class="nav-item nav-category">
            <span class="nav-link">Settings</span>
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
