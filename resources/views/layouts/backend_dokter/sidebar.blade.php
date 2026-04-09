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
                <li class="nav-item {{ request()->routeIs('dokter.konsultasi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.konsultasi.index') }}">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title"> Konsultasi User</span>
                    </a>
                </li>

                <!-- Catatan Medis -->
                <li class="nav-item {{ request()->routeIs('dokter.catatan.index', 'dokter.catatan.create', 'dokter.catatan.store', 'dokter.catatan.show', 'dokter.catatan.edit', 'dokter.catatan.update', 'dokter.catatan.destroy') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.catatan.index') }}">
                        <i class="icon-paper menu-icon"></i>
                        <span class="menu-title">Buat Catatan Medis</span>
                    </a>
                </li>

                <!-- Data Obat -->
                <li class="nav-item {{ request()->routeIs('dokter.data-obat.index', 'dokter.data-obat.show') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.data-obat.index') }}">
                        <i class="icon-bag menu-icon"></i>
                        <span class="menu-title">Data Obat</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('dokter.jadwal.index', 'dokter.jadwal.create', 'dokter.jadwal.store', 'dokter.jadwal.show', 'dokter.jadwal.edit', 'dokter.jadwal.update', 'dokter.jadwal.destroy', 'dokter.jadwal.waktu.create', 'dokter.jadwal.waktu.store', 'dokter.jadwal.waktu.destroy', 'dokter.dokter.jadwal.show') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dokter.jadwal.index') }}">
                        <i class="fas fa-calendar-alt menu-icon"></i>
                        <span class="menu-title">Jadwal Obat</span>
                    </a>
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
