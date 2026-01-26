{{-- resources/views/layouts/dokter/sidebar.blade.php --}}
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dokter.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        
        <!-- Jadwal Praktik -->
        <li class="nav-item {{ request()->routeIs('dokter.jadwal.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dokter.jadwal.index') }}">
                <i class="icon-calendar menu-icon"></i>
                <span class="menu-title">Jadwal Praktik</span>
            </a>
        </li>

        <!-- Data Pasien -->
        <li class="nav-item {{ request()->routeIs('dokter.pasien.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dokter.pasien.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Data Pasien</span>
            </a>
        </li>

        <!-- Konsultasi -->
        <li class="nav-item {{ request()->routeIs('dokter.konsultasi.*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#konsultasi" aria-expanded="{{ request()->routeIs('dokter.konsultasi.*') ? 'true' : 'false' }}" aria-controls="konsultasi">
                <i class="fas fa-comments menu-icon"></i>
                <span class="menu-title">Konsultasi</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('dokter.konsultasi.*') ? 'show' : '' }}" id="konsultasi">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.konsultasi.index') ? 'active' : '' }}" 
                           href="{{ route('dokter.konsultasi.index') }}">Semua Konsultasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.konsultasi.pending') ? 'active' : '' }}" 
                           href="{{ route('dokter.konsultasi.pending') }}">Menunggu Approval</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.konsultasi.upcoming') ? 'active' : '' }}" 
                           href="{{ route('dokter.konsultasi.upcoming') }}">Jadwal Mendatang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dokter.konsultasi.history') ? 'active' : '' }}" 
                           href="{{ route('dokter.konsultasi.history') }}">Riwayat</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Catatan Medis -->
        <li class="nav-item {{ request()->routeIs('dokter.catatan-medis.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dokter.catatan-medis.index') }}">
                <i class="icon-book menu-icon"></i>
                <span class="menu-title">Catatan Medis</span>
            </a>
        </li>

        <!-- Data Obat -->
        <li class="nav-item {{ request()->routeIs('dokter.obat.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dokter.obat.index') }}">
                <i class="fas fa-pills menu-icon"></i>
                <span class="menu-title">Data Obat</span>
            </a>
        </li>

        <!-- Chat/Pesan -->
        <li class="nav-item {{ request()->routeIs('dokter.chat.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dokter.chat.index') }}">
                <i class="icon-speech menu-icon"></i>
                <span class="menu-title">Pesan</span>
                <span class="badge badge-danger badge-pill ml-auto">3</span>
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