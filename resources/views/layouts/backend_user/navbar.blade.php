<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="{{ route('user.dashboard') }}">
      <i class="fas fa-hospital text-primary"></i>
      <span class="font-weight-bold">HealTack</span>
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{ route('user.dashboard') }}">
      <i class="fas fa-hospital text-primary"></i>
    </a>
  </div>
  
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          @if(Auth::user()->profile && Auth::user()->profile->foto)
            <img src="{{ asset('storage/'.Auth::user()->profile->foto) }}" alt="profile"/>
          @else
            <span style="width:38px;height:38px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#e0e7ff;color:#3730a3;font-weight:700;">
              {{ Auth::user()->initials }}
            </span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <div class="dropdown-header text-center">
            @if(Auth::user()->profile)
              <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->profile->nama_panjang }}</p>
            @else
              <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
            @endif
            <p class="font-weight-light text-muted mb-0">{{ Auth::user()->email }}</p>
            <p class="font-weight-light text-muted mb-0"><small>Pasien</small></p>
          </div>
          
          @if(Auth::user()->profile)
            <a class="dropdown-item" href="{{ route('user.profile.show') }}">
              <i class="ti-user text-primary"></i>
              Profil Saya
            </a>
            <a class="dropdown-item" href="{{ route('user.profile.edit') }}">
              <i class="ti-settings text-primary"></i>
              Edit Profil
            </a>
          @else
            <a class="dropdown-item" href="{{ route('user.profile.create') }}">
              <i class="ti-user text-warning"></i>
              Lengkapi Profil
            </a>
          @endif
          
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="ti-power-off text-primary"></i>
            Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
    </ul>
    
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>
