<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin - Register</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/css/vertical-layout-light/style.css')}}">
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow-x: hidden;
    }

    /* Container & Background */
    .container-scroller {
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      position: relative;
      overflow: hidden;
    }

    /* Animated Background Orbs */
    .container-scroller::before,
    .container-scroller::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      filter: blur(100px);
      opacity: 0.4;
      animation: float 20s infinite ease-in-out;
    }

    .container-scroller::before {
      width: 600px;
      height: 600px;
      background: rgba(59, 130, 246, 0.6);
      top: -300px;
      left: -200px;
    }

    .container-scroller::after {
      width: 500px;
      height: 500px;
      background: rgba(139, 92, 246, 0.6);
      bottom: -200px;
      right: -150px;
      animation-delay: 10s;
    }

    @keyframes float {
      0%, 100% { 
        transform: translate(0, 0) scale(1); 
      }
      33% { 
        transform: translate(50px, -50px) scale(1.1); 
      }
      66% { 
        transform: translate(-30px, 30px) scale(0.95); 
      }
    }

    /* Content Wrapper */
    .page-body-wrapper {
      position: relative;
      z-index: 1;
    }

    .content-wrapper {
      padding: 40px 20px;
      min-height: 100vh;
    }

    /* Auth Card */
    .auth-form-light {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25), 
                  0 0 0 1px rgba(255, 255, 255, 0.1);
      border: none;
      padding: 50px 45px !important;
      position: relative;
      overflow: hidden;
      animation: slideUp 0.6s ease-out;
    }

    /* Top Border Gradient */
    .auth-form-light::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4, #3b82f6);
      background-size: 200% 100%;
      animation: gradient 4s linear infinite;
    }

    @keyframes gradient {
      0% { background-position: 0% 0%; }
      100% { background-position: 200% 0%; }
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(60px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Logo Section */
    .brand-logo {
      text-align: center;
      margin-bottom: 35px;
      animation: slideUp 0.8s ease-out;
    }

    .brand-logo img {
      max-width: 180px;
      height: auto;
      filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
      transition: transform 0.3s ease;
    }

    .brand-logo img:hover {
      transform: scale(1.05);
    }

    /* Headings */
    h4 {
      color: #1e293b;
      font-weight: 700;
      font-size: 28px;
      margin-bottom: 10px;
      text-align: center;
      animation: slideUp 1s ease-out;
      letter-spacing: -0.5px;
    }

    h6 {
      color: #64748b;
      font-weight: 400;
      font-size: 15px;
      text-align: center;
      margin-bottom: 0;
      animation: slideUp 1.2s ease-out;
    }

    .font-weight-light {
      font-weight: 400 !important;
    }

    /* Form */
    .pt-3 {
      padding-top: 2.5rem !important;
    }

    .form-group {
      margin-bottom: 24px;
      position: relative;
      animation: slideUp 1.4s ease-out;
    }

    /* Input Wrapper with Icons */
    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 20px;
      pointer-events: none;
      transition: color 0.3s ease;
      z-index: 2;
    }

    .input-wrapper .form-control {
      padding-left: 55px;
    }

    .input-wrapper .form-control:focus ~ .input-icon {
      color: #3b82f6;
    }

    /* Form Controls */
    .form-control {
      height: 54px;
      border: 2px solid #e2e8f0;
      border-radius: 14px;
      font-size: 15px;
      padding: 16px 20px;
      transition: all 0.3s ease;
      background: #f8fafc;
      color: #1e293b;
    }

    .form-control:focus {
      outline: none;
      border-color: #3b82f6;
      background: #ffffff;
      box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.1);
      transform: translateY(-1px);
    }

    .form-control::placeholder {
      color: #94a3b8;
      font-size: 14px;
    }

    .form-control-lg {
      height: 54px;
    }

    /* Error States */
    .is-invalid {
      border-color: #ef4444;
      background: #fef2f2;
    }

    .invalid-feedback {
      color: #ef4444;
      font-size: 13px;
      margin-top: 8px;
      display: block;
      font-weight: 500;
    }

    /* Buttons */
    .btn-primary {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      border: none;
      border-radius: 14px;
      font-size: 16px;
      font-weight: 600;
      padding: 16px 24px;
      transition: all 0.3s ease;
      box-shadow: 0 6px 16px rgba(59, 130, 246, 0.35);
      text-transform: uppercase;
      letter-spacing: 1px;
      position: relative;
      overflow: hidden;
    }

    .btn-primary::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    .btn-primary:hover::before {
      left: 100%;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(59, 130, 246, 0.45);
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .auth-form-btn {
      height: auto !important;
    }

    /* Checkbox */
    .form-check {
      display: flex;
      align-items: center;
      padding-left: 0;
      animation: slideUp 1.3s ease-out;
    }

    .form-check-input {
      width: 20px;
      height: 20px;
      margin-right: 10px;
      cursor: pointer;
      border: 2px solid #cbd5e1;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .form-check-input:checked {
      background-color: #3b82f6;
      border-color: #3b82f6;
    }

    .form-check-input:focus {
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .form-check-label {
      color: #64748b;
      font-size: 14px;
      cursor: pointer;
      margin: 0;
    }

    /* Links */
    .text-primary {
      color: #3b82f6 !important;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .text-primary:hover {
      color: #2563eb !important;
      text-decoration: none;
    }

    /* Text Center */
    .text-center {
      color: #64748b;
      font-size: 14px;
      animation: slideUp 1.4s ease-out;
    }

    /* Loading State */
    .btn-loading {
      position: relative;
      color: transparent !important;
      pointer-events: none;
    }

    .btn-loading::after {
      content: '';
      position: absolute;
      width: 24px;
      height: 24px;
      top: 50%;
      left: 50%;
      margin-left: -12px;
      margin-top: -12px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: #ffffff;
      animation: spinner 0.8s linear infinite;
    }

    @keyframes spinner {
      to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 576px) {
      .auth-form-light {
        padding: 40px 30px !important;
        border-radius: 20px;
      }

      h4 {
        font-size: 24px;
      }

      h6 {
        font-size: 14px;
      }

      .form-control {
        height: 50px;
        font-size: 14px;
      }

      .brand-logo img {
        max-width: 150px;
      }
    }

    @media (max-width: 400px) {
      .auth-form-light {
        padding: 35px 25px !important;
      }
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{asset('assets/images/logo_healtack.png')}}" alt="logo">
              </div>
              <h4>Selamat Datang!</h4>
              <h6 class="font-weight-light">Daftar hanya membutuhkan beberapa langkah</h6>
              
              <form class="pt-3" method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                
                <div class="form-group">
                  <div class="input-wrapper">
                    <input type="text" 
                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Nama Lengkap" 
                           required 
                           autocomplete="name" 
                           autofocus>
                    <i class="ti-user input-icon"></i>
                  </div>
                  
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                
                <div class="form-group">
                  <div class="input-wrapper">
                    <input type="email" 
                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Alamat Email" 
                           required 
                           autocomplete="email">
                    <i class="ti-email input-icon"></i>
                  </div>
                  
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                
                <div class="form-group">
                  <div class="input-wrapper">
                    <input type="password" 
                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Password" 
                           required 
                           autocomplete="new-password">
                    <i class="ti-lock input-icon"></i>
                  </div>
                  
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                
                <div class="form-group">
                  <div class="input-wrapper">
                    <input type="password" 
                           class="form-control form-control-lg" 
                           id="password-confirm" 
                           name="password_confirmation" 
                           placeholder="Konfirmasi Password" 
                           required 
                           autocomplete="new-password">
                    <i class="ti-lock input-icon"></i>
                  </div>
                </div>
                
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input" name="terms" required>
                      Saya setuju dengan semua Syarat & Ketentuan
                    </label>
                  </div>
                </div>
                
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="submitBtn">
                    DAFTAR
                  </button>
                </div>
                
                <div class="text-center mt-4 font-weight-light">
                  Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Masuk di sini</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- plugins:js -->
  <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('assets/js/off-canvas.js')}}"></script>
  <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('assets/js/template.js')}}"></script>
  <script src="{{asset('assets/js/settings.js')}}"></script>
  <script src="{{asset('assets/js/todolist.js')}}"></script>

  <script>
    const form = document.getElementById('registerForm');
    const btn = document.getElementById('submitBtn');

    form.addEventListener('submit', function() {
      btn.disabled = true;
      btn.classList.add('btn-loading');
    });
  </script>
</body>
</html>