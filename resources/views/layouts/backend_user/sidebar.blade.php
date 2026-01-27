<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    @if(Auth::check() && Auth::user()->role == 'user')
    
    <!-- Dashboard / Isi Profile -->
    <li class="nav-item {{ request()->routeIs('user.dashboard') || request()->routeIs('user.profile*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('user.profile') }}">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Isi Profile</span>
      </a>
    </li>

    {{-- <!-- Konsultasi -->
    <li class="nav-item {{ request()->routeIs('user.konsultasi*') ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#konsultasi" aria-expanded="{{ request()->routeIs('user.konsultasi*') ? 'true' : 'false' }}" aria-controls="konsultasi">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Konsultasi</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('user.konsultasi*') ? 'show' : '' }}" id="konsultasi">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.konsultasi.chat') ? 'active' : '' }}" 
               href="{{ route('user.konsultasi.chat') }}">Chat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.konsultasi.catatan-medis') ? 'active' : '' }}" 
               href="{{ route('user.konsultasi.catatan-medis') }}">Lihat Catatan Medis</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Lihat Obat -->
    <li class="nav-item {{ request()->routeIs('user.obat*') ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#obat" aria-expanded="{{ request()->routeIs('user.obat*') ? 'true' : 'false' }}" aria-controls="obat">
        <i class="fas fa-pills menu-icon"></i>
        <span class="menu-title">Lihat Obat</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('user.obat*') ? 'show' : '' }}" id="obat">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.obat.beli') ? 'active' : '' }}" 
               href="{{ route('user.obat.beli') }}">Beli Obat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.obat.informasi') ? 'active' : '' }}" 
               href="{{ route('user.obat.informasi') }}">Informasi Obat</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Atur Jadwal Minum Obat -->
    <li class="nav-item {{ request()->routeIs('user.jadwal-obat*') ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#jadwalObat" aria-expanded="{{ request()->routeIs('user.jadwal-obat*') ? 'true' : 'false' }}" aria-controls="jadwalObat">
        <i class="icon-calendar menu-icon"></i>
        <span class="menu-title">Atur Jadwal Minum Obat</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->routeIs('user.jadwal-obat*') ? 'show' : '' }}" id="jadwalObat">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.jadwal-obat.tambah') ? 'active' : '' }}" 
               href="{{ route('user.jadwal-obat.tambah') }}">Tambah</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.jadwal-obat.notifikasi') ? 'active' : '' }}" 
               href="{{ route('user.jadwal-obat.notifikasi') }}">Notifikasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.jadwal-obat.edit') ? 'active' : '' }}" 
               href="{{ route('user.jadwal-obat.edit') }}">Edit</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Divider -->
    <li class="nav-item nav-category">
      <span class="nav-link">Pengaturan</span>
    </li> --}}

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
    <!-- Jika bukan user, tampilkan pesan -->
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