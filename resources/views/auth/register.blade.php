<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register - HealTack</title>

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
      position: fixed; top: -200px; right: -200px;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(26,86,219,.22) 0%, transparent 65%);
      border-radius: 50%;
      animation: glow 6s ease-in-out infinite;
    }
    body::after {
      content: '';
      position: fixed; bottom: -180px; left: -180px;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(26,86,219,.14) 0%, transparent 65%);
      border-radius: 50%;
      animation: glow 6s ease-in-out infinite reverse;
    }
    @keyframes glow {
      0%,100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.08); opacity: .6; }
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
      to { opacity: 1; transform: translateY(0); }
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
      to { background-position: 200% 0%; }
    }

    .step-indicator {
      display: flex; align-items: center; justify-content: center;
      gap: 0; margin-bottom: 28px;
    }
    .step-dot {
      width: 32px; height: 32px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 700;
      transition: all .3s;
      position: relative; z-index: 1;
    }
    .step-dot.active { background: #1A56DB; color: #fff; box-shadow: 0 0 0 4px rgba(26,86,219,.15); }
    .step-dot.done { background: #22C55E; color: #fff; }
    .step-dot.inactive { background: #E2E8F0; color: #94A3B8; }
    .step-line {
      flex: 1; height: 2px; max-width: 60px;
      background: #E2E8F0; position: relative;
      overflow: hidden;
    }
    .step-line.done::after {
      content: ''; position: absolute; inset: 0;
      background: #22C55E;
      animation: fillLine .4s ease forwards;
    }
    @keyframes fillLine { from { width: 0; } to { width: 100%; } }

    .logo-wrap {
      display: flex; align-items: center; justify-content: center;
      gap: 10px; text-decoration: none; margin-bottom: 26px;
    }
    .logo-icon { width: 40px; height: 40px; border-radius: 11px; overflow: hidden; flex-shrink: 0; }
    .logo-icon img { width: 100%; height: 100%; object-fit: contain; }
    .logo-text { font-size: 24px; font-weight: 800; color: #0C1D3B; letter-spacing: -.5px; }
    .logo-text span { color: #1A56DB; }

    .card-title { text-align: center; font-size: 21px; font-weight: 800; color: #0C1D3B; margin-bottom: 4px; }
    .card-sub { text-align: center; font-size: 13.5px; color: #64748B; margin-bottom: 26px; }

    .panel { display: none; }
    .panel.active {
      display: block;
      animation: fadeIn .35s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

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
    .form-control:focus { border-color: #1A56DB; background: #EBF2FF; box-shadow: 0 0 0 4px rgba(26,86,219,.1); }
    .form-control.is-invalid { border-color: #EF4444; background: #FEF2F2; }
    .invalid-feedback { font-size: 12px; color: #EF4444; margin-top: 5px; display: block; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    .terms-wrap { display: flex; align-items: flex-start; gap: 10px; margin: 18px 0; }
    .terms-wrap input[type="checkbox"] { accent-color: #1A56DB; width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px; }
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

    .shield-wrap { display: flex; justify-content: center; margin-bottom: 16px; }
    .shield-icon {
      width: 64px; height: 64px;
      background: linear-gradient(135deg, #EBF2FF, #DBEAFE);
      border-radius: 18px;
      display: flex; align-items: center; justify-content: center;
      animation: pulse-shield 2.5s ease-in-out infinite;
    }
    @keyframes pulse-shield {
      0%,100% { box-shadow: 0 0 0 0 rgba(26,86,219,.2); }
      50% { box-shadow: 0 0 0 12px rgba(26,86,219,0); }
    }
    .shield-icon svg { width: 32px; height: 32px; }

    .email-badge {
      display: block; text-align: center;
      background: #EBF2FF; color: #1A56DB;
      font-size: 13px; font-weight: 700;
      padding: 4px 12px; border-radius: 20px;
      margin: 0 auto 22px auto;
    }

    .otp-inputs { display: flex; gap: 10px; justify-content: center; margin-bottom: 22px; }
    .otp-box {
      width: 50px; height: 58px;
      border: 2px solid #E2E8F0; border-radius: 13px;
      background: #F8FAFC;
      text-align: center;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 22px; font-weight: 800; color: #0C1D3B;
      outline: none; transition: all .2s;
      caret-color: #1A56DB;
      -moz-appearance: textfield;
    }
    .otp-box::-webkit-outer-spin-button,
    .otp-box::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .otp-box:focus { border-color: #1A56DB; background: #EBF2FF; box-shadow: 0 0 0 4px rgba(26,86,219,.12); transform: translateY(-2px); }
    .otp-box.filled { border-color: #1A56DB; background: #EBF2FF; }
    .otp-box.error { border-color: #EF4444; background: #FEF2F2; animation: shake .35s ease; }
    @keyframes shake {
      0%,100% { transform: translateX(0); }
      20% { transform: translateX(-5px); }
      60% { transform: translateX(5px); }
    }

    .resend-wrap { text-align: center; margin-top: 16px; font-size: 13.5px; color: #64748B; }
    .resend-btn {
      background: none; border: none; padding: 0;
      color: #1A56DB; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px;
      cursor: pointer; transition: opacity .2s;
    }
    .resend-btn:disabled { color: #94A3B8; cursor: not-allowed; }
    .resend-btn:not(:disabled):hover { text-decoration: underline; }
    .timer { font-weight: 700; color: #1A56DB; font-variant-numeric: tabular-nums; }

    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 18px 0; color: #94A3B8; font-size: 12px; font-weight: 600;
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
      position: relative; margin-bottom: 4px;
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

    .card-footer-text { text-align: center; font-size: 13.5px; color: #64748B; margin-top: 20px; }
    .card-footer-text a { color: #1A56DB; font-weight: 700; text-decoration: none; }
    .card-footer-text a:hover { text-decoration: underline; }

    .alert-error { background: #FEF2F2; border: 1px solid #FECACA; border-radius: 10px; padding: 12px 16px; font-size: 13px; color: #B91C1C; margin-bottom: 18px; }

    @media (max-width: 480px) {
      .register-card { padding: 36px 24px; }
      .form-row { grid-template-columns: 1fr; }
      .otp-box { width: 42px; height: 52px; font-size: 18px; }
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

    <div class="step-indicator" id="stepIndicator">
      <div class="step-dot active" id="dot1">1</div>
      <div class="step-line" id="line1"></div>
      <div class="step-dot inactive" id="dot2">2</div>
    </div>

    <div class="card-title" id="cardTitle">Buat Akun Baru</div>
    <div class="card-sub" id="cardSub">Daftar lalu lanjutkan verifikasi email</div>

    <div class="panel active" id="panel1">
      @if ($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
      @endif

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
                placeholder="Buat password"
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
                placeholder="Ulangi password"
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

      <div class="divider">atau daftar dengan</div>

      <a href="{{ route('auth.google') }}" class="btn-google">
        <svg width="20" height="20" viewBox="0 0 48 48">
          <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
          <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
          <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
          <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
          <path fill="none" d="M0 0h48v48H0z"/>
        </svg>
        Daftar dengan Google
      </a>

      <div class="card-footer-text">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
      </div>
    </div>

    <div class="panel" id="panel2">
      <div class="shield-wrap">
        <div class="shield-icon">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M12 2L4 6v6c0 4.97 3.37 9.63 8 11 4.63-1.37 8-6.03 8-11V6l-8-4z" fill="#1A56DB" opacity=".15"/>
            <path d="M12 2L4 6v6c0 4.97 3.37 9.63 8 11 4.63-1.37 8-6.03 8-11V6l-8-4z" stroke="#1A56DB" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M9 12l2 2 4-4" stroke="#1A56DB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <span class="email-badge" id="otpEmailBadge">{{ old('email') ?? session('otp_email') ?? '' }}</span>

      @if (session('error'))
        <div class="alert-error">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
        @csrf
        <input type="hidden" name="otp" id="otpHidden">

        <div class="otp-inputs">
          <input class="otp-box" type="number" maxlength="1" data-idx="0" inputmode="numeric" autocomplete="one-time-code">
          <input class="otp-box" type="number" maxlength="1" data-idx="1" inputmode="numeric">
          <input class="otp-box" type="number" maxlength="1" data-idx="2" inputmode="numeric">
          <input class="otp-box" type="number" maxlength="1" data-idx="3" inputmode="numeric">
          <input class="otp-box" type="number" maxlength="1" data-idx="4" inputmode="numeric">
          <input class="otp-box" type="number" maxlength="1" data-idx="5" inputmode="numeric">
        </div>

        <button type="submit" id="otpSubmitBtn" class="btn-submit">Verifikasi & Selesai</button>
      </form>

      <div class="resend-wrap">
        Tidak menerima kode?
        <form method="POST" action="{{ route('otp.resend') }}" style="display:inline;">
          @csrf
          <button type="submit" class="resend-btn" id="resendBtn" disabled>
            Kirim Ulang (<span class="timer" id="timerDisplay">60</span>s)
          </button>
        </form>
      </div>
    </div>

  </div>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script>
    const showOtp = @json(session('show_otp', false));
    const otpEmail = @json(session('otp_email', old('email', '')));

    if (showOtp) {
      switchToOtp(otpEmail);
    }

    function switchToOtp(email) {
      document.getElementById('panel1').classList.remove('active');
      document.getElementById('panel2').classList.add('active');

      document.getElementById('dot1').classList.remove('active');
      document.getElementById('dot1').classList.add('done');
      document.getElementById('dot1').innerHTML = '?';
      document.getElementById('line1').classList.add('done');
      document.getElementById('dot2').classList.remove('inactive');
      document.getElementById('dot2').classList.add('active');

      document.getElementById('cardTitle').textContent = 'Verifikasi Email';
      document.getElementById('cardSub').textContent = 'Kode 6 digit telah dikirim ke email kamu';

      if (email) document.getElementById('otpEmailBadge').textContent = email;

      startCountdown();
      setTimeout(() => document.querySelector('#panel2 .otp-box').focus(), 100);
    }

    const boxes = document.querySelectorAll('#panel2 .otp-box');
    const hidden = document.getElementById('otpHidden');

    function updateHidden() {
      hidden.value = [...boxes].map(b => b.value).join('');
    }

    boxes.forEach((box, i) => {
      box.addEventListener('input', e => {
        const val = e.target.value.replace(/\D/g, '');
        box.value = val ? val.slice(-1) : '';
        updateHidden();
        box.classList.toggle('filled', !!box.value);
        if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
        if ([...boxes].every(b => b.value)) {
          setTimeout(() => {
            updateHidden();
            document.getElementById('otpSubmitBtn').disabled = true;
            document.getElementById('otpForm').submit();
          }, 200);
        }
      });

      box.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !box.value && i > 0) {
          boxes[i - 1].focus();
          boxes[i - 1].value = '';
          boxes[i - 1].classList.remove('filled');
          updateHidden();
        }
      });

      box.addEventListener('paste', e => {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        [...text].slice(0, 6).forEach((ch, idx) => {
          if (boxes[idx]) {
            boxes[idx].value = ch;
            boxes[idx].classList.add('filled');
          }
        });
        updateHidden();
        const next = [...boxes].findIndex(b => !b.value);
        (next !== -1 ? boxes[next] : boxes[5]).focus();
      });
    });

    document.getElementById('otpForm').addEventListener('submit', function () {
      updateHidden();
      if (hidden.value.length < 6) {
        boxes.forEach(b => { if (!b.value) b.classList.add('error'); });
        setTimeout(() => boxes.forEach(b => b.classList.remove('error')), 600);
        return false;
      }
      document.getElementById('otpSubmitBtn').disabled = true;
    });

    document.getElementById('registerForm').addEventListener('submit', function () {
      document.getElementById('submitBtn').disabled = true;
    });

    function startCountdown() {
      let secs = 60;
      const timerEl = document.getElementById('timerDisplay');
      const resendBtn = document.getElementById('resendBtn');
      const iv = setInterval(() => {
        secs--;
        timerEl.textContent = secs;
        if (secs <= 0) {
          clearInterval(iv);
          resendBtn.disabled = false;
          resendBtn.innerHTML = 'Kirim Ulang';
        }
      }, 1000);
    }
  </script>
</body>
</html>
