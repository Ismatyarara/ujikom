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

      {{-- 🔔 Notifikasi Pesan Chatify --}}
      @php
        $unread = \App\Models\ChMessage::where('to_id', auth()->id())
                    ->where('seen', 0)
                    ->count();
      @endphp

      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle"
           href="#"
           data-toggle="dropdown">

          <i class="icon-bell mx-0"></i>

          @if($unread > 0)
            <span class="count bg-danger text-white">
              {{ $unread }}
            </span>
          @endif
        </a>

        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list">
          <p class="dropdown-header">Pesan Baru</p>

          @php
            $recentMessages = \App\Models\ChMessage::where('to_id', auth()->id())
                                ->where('seen', 0)
                                ->with('sender')
                                ->latest()
                                ->take(3)
                                ->get();
          @endphp

          @forelse($recentMessages as $msg)
            <a class="dropdown-item preview-item"
               href="{{ url('chatify/' . $msg->from_id) }}">

              <div class="preview-thumbnail">
                <img src="{{ $msg->sender->avatar ?? asset('assets/images/faces/face1.jpg') }}"
                     class="rounded-circle"
                     width="40"
                     height="40">
              </div>

              <div class="preview-item-content">
                <h6 class="preview-subject">
                  {{ $msg->sender->name }}
                </h6>
                <p class="small text-muted mb-0">
                  {{ \Illuminate\Support\Str::limit($msg->body, 35) }}
                </p>
              </div>
            </a>
          @empty
            <div class="dropdown-item text-center text-muted">
              Tidak ada pesan baru
            </div>
          @endforelse

          @if($unread > 0)
            <a class="dropdown-item text-center"
               href="{{ url('chatify') }}">
              Lihat Semua Pesan
            </a>
          @endif
        </div>
      </li>

      {{-- 👨‍⚕️ Profile Dokter --}}
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle"
           href="#"
           data-toggle="dropdown">

          <img src="{{ auth()->user()->avatar ?? asset('assets/images/faces/face28.jpg') }}"
               alt="profile"/>
        </a>

        <div class="dropdown-menu dropdown-menu-right navbar-dropdown">

          <div class="dropdown-header text-center">
            <p class="mb-1 mt-3 font-weight-semibold">
              {{ auth()->user()->name }}
            </p>
            <p class="text-muted mb-0">
              {{ auth()->user()->email }}
            </p>
            <p class="text-primary mb-0">
              <small>Dokter</small>
            </p>
          </div>

          <a class="dropdown-item" href="{{ url('chatify') }}">
            <i class="ti-comment text-primary"></i>
            Pesan Konsultasi
          </a>

          {{-- Kalau nanti ada profil dokter --}}
          {{-- 
          <a class="dropdown-item" href="{{ route('dokter.profile.show') }}">
            <i class="ti-user text-primary"></i>
            Profil Saya
          </a>
          --}}

          <a class="dropdown-item"
             href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="ti-power-off text-danger"></i>
            Logout
          </a>

          <form id="logout-form"
                action="{{ route('logout') }}"
                method="POST"
                class="d-none">
            @csrf
          </form>

        </div>
      </li>

    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
            type="button"
            data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>

  </div>
</nav>
