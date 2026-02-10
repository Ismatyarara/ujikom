<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin - Login</title>

  <!-- Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo_healtack.png') }}"/>

  <!-- Custom Style -->
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

    /* =============================
       Container & Background
    ============================== */
    .container-scroller {
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      position: relative;
      overflow: hidden;
    }

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
      0%, 100% { transform: translate(0, 0) scale(1); }
      33% { transform: translate(50px, -50px) scale(1.1); }
      66% { transform: translate(-30px, 30px) scale(0.95); }
    }

    /* =============================
       Auth Card
    ============================== */
    .auth-form-light {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      padding: 50px 45px !important;
      box-shadow: 0 20px 60px rgba(0,0,0,.25);
      animation: slideUp .6s ease-out;
      position: relative;
      overflow: hidden;
    }

    .auth-form-light::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg,#3b82f6,#8b5cf6,#06b6d4,#3b82f6);
      background-size: 200% 100%;
      animation: gradient 4s linear infinite;
    }

    @keyframes gradient {
      from { background-position: 0% 0%; }
      to { background-position: 200% 0%; }
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(60px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* =============================
       Logo & Heading
    ============================== */
    .brand-logo {
      text-align: center;
      margin-bottom: 35px;
    }

    .brand-logo img {
      max-width: 180px;
      transition: transform .3s ease;
    }

    .brand-logo img:hover {
      transform: scale(1.05);
    }

    h4 {
      text-align: center;
      font-size: 28px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 10px;
    }

    h6 {
      text-align: center;
      font-size: 15px;
      color: #64748b;
      font-weight: 400;
    }

    /* =============================
       Form
    ============================== */
    .form-group {
      margin-bottom: 24px;
    }

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
    }

    .form-control {
      height: 54px;
      padding-left: 55px;
      border-radius: 14px;
      border: 2px solid #e2e8f0;
      background: #f8fafc;
    }

    .form-control:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 5px rgba(59,130,246,.1);
    }

    .is-invalid {
      border-color: #ef4444;
      background: #fef2f2;
    }

    .invalid-feedback {
      font-size: 13px;
      color: #ef4444;
      margin-top: 6px;
    }

    /* =============================
       Button
    ============================== */
    .btn-primary {
      background: linear-gradient(135deg,#3b82f6,#2563eb);
      border-radius: 14px;
      padding: 16px;
      font-weight: 600;
      box-shadow: 0 6px 16px rgba(59,130,246,.35);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg,#2563eb,#1d4ed8);
    }

    .btn-loading {
      pointer-events: none;
      color: transparent !important;
      position: relative;
    }

    .btn-loading::after {
      content: '';
      width: 24px;
      height: 24px;
      border: 3px solid rgba(255,255,255,.3);
      border-top-color: #fff;
      border-radius: 50%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      animation: spinner .8s linear infinite;
    }

    @keyframes spinner {
      to { transform: rotate(360deg); }
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">

            <div class="auth-form-light">
              <div class="brand-logo">
                <img src="{{ asset('assets/images/logo_healtack.png') }}" alt="Healtack">
              </div>

              <h4>Selamat Datang Kembali!</h4>
              <h6 class="font-weight-light">Masuk untuk melanjutkan ke dashboard</h6>

              <form method="POST" action="{{ route('login') }}" class="pt-3" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="form-group">
                  <div class="input-wrapper">
                    <input
                      type="email"
                      name="email"
                      class="form-control @error('email') is-invalid @enderror"
                      placeholder="Alamat Email"
                      value="{{ old('email') }}"
                      required
                      autofocus
                    >
                    <i class="ti-email input-icon"></i>
                  </div>
                  @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                  <div class="input-wrapper">
                    <input
                      type="password"
                      name="password"
                      class="form-control @error('password') is-invalid @enderror"
                      placeholder="Password"
                      required
                    >
                    <i class="ti-lock input-icon"></i>
                  </div>
                  @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="d-flex justify-content-between my-2">
                  <label class="form-check-label">
                    <input type="checkbox" name="remember"> Ingat Saya
                  </label>

                  <a href="{{ route('password.request') }}">Lupa Password?</a>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary btn-block mt-3">
                  Masuk
                </button>

                <div class="text-center mt-4">
                  Belum punya akun?
                  <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

  <script>
    document.getElementById('loginForm').addEventListener('submit', function () {
      const btn = document.getElementById('submitBtn');
      btn.classList.add('btn-loading');
      btn.disabled = true;
    });
  </script>
</body>
</html>
