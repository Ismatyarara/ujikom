{{-- resources/views/layouts/dokter/navbar.blade.php --}}
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
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
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    
    <ul class="navbar-nav navbar-nav-right">
      <!-- Notifications -->
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="icon-bell mx-0"></i>
          <span class="count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="ti-info-alt mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Konsultasi Baru</h6>
              <p class="font-weight-light small-text mb-0 text-muted">
                Just now
              </p>
            </div>
          </a>
        </div>
      </li>
      
      <!-- Profile -->
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="{{ Auth::user()->dokter->foto ?? asset('assets/images/faces/face28.jpg') }}" alt="profile"/>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <div class="dropdown-header text-center">
            <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
            <p class="font-weight-light text-muted mb-0">{{ Auth::user()->email }}</p>
            @if(Auth::user()->dokter && Auth::user()->dokter->spesialisasi)
              <p class="font-weight-light text-muted mb-0">
                <span class="badge badge-primary">{{ Auth::user()->dokter->spesialisasi->name }}</span>
              </p>
            @endif
          </div>
          <a class="dropdown-item" href="{{ route('dokter.profile') }}">
            <i class="ti-user text-primary"></i>
            My Profile
          </a>
          <a class="dropdown-item" href="{{ route('dokter.settings') }}">
            <i class="ti-settings text-primary"></i>
            Settings
          </a>
          <a class="dropdown-item" href="{{ route('logout') }}" 
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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