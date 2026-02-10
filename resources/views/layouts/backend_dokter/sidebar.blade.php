<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    @auth
    @if(auth()->user()->role === 'dokter')

    <li class="nav-item {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.dashboard') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    {{-- Menu Chat/Konsultasi --}}
    <li class="nav-item {{ request()->is('chat*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/chat') }}">
        <i class="icon-bubble menu-icon"></i>
        <span class="menu-title">Pesan Konsultasi</span>
        {{-- Badge notifikasi unread (opsional) --}}
        <span class="badge badge-danger badge-pill ml-auto" id="unread-count" style="display: none;">0</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('dokter.konsultasi*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.konsultasi.index') }}">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Daftar Pasien</span>
      </a>
    </li>

    @endif
    @endauth

    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="icon-power menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </li>

  </ul>
</nav>