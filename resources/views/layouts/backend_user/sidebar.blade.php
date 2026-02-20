<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @auth
            @if (Auth::user()->role == 'user')

                <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

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

                @php
                    $user = Auth::user();
                    $isProfileComplete =
                        $user->profile && empty($user->profile->phone) && empty($user->profile->address);
                @endphp

                @if ($isProfileComplete)
                    <li class="nav-item {{ request()->routeIs('user.konsultasi*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.konsultasi.index') }}">
                            <i class="fas fa-comment-medical menu-icon"></i>
                            <span class="menu-title">Konsultasi</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('user.catatan*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.catatan.index') }}">
                            <i class="fas fa-file-medical-alt menu-icon"></i>
                            <span class="menu-title">Catatan Medis</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item {{ request()->routeIs('user.jadwal*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.jadwal.index') }}">
                        <i class="icon-clock menu-icon"></i>
                        <span class="menu-title">Jadwal Obat</span>
                    </a>
                </li>

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
        @else
            <li class="nav-item">
                <div class="nav-link text-center">
                    <div class="alert alert-info m-3">
                        <i class="icon-lock menu-icon"></i>
                        <p class="mb-0">Silakan Login</p>
                        <small>Anda harus login untuk mengakses menu</small>
                    </div>
                </div>
            </li>
        @endauth
    </ul>
</nav>