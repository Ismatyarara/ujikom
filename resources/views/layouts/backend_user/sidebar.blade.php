<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if (Auth::check() && Auth::user()->role == 'user')
            <!-- Dashboard -->
            <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#profile"
                    aria-expanded="{{ request()->routeIs('user.profile*') ? 'true' : 'false' }}"
                    aria-controls="profile">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Profile Saya</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ request()->routeIs('user.profile*') ? 'show' : '' }}" id="profile">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.profile.show') ? 'active' : '' }}"
                                href="{{ route('user.profile.show') }}">
                                Lihat Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.profile.edit') ? 'active' : '' }}"
                                href="{{ route('user.profile.edit') }}">
                                Edit Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Divider -->
            <li class="nav-item nav-category">
                <span class="nav-link">Pengaturan</span>
            </li>

            @if (false)
             
            @else
               <li class="nav-item {{ request()->routeIs('user.konsultasi.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.konsultasi.index') }}">
                    <i class="icon-speech menu-icon"></i>
                    <span class="menu-title">Konsultasi</span>
                </a>
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
        @else
            <!-- Jika bukan user -->
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
