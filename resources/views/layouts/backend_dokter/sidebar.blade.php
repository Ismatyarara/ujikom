<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    @if(Auth::check() && Auth::user()->role == 'dokter')
    
    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.dashboard') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    {{-- <!-- Jadwal Praktik -->
    <li class="nav-item {{ request()->routeIs('dokter.jadwal*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.jadwal') }}">
        <i class="icon-calendar menu-icon"></i>
        <span class="menu-title">Jadwal Praktik</span>
      </a>
    </li>

    <!-- Konsultasi -->
    <li class="nav-item {{ request()->routeIs('dokter.konsultasi*') ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#konsultasi" aria-expanded="{{ request()->routeIs('dokter.konsultasi*') ? 'true' : 'false' }}" aria-controls="konsultasi">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Konsultasi</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('dokter.konsultasi*') ? 'show' : '' }}" id="konsultasi">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.konsultasi.hari-ini') ? 'active' : '' }}" 
               href="{{ route('dokter.konsultasi.hari-ini') }}">Hari Ini</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.konsultasi.antrian') ? 'active' : '' }}" 
               href="{{ route('dokter.konsultasi.antrian') }}">Antrian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.konsultasi.riwayat') ? 'active' : '' }}" 
               href="{{ route('dokter.konsultasi.riwayat') }}">Riwayat</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Rekam Medis -->
    <li class="nav-item {{ request()->routeIs('dokter.rekam-medis*') ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#rekamMedis" aria-expanded="{{ request()->routeIs('dokter.rekam-medis*') ? 'true' : 'false' }}" aria-controls="rekamMedis">
        <i class="icon-book menu-icon"></i>
        <span class="menu-title">Rekam Medis</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('dokter.rekam-medis*') ? 'show' : '' }}" id="rekamMedis">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.rekam-medis.create') ? 'active' : '' }}" 
               href="{{ route('dokter.rekam-medis.create') }}">Buat Catatan Medis</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.rekam-medis.index') ? 'active' : '' }}" 
               href="{{ route('dokter.rekam-medis.index') }}">Semua Rekam Medis</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Lihat Data Obat -->
    <li class="nav-item {{ request()->routeIs('dokter.obat*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.obat.index') }}">
        <i class="icon-doc menu-icon"></i>
        <span class="menu-title">Lihat Data Obat</span>
      </a>
    </li>

    <!-- Laporan -->
    <li class="nav-item {{ request()->routeIs('dokter.laporan*') ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#laporan" aria-expanded="{{ request()->routeIs('dokter.laporan*') ? 'true' : 'false' }}" aria-controls="laporan">
        <i class="icon-bar-graph menu-icon"></i>
        <span class="menu-title">Laporan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('dokter.laporan*') ? 'show' : '' }}" id="laporan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.laporan.harian') ? 'active' : '' }}" 
               href="{{ route('dokter.laporan.harian') }}">Laporan Harian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.laporan.bulanan') ? 'active' : '' }}" 
               href="{{ route('dokter.laporan.bulanan') }}">Laporan Bulanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dokter.laporan.statistik') ? 'active' : '' }}" 
               href="{{ route('dokter.laporan.statistik') }}">Statistik Pasien</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Profil -->
    <li class="nav-item {{ request()->routeIs('dokter.profile') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.profile') }}">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Profil Saya</span>
      </a>
    </li> --}}

    @else
    <!-- Jika bukan dokter, tampilkan pesan -->
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