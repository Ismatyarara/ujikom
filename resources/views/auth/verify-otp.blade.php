<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Verifikasi OTP — HealTack</title>

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

    .otp-card {
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
      to   { opacity: 1; transform: translateY(0); }
    }
    .otp-card::before {
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
      gap: 10px; text-decoration: none; margin-bottom: 28px;
    }
    .logo-icon { width: 42px; height: 42px; }
    .logo-icon img { width: 42px; height: 42px; object-fit: contain; }
    .logo-text { font-size: 24px; font-weight: 800; color: #0C1D3B; letter-spacing: -.5px; }
    .logo-text span { color: #1A56DB; }

    .shield-wrap {
      display: flex; justify-content: center; margin-bottom: 20px;
    }
    .shield-icon {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, #EBF2FF, #DBEAFE);
      border-radius: 20px;
      display: flex; align-items: center; justify-content: center;
      animation: pulse-shield 2.5s ease-in-out infinite;
    }
    @keyframes pulse-shield {
      0%,100% { box-shadow: 0 0 0 0 rgba(26,86,219,.2); }
      50%      { box-shadow: 0 0 0 14px rgba(26,86,219,0); }
    }
    .shield-icon svg { width: 36px; height: 36px; }

    .card-title {
      text-align: center; font-size: 21px; font-weight: 800; color: #0C1D3B; margin-bottom: 6px;
    }
    .card-sub {
      text-align: center; font-size: 13.5px; color: #64748B; margin-bottom: 8px; line-height: 1.55;
    }
    .email-badge {
      display: block; text-align: center;
      background: #EBF2FF; color: #1A56DB;
      font-size: 13px; font-weight: 700;
      padding: 4px 12px; border-radius: 20px;
      margin: 0 auto 26px auto;
    }

    .otp-inputs {
      display: flex; gap: 10px; justify-content: center;
      margin-bottom: 24px;
    }
    .otp-box {
      width: 52px; height: 60px;
      border: 2px solid #E2E8F0;
      border-radius: 14px;
      background: #F8FAFC;
      text-align: center;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 24px; font-weight: 800; color: #0C1D3B;
      outline: none;
      transition: all .2s;
      caret-color: #1A56DB;
      -moz-appearance: textfield;
    }
    .otp-box::-webkit-outer-spin-button,
    .otp-box::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .otp-box:focus {
      border-color: #1A56DB;
      background: #EBF2FF;
      box-shadow: 0 0 0 4px rgba(26,86,219,.12);
      transform: translateY(-2px);
    }
    .otp-box.filled { border-color: #1A56DB; background: #EBF2FF; }
    .otp-box.error {
      border-color: #EF4444;
      background: #FEF2F2;
      animation: shake .35s ease;
    }
    @keyframes shake {
      0%,100% { transform: translateX(0); }
      20%      { transform: translateX(-5px); }
      60%      { transform: translateX(5px); }
    }

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

    .resend-wrap {
      text-align: center; margin-top: 18px; font-size: 13.5px; color: #64748B;
    }
    .resend-btn {
      background: none; border: none; padding: 0;
      color: #1A56DB; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 13.5px;
      cursor: pointer; transition: opacity .2s;
    }
    .resend-btn:disabled { color: #94A3B8; cursor: not-allowed; }
    .resend-btn:not(:disabled):hover { text-decoration: underline; }
    .timer { font-weight: 700; color: #1A56DB; font-variant-numeric: tabular-nums; }

    .alert-error {
      background: #FEF2F2; border: 1px solid #FECACA;
      border-radius: 10px; padding: 12px 16px;
      font-size: 13px; color: #B91C1C; margin-bottom: 18px;
    }
    .alert-success {
      background: #F0FDF4; border: 1px solid #86EFAC;
      border-radius: 10px; padding: 12px 16px;
      font-size: 13px; color: #15803D; margin-bottom: 18px;
    }

    .back-link {
      display: block; text-align: center;
      margin-top: 16px; font-size: 13px; color: #94A3B8;
      text-decoration: none;
    }
    .back-link:hover { color: #1A56DB; }

    @media (max-width: 480px) {
      .otp-card { padding: 36px 24px; }
      .otp-box { width: 44px; height: 54px; font-size: 20px; }
    }
  </style>
</head>
<body>

  <div class="otp-card">

    <a href="{{ url('/') }}" class="logo-wrap">
      <div class="logo-icon">
        <img src="{{ asset('frontend/assets/img/logo_healtack.png') }}" alt="HealTack">
      </div>
      <div class="logo-text">Heal<span>Tack</span></div>
    </a>

    <div class="shield-wrap">
      <div class="shield-icon">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2L4 6v6c0 4.97 3.37 9.63 8 11 4.63-1.37 8-6.03 8-11V6l-8-4z" fill="#1A56DB" opacity=".15"/>
          <path d="M12 2L4 6v6c0 4.97 3.37 9.63 8 11 4.63-1.37 8-6.03 8-11V6l-8-4z" stroke="#1A56DB" stroke-width="1.8" stroke-linejoin="round"/>
          <path d="M9 12l2 2 4-4" stroke="#1A56DB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>

    <div class="card-title">Verifikasi Kode OTP</div>
    <div class="card-sub">Kode 6 digit telah dikirim ke email kamu</div>
    <span class="email-badge">{{ $email ?? session('otp_email') ?? 'email@kamu.com' }}</span>

    @if (session('error'))
      <div class="alert-error">{{ session('error') }}</div>
    @endif
    @if (session('success'))
      <div class="alert-success">{{ session('success') }}</div>
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

      <button type="submit" id="submitBtn" class="btn-submit">Verifikasi</button>
    </form>

    <div class="resend-wrap">
      Tidak menerima kode?
      <form method="POST" action="{{ route('otp.resend') }}" style="display:inline;" id="resendForm">
        @csrf
        <button type="submit" class="resend-btn" id="resendBtn" disabled>
          Kirim Ulang (<span class="timer" id="timerDisplay">60</span>s)
        </button>
      </form>
    </div>

    <a href="{{ route('login') }}" class="back-link">← Kembali ke Login</a>

  </div>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script>
    const boxes     = document.querySelectorAll('.otp-box');
    const hidden    = document.getElementById('otpHidden');
    const form      = document.getElementById('otpForm');
    const submitBtn = document.getElementById('submitBtn');
    let   submitting = false;

    // ─── Helpers ────────────────────────────────────────────────────────────────
    function updateHidden() {
      hidden.value = [...boxes].map(b => b.value).join('');
    }

    function isComplete() {
      return [...boxes].every(b => b.value !== '');
    }

    function doSubmit() {
      if (submitting) return;
      submitting = true;
      submitBtn.disabled = true;
      form.submit();
    }

    // ─── OTP Box Behavior ────────────────────────────────────────────────────────
    boxes.forEach((box, i) => {

      box.addEventListener('input', e => {
        const val = e.target.value.replace(/\D/g, '');
        box.value = val ? val.slice(-1) : '';
        box.classList.toggle('filled', !!box.value);
        updateHidden();

        if (box.value && i < boxes.length - 1) {
          boxes[i + 1].focus();
        }

        if (isComplete()) {
          setTimeout(doSubmit, 150);
        }
      });

      box.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !box.value && i > 0) {
          boxes[i - 1].value = '';
          boxes[i - 1].classList.remove('filled');
          boxes[i - 1].focus();
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
        const nextEmpty = [...boxes].findIndex(b => !b.value);
        (nextEmpty !== -1 ? boxes[nextEmpty] : boxes[5]).focus();

        if (isComplete()) {
          setTimeout(doSubmit, 150);
        }
      });
    });

    // ─── Form Submit (tombol manual) ─────────────────────────────────────────────
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      updateHidden();

      if (hidden.value.length < 6) {
        boxes.forEach(b => { if (!b.value) b.classList.add('error'); });
        setTimeout(() => boxes.forEach(b => b.classList.remove('error')), 600);
        return;
      }

      doSubmit();
    });

    // ─── Countdown Timer ─────────────────────────────────────────────────────────
    let seconds = 60;
    const timerEl   = document.getElementById('timerDisplay');
    const resendBtn = document.getElementById('resendBtn');

    const countdown = setInterval(() => {
      seconds--;
      timerEl.textContent = seconds;
      if (seconds <= 0) {
        clearInterval(countdown);
        resendBtn.disabled = false;
        resendBtn.textContent = 'Kirim Ulang';
      }
    }, 1000);

    // ─── Focus first box ──────────────────────────────────────────────────────────
    boxes[0].focus();
  </script>
</body>
</html>