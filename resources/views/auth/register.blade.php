<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register — HealTack</title>

  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo_healtack.png') }}">
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
      padding: 40px 16px;
      overflow-x: hidden;
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
      50%      { transform: scale(1.08); opacity: .6; }
    }

    .register-card {
      background: #fff;
      border-radius: 22px;
      padding: 44px 42px;
      width: 100%;
      max-width: 480px;
      position: relative;
      z-index: 2;
      box-shadow: 0 24px 64px rgba(0,0,0,.35);
      animation: slideUp .55s ease-out;
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(40px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .register-card::before {
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
      to   { background-position: 200% 0%; }
    }

    .logo-wrap {
      display: flex; align-items: center; justify-content: center;
      gap: 10px; text-decoration: none; margin-bottom: 26px;
    }
    .logo-icon {
      width: 40px; height: 40px;
      border-radius: 11px; overflow: hidden;
      flex-shrink: 0;
    }
    .logo-icon img { width: 100%; height: 100%; object-fit: contain; }
    .logo-text { font-size: 24px; font-weight: 800; color: #0C1D3B; letter-spacing: -.5px; }
    .logo-text span { color: #1A56DB; }

    .card-title { text-align: center; font-size: 21px; font-weight: 800; color: #0C1D3B; margin-bottom: 4px; }
    .card-sub   { text-align: center; font-size: 13.5px; color: #64748B; margin-bottom: 26px; }

    .form-group { margin-bottom: 16px; }
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
      border-color: #1A56DB;
      background: #EBF2FF;
      box-shadow: 0 0 0 4px rgba(26,86,219,.1);
    }
    .form-control.is-invalid { border-color: #EF4444; background: #FEF2F2; }
    .invalid-feedback { font-size: 12px; color: #EF4444; margin-top: 5px; display: block; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    .terms-wrap {
      display: flex; align-items: flex-start; gap: 10px;
      margin: 18px 0;
    }
    .terms-wrap input[type="checkbox"] {
      accent-color: #1A56DB;
      width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px;
    }
    .terms-wrap label { font-size: 13px; color: #64748B; cursor: pointer; line-height: 1.5; }
    .terms-wrap a { color: #1A56DB; font-weight: 600; text-decoration: none; }
    .terms-wrap a:hover { text-decoration: underline; }

    .btn-submit {
      width: 100%; padding: 14px;
      background: #1A56DB; color: #fff;
      border: none; border-radius: 12px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px; font-weight: 700;
      cursor: pointer; transition: all .25s; position: relative;
    }
    .btn-submit:hover {
      background: #1040AA; transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(26,86,219,.35);
    }
    .btn-submit:disabled { pointer-events: none; color: transparent; }
    .btn-submit:disabled::after {
      content: '';
      width: 22px; height: 22px;
      border: 3px solid rgba(255,255,255,.3);
      border-top-color: #fff; border-radius: 50%;
      position: absolute; top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      animation: spin .7s linear infinite;
    }
    @keyframes spin { to { transform: translate(-50%,-50%) rotate(360deg); } }

    .card-footer-text {
      text-align: center; font-size: 13.5px; color: #64748B; margin-top: 20px;
    }
    .card-footer-text a { color: #1A56DB; font-weight: 700; text-decoration: none; }
    .card-footer-text a:hover { text-decoration: underline; }

    @media (max-width: 480px) {
      .register-card { padding: 36px 24px; }
      .form-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <div class="register-card">

    <a href="{{ url('/') }}" class="logo-wrap">
      <div class="logo-icon">
        <img src="{{ asset('frontend/assets/img/logo_healtack.png') }}" alt="HealTack">
      </div>
      <div class="logo-text">Heal<span>Tack</span></div>
    </a>

    <div class="card-title">Buat Akun Baru</div>
    <div class="card-sub">Daftar hanya membutuhkan beberapa langkah</div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
      @csrf

      <div class="form-group">
        <label class="form-label" for="name">Nama Lengkap</label>
        <div class="input-wrap">
          <i class="ti-user input-icon"></i>
          <input type="text" id="name" name="name"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Nama lengkap kamu"
            value="{{ old('name') }}"
            required autocomplete="name" autofocus>
        </div>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <div class="input-wrap">
          <i class="ti-email input-icon"></i>
          <input type="email" id="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="nama@email.com"
            value="{{ old('email') }}"
            required autocomplete="email">
        </div>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <div class="input-wrap">
            <i class="ti-lock input-icon"></i>
            <input type="password" id="password" name="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="••••••••"
              required autocomplete="new-password">
          </div>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="password-confirm">Konfirmasi</label>
          <div class="input-wrap">
            <i class="ti-lock input-icon"></i>
            <input type="password" id="password-confirm" name="password_confirmation"
              class="form-control"
              placeholder="••••••••"
              required autocomplete="new-password">
          </div>
        </div>
      </div>

      <div class="terms-wrap">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">
          Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a> HealTack
        </label>
      </div>

      <button type="submit" id="submitBtn" class="btn-submit">Daftar Sekarang</button>
    </form>

    <div class="card-footer-text">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>

  </div>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script>
    document.getElementById('registerForm').addEventListener('submit', function () {
      document.getElementById('submitBtn').disabled = true;
    });
  </script>
</body>
</html>