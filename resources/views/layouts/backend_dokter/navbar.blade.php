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
      
      {{-- Notifikasi Pesan Baru --}}
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown">
          <i class="icon-envelope mx-0"></i>
          @php
            $unreadCount = \App\Models\ChMessage::where('to_id', auth()->id())->where('seen', 0)->count();
          @endphp
          @if($unreadCount > 0)
            <span class="count">{{ $unreadCount }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Pesan Baru ({{ $unreadCount }})</p>
          
          @if($unreadCount > 0)
            @php
              $recentUnread = \App\Models\ChMessage::where('to_id', auth()->id())
                ->where('seen', 0)
                ->with('sender')
                ->latest()
                ->take(3)
                ->get();
            @endphp
            
            @foreach($recentUnread as $msg)
              <a class="dropdown-item preview-item" href="{{ url('/chat/' . $msg->from_id) }}">
                <div class="preview-thumbnail">
                  <img src="{{ $msg->sender->avatar ?? asset('assets/images/faces/face1.jpg') }}" 
                       class="rounded-circle" 
                       alt="image">
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">{{ $msg->sender->name }}</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    {{ Str::limit($msg->body, 40) }}
                  </p>
                </div>
              </a>
            @endforeach
            
            <a class="dropdown-item text-center" href="{{ url('/chat') }}">
              Lihat Semua Pesan
            </a>
          @else
            <div class="dropdown-item text-center text-muted">
              Tidak ada pesan baru
            </div>
          @endif
        </div>
      </li>
      
      {{-- Profile --}}
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="{{ auth()->user()->avatar ?? asset('assets/images/faces/face28.jpg') }}" alt="profile"/>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <div class="dropdown-header text-center">
            <p class="mb-1 mt-3 font-weight-semibold">{{ auth()->user()->name }}</p>
            <p class="font-weight-light text-muted mb-0">{{ auth()->user()->email }}</p>
            <p class="font-weight-light text-muted mb-0"><small>Dokter</small></p>
          </div>
          <a class="dropdown-item" href="{{ url('/chat') }}">
            <i class="ti-comment text-primary"></i>
            Pesan
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