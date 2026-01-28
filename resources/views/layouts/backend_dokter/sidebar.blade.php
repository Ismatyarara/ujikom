<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    @auth
    @if(auth()->user()->role === 'dokter')

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.dashboard') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    {{-- <!-- Konsultasi -->
    <li class="nav-item {{ request()->routeIs('dokter.konsultasi*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dokter.konsultasi.index') }}">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Konsultasi</span>
      </a>
    </li> --}}

    @endif
    @endauth

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
