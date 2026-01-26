<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'HealTack')</title>

  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">

  <!-- plugin css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/js/select.dataTables.min.css') }}">

  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  
  @stack('styles')
  @yield('css')
</head>

<body>
<div class="container-scroller">

  {{-- NAVBAR --}}
  @if (auth()->check())
    @if (auth()->user()->role === 'admin')
      @include('layouts.backend.navbar')
    @elseif (auth()->user()->role === 'dokter')
      @include('layouts.backend_dokter.navbar')
    @elseif (auth()->user()->role === 'staff')
      @include('layouts.backend_staff.navbar')
    @elseif (auth()->user()->role === 'user')
      @include('layouts.backend_user.navbar')
    @endif
  @endif

  <div class="container-fluid page-body-wrapper">

    {{-- SIDEBAR --}}
    @if (auth()->check())
      @if (auth()->user()->role === 'admin')
        @include('layouts.backend.sidebar')
      @elseif (auth()->user()->role === 'dokter')
        @include('layouts.backend_dokter.sidebar')
      @elseif (auth()->user()->role === 'staff')
        @include('layouts.backend_staff.sidebar')
      @elseif (auth()->user()->role === 'user')
        @include('layouts.backend_user.sidebar')
      @endif
    @endif

    {{-- CONTENT --}}
    <div class="main-panel">
      <div class="content-wrapper">
        
        {{-- Alert Messages --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-check-circle"></i> Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-circle"></i> Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle"></i> Whoops!</strong> There were some problems with your input.
            <ul class="mb-0 mt-2">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @yield('content')
      </div>
      
      {{-- FOOTER --}}
      <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
            Copyright © {{ date('Y') }} <a href="#" target="_blank">HealTack</a>. All rights reserved.
          </span>
        </div>
      </footer>
    </div>

  </div>
</div>

<!-- JS -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/todolist.js') }}"></script>

<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>

@stack('scripts')
@yield('js')
</body>
</html>


