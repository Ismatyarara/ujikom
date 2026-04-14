<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

  {{-- Logo --}}
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="{{ route('dokter.dashboard') }}">
      <i class="fas fa-hospital text-primary"></i>
      <span class="font-weight-bold">HealTack</span>
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{ route('dokter.dashboard') }}">
      <i class="fas fa-hospital text-primary"></i>
    </a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

    <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>

    <ul class="navbar-nav navbar-nav-right">
      {{-- Profile Dokter --}}
      @auth
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            @php
              $avatarDokter = auth()->user()->avatar;
            @endphp
            @if($avatarDokter)
              <img src="{{ $avatarDokter }}"
                   alt="profile"
                   onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';" />
              <span style="width:38px;height:38px;border-radius:50%;display:none;align-items:center;justify-content:center;background:#e0e7ff;color:#3730a3;font-weight:700;">
                {{ auth()->user()->initials }}
              </span>
            @else
              <span style="width:38px;height:38px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#e0e7ff;color:#3730a3;font-weight:700;">
                {{ auth()->user()->initials }}
              </span>
            @endif
          </a>

          <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
            <div class="dropdown-header text-center">
              <p class="mb-1 mt-3 font-weight-semibold">{{ auth()->user()->name }}</p>
              <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
              <p class="text-primary mb-0"><small>Dokter</small></p>
            </div>

            <a class="dropdown-item" href="{{ route(config('chatify.routes.prefix')) }}">
              <i class="ti-comment text-primary"></i> Pesan Konsultasi
            </a>

            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="ti-power-off text-danger"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
      @endauth

    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
            type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>

  </div>
</nav>
