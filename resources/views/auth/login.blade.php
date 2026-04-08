<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - HealTack</title>

  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo_healtack.png') }}"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      background: #0C1D3B;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      overflow-x: hidden;
      overflow-y: auto;
      position: relative;
    }
    body::before {
      content: '';
      position: fixed;
      top: -200px; right: -200px;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(26,86,219,.22) 0%, transparent 65%);
      border-radius: 50%;
      animation: glow 6s ease-in-out infinite;
    }
    body::after {
      content: '';
      position: fixed;
      bottom: -180px; left: -180px;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(26,86,219,.14) 0%, transparent 65%);
      border-radius: 50%;
      animation: glow 6s ease-in-out infinite reverse;
    }
    @keyframes glow {
      0%,100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.08); opacity: .6; }
    }

    .login-card {
      background: #fff;
      border-radius: 22px;
      padding: 44px 42px;
      width: 100%;
      max-width: 440px;
      position: relative;
      z-index: 2;
      box-shadow: 0 24px 64px rgba(0,0,0,.35);
      animation: slideUp .55s ease-out;
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .login-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, #1A56DB, #60A5FA, #1A56DB);
      background-size: 200% 100%;
      border-radius: 22px 22px 0 0;
      animation: bar 3s linear infinite;
    }
    @keyframes bar {
      from { background-position: 0% 0%; }
      to { background-position: 200% 0%; }
    }

    .logo-wrap {
      display: flex; align-items: center; justify-content: center;
      gap: 10px; text-decoration: none; margin-bottom: 28px;
    }
    .logo-icon { width: 42px; height: 42px; }
    .logo-icon img { width: 42px; height: 42px; object-fit: contain; }
    .logo-text { font-size: 24px; font-weight: 800; color: #0C1D3B; letter-spacing: -.5px; }
    .logo-text span { color: #1A56DB; }

    .card-title { text-align: center; font-size: 22px; font-weight: 800; color: #0C1D3B; margin-bottom: 4px; }
    .card-sub { text-align: center; font-size: 14px; color: #64748B; margin-bottom: 28px; }

    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 22px 0; color: #94A3B8; font-size: 12px; font-weight: 600;
    }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #E2E8F0; }

    .btn-google {
      display: flex; align-items: center; justify-content: center; gap: 10px;
      width: 100%; padding: 13px 16px;
      border: 1.5px solid #E2E8F0; border-radius: 12px;
      background: #fff; color: #1E293B;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px; font-weight: 600;
      text-decoration: none; cursor: pointer; transition: all .2s;
      position: relative;
    }
    .btn-google:hover { border-color: #BFDBFE; background: #EBF2FF; color: #1A56DB; }
    .btn-google svg { flex-shrink: 0; }
    .otp-badge {
      position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
      background: #EBF2FF; color: #1A56DB;
      font-size: 10px; font-weight: 700; letter-spacing: .4px;
      padding: 2px 7px; border-radius: 20px;
      border: 1px solid #BFDBFE;
    }

    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .input-wrap { position: relative; }
    .input-icon {
      position: absolute; left: 15px; top: 50%;
      transform: translateY(-50%);
      color: #94A3B8; font-size: 17px; pointer-events: none;
    }
    .form-control {
      width: 100%; height: 50px;
      padding: 0 16px 0 46px;
      border: 1.5px solid #E2E8F0; border-radius: 12px;
      background: #F8FAFC;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px; color: #1E293B;
      transition: all .2s; outline: none;
    }
    .form-control:focus {
      border-color: #1A56DB; background: #EBF2FF;
      box-shadow: 0 0 0 4px rgba(26,86,219,.1);
    }
    .form-control.is-invalid { border-color: #EF4444; background: #FEF2F2; }
    .invalid-feedback { font-size: 12px; color: #EF4444; margin-top: 5px; }

    .form-row-extra {
      display: flex; align-items: center; justify-content: space-between;
      font-size: 13px; margin-bottom: 22px;
    }
    .form-row-extra label { display: flex; align-items: center; gap: 7px; color: #64748B; cursor: pointer; }
    .form-row-extra input[type="checkbox"] { accent-color: #1A56DB; width: 15px; height: 15px; }
    .form-row-extra a { color: #1A56DB; text-decoration: none; font-weight: 600; }
    .form-row-extra a:hover { text-decoration: underline; }

    .btn-submit {
      width: 100%; padding: 14px;
      background: #1A56DB; color: #fff;
      border: none; border-radius: 12px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px; font-weight: 700;
      cursor: pointer; transition: all .25s; position: relative;
    }
    .btn-submit:hover { background: #1040AA; transform: translateY(-2px); box-shadow: 0 10px 24px rgba(26,86,219,.35); }
    .btn-submit:disabled { pointer-events: none; color: transparent; }
    .btn-submit:disabled::after {
      content: '';
      width: 22px; height: 22px;
      border: 3px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%;
      position: absolute; top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      animation: spin .7s linear infinite;
    }
    @keyframes spin { to { transform: translate(-50%,-50%) rotate(360deg); } }

    .card-footer-text { text-align: center; font-size: 13.5px; color: #64748B; margin-top: 22px; }
    .card-footer-text a { color: #1A56DB; font-weight: 700; text-decoration: none; }
    .card-footer-text a:hover { text-decoration: underline; }

    .alert-error {
      background: #FEF2F2; border: 1px solid #FECACA;
      border-radius: 10px; padding: 12px 16px;
      font-size: 13px; color: #B91C1C; margin-bottom: 18px;
    }
    .alert-warning {
      background: #FFFBEB; border: 1px solid #FDE68A;
      border-radius: 10px; padding: 12px 16px;
      font-size: 13px; color: #92400E; margin-bottom: 18px;
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 34px 22px;
        border-radius: 18px;
      }

      .card-title { font-size: 20px; }
      .card-sub { font-size: 13px; }
    }
  </style>
</head>
<body>

  <div class="login-card">

    <a href="/" class="logo-wrap">
      <div class="logo-icon">
        <img src="{{ asset('frontend/assets/img/logo_healtack.png') }}" alt="HealTack">
      </div>
      <div class="logo-text">Heal<span>Tack</span></div>
    </a>

    <div class="card-title">Selamat Datang Kembali!</div>
    <div class="card-sub">Masuk untuk melanjutkan ke dashboard</div>

    @if (session('error'))
      <div class="alert-error">{{ session('error') }}</div>
    @endif
    @if (session('warning'))
      <div class="alert-warning">{{ session('warning') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
      @csrf

      <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <div class="input-wrap">
          <i class="ti-email input-icon"></i>
          <input type="email" id="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="nama@email.com"
            value="{{ old('email') }}"
            required autofocus>
        </div>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <i class="ti-lock input-icon"></i>
          <input type="password" id="password" name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Masukkan password"
            required>
        </div>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-row-extra">
        <label>
          <input type="checkbox" name="remember"> Ingat Saya
        </label>
        <a href="{{ route('password.request') }}">Lupa Password?</a>
      </div>

      <button type="submit" id="submitBtn" class="btn-submit">Masuk</button>
    </form>

    <div class="divider">atau masuk dengan</div>

    <a href="{{ route('auth.google') }}" class="btn-google">
      <svg width="20" height="20" viewBox="0 0 48 48">
        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
        <path fill="none" d="M0 0h48v48H0z"/>
      </svg>
      Lanjutkan dengan Google
      <span class="otp-badge">+ OTP</span>
    </a>

    <div class="card-footer-text">
      Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
    </div>

  </div>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script>
    document.getElementById('loginForm').addEventListener('submit', function () {
      document.getElementById('submitBtn').disabled = true;
    });
  </script>
</body>
</html>
