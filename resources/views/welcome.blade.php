<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealTack - Sistem Informasi Pelayanan Kesehatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Libre+Baskerville:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --blue:        #1A56DB;
            --blue-dark:   #1040AA;
            --blue-light:  #EBF2FF;
            --blue-mid:    #BFDBFE;
            --navy:        #0C1D3B;
            --navy-soft:   #1A3160;
            --white:       #FFFFFF;
            --surface:     #F5F8FF;
            --text:        #1E293B;
            --muted:       #64748B;
            --border:      #DBEAFE;
            --warn:        #F59E0B;
            --warn-bg:     #FFFBEB;
            --danger:      #EF4444;
            --danger-bg:   #FEF2F2;
            --font:        'Plus Jakarta Sans', sans-serif;
            --font-serif:  'Libre Baskerville', serif;
            --radius:      14px;
            --shadow:      0 4px 20px rgba(26, 86, 219, 0.10);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            color: var(--text);
            background: var(--white);
            overflow-x: hidden;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--blue);
            padding: 7px 0;
            font-size: 13px;
            color: rgba(255,255,255,.85);
        }
        .topbar a { color: inherit; text-decoration: none; }

        /* ── HEADER ── */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255,255,255,.97);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .branding { padding: 13px 0; }

        .logo-wrap { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon {
            width: 38px; height: 38px;
            background: var(--blue);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 19px;
        }
        .logo-text {
            font-size: 21px; font-weight: 800;
            color: var(--navy); letter-spacing: -.5px;
        }
        .logo-text span { color: var(--blue); }

        .navmenu ul { list-style: none; display: flex; gap: 2px; align-items: center; }
        .navmenu ul li a {
            color: var(--muted);
            text-decoration: none;
            font-size: 14px; font-weight: 600;
            padding: 7px 13px;
            border-radius: 8px;
            transition: all .2s;
        }
        .navmenu ul li a:hover, .navmenu ul li a.active {
            color: var(--blue);
            background: var(--blue-light);
        }

        /* ── HAMBURGER BUTTON ── */
        .hamburger-btn {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 40px; height: 40px;
            background: var(--blue-light);
            border: none; border-radius: 10px;
            cursor: pointer; gap: 5px;
            transition: background .2s;
        }
        .hamburger-btn:hover { background: var(--blue-mid); }
        .hamburger-btn span {
            display: block;
            width: 20px; height: 2px;
            background: var(--blue);
            border-radius: 2px;
            transition: all .3s ease;
        }
        .hamburger-btn.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger-btn.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger-btn.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ── MOBILE MENU DRAWER ── */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 999;
        }
        .mobile-menu.open { display: block; }
        .mobile-overlay {
            position: absolute; inset: 0;
            background: rgba(12,29,59,.5);
            backdrop-filter: blur(4px);
            animation: fadeIn .25s ease;
        }
        @keyframes fadeIn { from{opacity:0} to{opacity:1} }

        .mobile-drawer {
            position: absolute;
            top: 0; right: 0;
            width: 280px; height: 100%;
            background: var(--white);
            box-shadow: -8px 0 32px rgba(0,0,0,.15);
            padding: 24px;
            animation: slideIn .3s ease;
            display: flex; flex-direction: column;
        }
        @keyframes slideIn { from{transform:translateX(100%)} to{transform:translateX(0)} }

        .mobile-drawer-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }
        .mobile-close {
            width: 36px; height: 36px;
            background: var(--surface); border: none; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: var(--muted); cursor: pointer;
            transition: all .2s;
        }
        .mobile-close:hover { background: var(--danger-bg); color: var(--danger); }

        .mobile-nav-links { list-style: none; flex: 1; }
        .mobile-nav-links li { margin-bottom: 4px; }
        .mobile-nav-links li a {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px; border-radius: 10px;
            color: var(--text); text-decoration: none;
            font-size: 15px; font-weight: 600;
            transition: all .2s;
        }
        .mobile-nav-links li a i { font-size: 17px; color: var(--blue); width: 20px; }
        .mobile-nav-links li a:hover { background: var(--blue-light); color: var(--blue); }

        .mobile-cta-group {
            display: flex; flex-direction: column; gap: 10px;
            margin-top: 20px; padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .mobile-cta-group a {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px; border-radius: 10px;
            font-size: 14px; font-weight: 700; text-decoration: none;
            transition: all .25s;
        }
        .mobile-cta-login {
            background: var(--blue); color: #fff;
        }
        .mobile-cta-login:hover { background: var(--blue-dark); color: #fff; }
        .mobile-cta-register {
            background: var(--blue-light); color: var(--blue);
            border: 1.5px solid var(--blue-mid);
        }
        .mobile-cta-register:hover { background: var(--blue-mid); color: var(--blue-dark); }

        @media (max-width: 1199px) {
            .hamburger-btn { display: flex; }
            .navmenu { display: none !important; }
        }

        /* ── HERO ── */
        .hero {
            background: var(--navy);
            min-height: 92vh;
            display: flex; align-items: center;
            position: relative; overflow: hidden;
            padding: 100px 0 80px;
        }
        .hero::before {
            content: '';
            position: absolute; top: -180px; right: -180px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,.18) 0%, transparent 65%);
            border-radius: 50%;
            animation: glow 5s ease-in-out infinite;
        }
        @keyframes glow { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.06)} }

        .hero-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 60px; align-items: center;
            position: relative; z-index: 2;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(59,130,246,.14);
            border: 1px solid rgba(59,130,246,.3);
            color: #93C5FD;
            padding: 5px 14px; border-radius: 20px;
            font-size: 11px; font-weight: 600; letter-spacing: .6px;
            text-transform: uppercase; margin-bottom: 22px;
        }
        .hero-badge .dot {
            width: 6px; height: 6px;
            background: #60A5FA; border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }

        .hero h1 {
            font-size: clamp(34px, 4.5vw, 56px);
            font-weight: 800; color: #fff;
            line-height: 1.1; letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .hero h1 .hl { color: #60A5FA; }

        .hero p {
            color: rgba(255,255,255,.58);
            font-size: 15.5px; line-height: 1.75;
            margin-bottom: 32px; max-width: 460px;
        }

        .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; }

        .btn-blue {
            background: var(--blue); color: #fff;
            font-weight: 700; font-size: 15px;
            padding: 13px 26px; border-radius: 11px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            border: none; cursor: pointer; transition: all .25s;
        }
        .btn-blue:hover {
            background: var(--blue-dark); color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(26,86,219,.35);
        }
        .btn-ghost {
            background: transparent; color: rgba(255,255,255,.8);
            font-weight: 600; font-size: 15px;
            padding: 12px 24px; border-radius: 11px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            border: 1.5px solid rgba(255,255,255,.2); transition: all .25s;
        }
        .btn-ghost:hover { border-color: #60A5FA; color: #60A5FA; }

        .hero-card {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 20px; padding: 26px;
            backdrop-filter: blur(10px);
        }
        .hero-card h4 { color: #fff; font-weight: 700; font-size: 15px; margin-bottom: 18px; }
        .feature-row {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 12px; border-radius: 10px;
            margin-bottom: 8px;
            background: rgba(255,255,255,.04);
            color: rgba(255,255,255,.78); font-size: 14px;
        }
        .feature-row i { font-size: 17px; flex-shrink: 0; }

        .float-pill {
            position: absolute;
            background: rgba(15,30,65,.92);
            border: 1px solid rgba(59,130,246,.25);
            border-radius: 12px; padding: 12px 16px;
            box-shadow: 0 16px 32px rgba(0,0,0,.25);
        }
        .float-pill .pill-label { font-size: 10px; color: rgba(255,255,255,.4); font-weight: 600; letter-spacing:.4px; margin-bottom: 3px; }
        .float-pill .pill-val { font-size: 22px; font-weight: 800; color: #60A5FA; }
        .float-pill .pill-sub { font-size: 11px; color: rgba(255,255,255,.45); }
        .fp-1 { top: -28px; right: -16px; min-width: 150px; }
        .fp-2 { bottom: -18px; left: -16px; min-width: 165px; }

        /* ── WARNING BANNER ── */
        .warn-banner {
            background: var(--warn-bg);
            border-left: 4px solid var(--warn);
            padding: 18px 0;
        }
        .warn-inner { display: flex; align-items: flex-start; gap: 14px; }
        .warn-icon {
            width: 42px; height: 42px;
            background: var(--warn); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff; flex-shrink: 0;
        }
        .warn-inner h5 { font-size: 14px; font-weight: 700; color: #78350F; margin-bottom: 3px; }
        .warn-inner p  { font-size: 13px; color: #92400E; line-height: 1.6; margin: 0; }

        /* ── SECTIONS ── */
        section { padding: 88px 0; }

        .chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--blue-light); color: var(--blue-dark);
            padding: 4px 13px; border-radius: 20px;
            font-size: 11px; font-weight: 700; letter-spacing: .5px;
            text-transform: uppercase; margin-bottom: 14px;
        }
        .sec-title {
            font-size: clamp(26px, 3.5vw, 40px);
            font-weight: 800; color: var(--navy);
            line-height: 1.15; letter-spacing: -1px; margin-bottom: 14px;
        }
        .sec-desc { color: var(--muted); font-size: 15.5px; line-height: 1.75; max-width: 540px; }

        /* About */
        .about { background: var(--white); }
        .img-wrap { border-radius: 18px; overflow: hidden; position: relative; }
        .img-wrap img { width: 100%; height: 390px; object-fit: cover; display: block; }
        .img-badge {
            position: absolute; bottom: 18px; left: 18px; right: 18px;
            background: rgba(12,29,59,.9); backdrop-filter: blur(8px);
            border-radius: 12px; padding: 14px 18px;
            display: flex; align-items: center; gap: 16px;
        }
        .img-badge .num { font-size: 26px; font-weight: 800; color: #60A5FA; }
        .img-badge .lbl { font-size: 12px; color: rgba(255,255,255,.65); }

        .feat-list { list-style: none; margin-top: 26px; }
        .feat-list li {
            display: flex; align-items: flex-start; gap: 13px;
            padding: 14px 0; border-bottom: 1px solid var(--border);
        }
        .feat-list li:last-child { border-bottom: none; }
        .feat-ic {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--blue-light); color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; flex-shrink: 0;
        }
        .feat-list h5 { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 2px; }
        .feat-list p  { font-size: 13px; color: var(--muted); line-height: 1.6; margin: 0; }

        /* ── STATS (dengan animasi counter) ── */
        .stats { background: var(--navy); padding: 60px 0; }
        .stat-item { text-align: center; padding: 24px 16px; }
        .stat-item i { font-size: 28px; color: #60A5FA; display: block; margin-bottom: 10px; }
        .stat-num { font-size: 38px; font-weight: 800; color: #fff; line-height: 1; }
        .stat-num span { color: #60A5FA; }
        .stat-lbl { font-size: 13px; color: rgba(255,255,255,.45); margin-top: 5px; }
        .counter-val { display: inline-block; transition: all .1s; }

        /* Services */
        .services { background: var(--surface); }
        .svc-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 26px; height: 100%;
            transition: all .28s; position: relative; overflow: hidden;
        }
        .svc-card::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--blue); transform: scaleX(0); transform-origin: left;
            transition: transform .28s;
        }
        .svc-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); border-color: var(--blue-mid); }
        .svc-card:hover::after { transform: scaleX(1); }
        .svc-ic {
            width: 48px; height: 48px; border-radius: 12px;
            background: var(--blue-light); color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 16px;
        }
        .svc-card h3 { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
        .svc-card p  { font-size: 13.5px; color: var(--muted); line-height: 1.65; margin: 0; }

        /* Limitations */
        .limit-box {
            background: var(--danger-bg); border: 1.5px solid #FECACA;
            border-radius: var(--radius); padding: 20px; margin-bottom: 14px;
            display: flex; align-items: flex-start; gap: 14px;
        }
        .limit-ic {
            width: 38px; height: 38px; border-radius: 9px;
            background: #FEE2E2; color: var(--danger);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .limit-box h5 { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 3px; }
        .limit-box p  { font-size: 13px; color: #7F1D1D; line-height: 1.6; margin: 0; }

        /* Steps */
        .steps { background: var(--surface); }
        .timeline { position: relative; padding-left: 48px; }
        .timeline::before {
            content: ''; position: absolute; left: 17px; top: 0; bottom: 0;
            width: 2px; background: linear-gradient(to bottom, var(--blue), transparent);
        }
        .step { position: relative; margin-bottom: 28px; }
        .step-n {
            position: absolute; left: -48px;
            width: 36px; height: 36px; background: var(--blue);
            color: #fff; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 14px; z-index: 1;
        }
        .step-body {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 18px 22px;
        }
        .step-body h5 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
        .step-body p  { font-size: 13px; color: var(--muted); line-height: 1.65; margin: 0; }

        /* ── TESTIMONIALS ── */
        .testimonials { background: var(--white); padding: 88px 0; }
        .testi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 48px;
        }
        .testi-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            position: relative;
            transition: all .28s;
        }
        .testi-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
            border-color: var(--blue-mid);
        }
        .testi-card .quote-mark {
            font-size: 48px;
            line-height: 1;
            color: var(--blue-mid);
            font-family: Georgia, serif;
            margin-bottom: 10px;
            display: block;
        }
        .testi-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 20px;
            font-style: italic;
        }
        .testi-stars { color: #FBBF24; font-size: 13px; margin-bottom: 16px; letter-spacing: 1px; }
        .testi-user { display: flex; align-items: center; gap: 12px; }
        .testi-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            background: var(--blue-light);
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; font-weight: 800; color: var(--blue);
            flex-shrink: 0;
        }
        .testi-name { font-size: 14px; font-weight: 700; color: var(--navy); }
        .testi-role { font-size: 12px; color: var(--muted); }
        .testi-featured {
            background: var(--navy);
            border-color: var(--navy);
            grid-column: span 1;
        }
        .testi-featured p { color: rgba(255,255,255,.65); }
        .testi-featured .quote-mark { color: rgba(96,165,250,.3); }
        .testi-featured .testi-name { color: #fff; }
        .testi-featured .testi-role { color: rgba(255,255,255,.45); }
        .testi-featured .testi-avatar { background: rgba(59,130,246,.2); color: #60A5FA; }

        /* FAQ */
        .faq { background: var(--surface); }
        .faq-item {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius); margin-bottom: 10px; overflow: hidden;
        }
        .faq-q {
            padding: 16px 20px;
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer; gap: 12px;
        }
        .faq-q h3 { font-size: 14px; font-weight: 700; color: var(--navy); margin: 0; }
        .faq-toggle {
            width: 26px; height: 26px; border-radius: 7px;
            background: var(--blue-light); color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; flex-shrink: 0; transition: transform .25s;
        }
        .faq-item.open .faq-toggle { transform: rotate(45deg); }
        .faq-a {
            display: none; padding: 0 20px 16px;
            font-size: 13.5px; color: var(--muted); line-height: 1.7;
        }
        .faq-item.open .faq-a { display: block; }

        /* Footer */
        .footer {
            background: var(--navy);
            padding: 56px 0 28px;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .footer p, .footer address { color: rgba(255,255,255,.45); font-size: 13.5px; line-height: 1.8; }
        .footer h5 { font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 16px; letter-spacing: .3px; }
        .f-links { list-style: none; }
        .f-links li { margin-bottom: 8px; }
        .f-links li a { color: rgba(255,255,255,.45); text-decoration: none; font-size: 13.5px; transition: color .2s; }
        .f-links li a:hover { color: #60A5FA; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.07);
            margin-top: 38px; padding-top: 22px; text-align: center;
        }

        /* ── WHATSAPP FLOAT BUTTON ── */
        .wa-btn {
            position: fixed;
            bottom: 80px; right: 22px;
            width: 52px; height: 52px;
            background: #25D366;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 24px;
            text-decoration: none;
            z-index: 998;
            box-shadow: 0 6px 20px rgba(37,211,102,.4);
            transition: all .25s;
            animation: waPulse 2.5s ease-in-out infinite;
        }
        .wa-btn:hover {
            color: #fff;
            transform: scale(1.1);
            box-shadow: 0 10px 28px rgba(37,211,102,.55);
            animation: none;
        }
        @keyframes waPulse {
            0%,100% { box-shadow: 0 6px 20px rgba(37,211,102,.4); }
            50%      { box-shadow: 0 6px 28px rgba(37,211,102,.65), 0 0 0 8px rgba(37,211,102,.12); }
        }
        .wa-tooltip {
            position: fixed;
            bottom: 90px; right: 80px;
            background: var(--navy);
            color: #fff;
            font-size: 12px; font-weight: 600;
            padding: 6px 12px; border-radius: 8px;
            white-space: nowrap;
            opacity: 0; pointer-events: none;
            transition: opacity .2s;
            z-index: 997;
        }
        .wa-btn:hover ~ .wa-tooltip { opacity: 1; }

        /* ── SCROLL TOP ── */
        .scroll-top {
            position: fixed; bottom: 22px; right: 22px;
            width: 42px; height: 42px; background: var(--blue);
            border-radius: 11px; display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 19px; text-decoration: none; z-index: 999;
            box-shadow: 0 6px 18px rgba(26,86,219,.35); transition: all .25s;
        }
        .scroll-top:hover { background: var(--blue-dark); color: #fff; transform: translateY(-2px); }

        /* ── FADE-IN ── */
        .fi { opacity: 0; transform: translateY(22px); transition: opacity .6s ease, transform .6s ease; }
        .fi.show { opacity: 1; transform: translateY(0); }

        @media (max-width: 991px) {
            .testi-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .hero-grid { grid-template-columns: 1fr; }
            .fp-1, .fp-2 { display: none; }
            section { padding: 60px 0; }
            .testi-grid { grid-template-columns: 1fr; }
            .testimonials { padding: 60px 0; }
        }
    </style>
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-envelope"></i>
            <a href="mailto:healtack01@gmail.com">healtack01@gmail.com</a>
            <span class="d-none d-sm-inline">| Konsultasi melalui website</span>
        </div>
        <small>Bukan pengganti diagnosis dokter</small>
    </div>
</div>

<!-- Header -->
<header class="header">
            <div class="branding">
                <div class="container d-flex align-items-center justify-content-between">
                <a href="#hero" class="logo-wrap">
            <div class="logo-icon" style="background:transparent; padding:0; width:42px; height:42px;">
                <img src="{{ asset('frontend/assets/img/logo_healtack.png') }}" 
                    alt="HealTack" 
                    style="width:42px; height:42px; object-fit:contain;">
            </div>
            <div class="logo-text">Heal<span>Tack</span></div>
        </a>
            <!-- Desktop Nav -->
            <nav class="navmenu d-none d-xl-flex">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#keterbatasan">Keterbatasan</a></li>
                    <li><a href="#langkah">Panduan</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </nav>
            <!-- Hamburger Button -->
            <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>
<!-- Mobile Menu Drawer -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-drawer">
        <div class="mobile-drawer-header">
            <a href="#hero" class="logo-wrap" onclick="closeMobileMenu()">
                <div class="logo-icon" style="width:32px;height:32px;font-size:15px"><i class="bi bi-heart-pulse-fill"></i></div>
                <div class="logo-text" style="font-size:18px">Heal<span>Tack</span></div>
            </a>
            <button class="mobile-close" id="mobileClose" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="#hero" onclick="closeMobileMenu()"><i class="bi bi-house"></i> Beranda</a></li>
            <li><a href="#about" onclick="closeMobileMenu()"><i class="bi bi-info-circle"></i> Tentang</a></li>
            <li><a href="#layanan" onclick="closeMobileMenu()"><i class="bi bi-grid"></i> Layanan</a></li>
            <li><a href="#keterbatasan" onclick="closeMobileMenu()"><i class="bi bi-shield-exclamation"></i> Keterbatasan</a></li>
            <li><a href="#langkah" onclick="closeMobileMenu()"><i class="bi bi-list-ol"></i> Panduan</a></li>
            <li><a href="#faq" onclick="closeMobileMenu()"><i class="bi bi-question-circle"></i> FAQ</a></li>
        </ul>
        <div class="mobile-cta-group">
            <a href="/login" class="mobile-cta-login"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            <a href="/register" class="mobile-cta-register"><i class="bi bi-person-plus"></i> Register</a>
        </div>
    </div>
</div>

<main>

<!-- Hero -->
<section id="hero" class="hero">
    <div class="container">
        <div class="hero-grid">
            <div>
                <div class="hero-badge"><span class="dot"></span> Sistem Informasi Kesehatan Berbasis Web</div>
                <h1>Kelola Kesehatan<br><span class="hl">Lebih Mudah & Terorganisir</span><br>dalam Satu Platform</h1>
                <p>HealTack membantu Anda mengelola catatan medis, pengingat minum obat, konsultasi dokter, dan pembelian obat secara online.</p>
                <small style="display:block; margin: 12px 0; color: rgba(255,255,255,0.7);">
                    Belum punya akun? <b>Register</b> lalu isi profil.
                    Sudah punya akun? <b>Login</b> untuk mulai.
                </small>
                <div class="hero-cta">
                    <a href="/login" class="btn-blue"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    <a href="/register" class="btn-ghost"><i class="bi bi-person-plus"></i> Register</a>
                </div>
            </div>
            <div style="position:relative">
                <div class="hero-card">
                    <h4><i class="bi bi-clipboard2-pulse" style="color:#60A5FA; margin-right:8px;"></i>Fitur Utama HealTack</h4>
                    <div class="feature-row"><i class="bi bi-bell" style="color:#FBBF24"></i> Notifikasi Minum Obat (Email)</div>
                    <div class="feature-row"><i class="bi bi-chat-dots" style="color:#34D399"></i> Konsultasi dengan Dokter</div>
                    <div class="feature-row"><i class="bi bi-capsule" style="color:#F87171"></i> Pembelian Obat Online</div>
                </div>
                <div class="float-pill fp-1">
                    <div class="pill-label">FITUR AKTIF</div>
                    <div class="pill-val">4+</div>
                    <div class="pill-sub">Layanan tersedia</div>
                </div>
                <div class="float-pill fp-2">
                    <div class="pill-label">AKSES MUDAH</div>
                    <div class="pill-val">24/7</div>
                    <div class="pill-sub">Kapan saja & di mana saja</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Warning Banner -->
<div class="warn-banner">
    <div class="container">
        <div class="warn-inner">
            <div class="warn-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
                <h5>Perhatian Penting - HealTack Bukan Pengganti Dokter</h5>
                <p>HealTack adalah platform informasi kesehatan awal. Seluruh konten bersifat edukatif dan <strong>tidak dapat menggantikan diagnosis, pemeriksaan, maupun resep dari dokter berlisensi.</strong> Jika mengalami gejala serius, segera hubungi dokter atau kunjungi fasilitas kesehatan terdekat.</p>
            </div>
        </div>
    </div>
</div>

<!-- About -->
<section id="about" class="about">
    <div class="container">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-6 fi">
                <div class="img-wrap">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80" alt="HealTack">
                    <div class="img-badge">
                        <div style="padding-right:16px; border-right:1px solid rgba(255,255,255,.15)">
                            <div class="num">24/7</div><div class="lbl">Akses Sistem</div>
                        </div>
                        <div style="margin-left:16px">
                            <div class="num">100%</div><div class="lbl">Digital</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fi">
                <div class="chip">Tentang HealTack</div>
                <h2 class="sec-title">Sistem Informasi Pelayanan Kesehatan Berbasis Web</h2>
                <p class="sec-desc">HealTack membantu pengguna mengelola data kesehatan, mendapatkan pengingat pengobatan, konsultasi dengan dokter, serta pembelian obat dalam satu sistem.</p>
                <ul class="feat-list">
                    <li><div class="feat-ic"><i class="bi bi-file-medical"></i></div><div><h5>Catatan Medis Digital</h5><p>Menyimpan riwayat kesehatan secara terstruktur dan mudah diakses kapan saja.</p></div></li>
                    <li><div class="feat-ic"><i class="bi bi-bell"></i></div><div><h5>Notifikasi Minum Obat</h5><p>Pengingat otomatis via email agar tidak melewatkan jadwal konsumsi obat.</p></div></li>
                    <li><div class="feat-ic"><i class="bi bi-chat-dots"></i></div><div><h5>Konsultasi dengan Dokter</h5><p>Konsultasi secara online tanpa harus datang langsung ke fasilitas kesehatan.</p></div></li>
                    <li><div class="feat-ic"><i class="bi bi-capsule"></i></div><div><h5>Pembelian Obat Online</h5><p>Pembelian obat secara praktis melalui sistem dengan proses yang cepat.</p></div></li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- Services -->
<section id="layanan" class="services">
    <div class="container">
        <div class="text-center mb-5 fi">
            <div class="chip mx-auto" style="width:fit-content">Layanan Kami</div>
            <h2 class="sec-title">Fitur Utama HealTack</h2>
            <p class="sec-desc mx-auto text-center">Sistem pelayanan kesehatan berbasis web yang membantu Anda mengelola kesehatan lebih praktis.</p>
        </div>
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 fi"><div class="svc-card"><div class="svc-ic"><i class="bi bi-file-medical"></i></div><h3>Catatan Medis</h3><p>Menyimpan riwayat kesehatan, data pasien, dan informasi medis secara digital dan terorganisir.</p></div></div>
            <div class="col-lg-4 col-md-6 fi"><div class="svc-card"><div class="svc-ic"><i class="bi bi-bell"></i></div><h3>Notifikasi Obat</h3><p>Pengingat otomatis via email untuk menjaga jadwal minum obat secara teratur.</p></div></div>
            <div class="col-lg-4 col-md-6 fi"><div class="svc-card"><div class="svc-ic"><i class="bi bi-chat-dots"></i></div><h3>Konsultasi Dokter</h3><p>Layanan konsultasi kesehatan online untuk mendapatkan arahan medis awal.</p></div></div>
            <div class="col-lg-4 col-md-6 fi"><div class="svc-card"><div class="svc-ic"><i class="bi bi-capsule"></i></div><h3>Pembelian Obat</h3><p>Membeli obat secara online dengan proses yang cepat dan praktis melalui sistem.</p></div></div>
        </div>
    </div>
</section>

<!-- Limitations -->
<section id="keterbatasan">
    <div class="container">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-5 fi">
                <div class="chip">Penting Diketahui</div>
                <h2 class="sec-title">Keterbatasan HealTack</h2>
                <p class="sec-desc">HealTack membantu pengelolaan data dan akses layanan, namun tetap memiliki batasan dalam penggunaannya.</p>
                <div style="margin-top:24px; padding:18px; background:var(--blue-light); border-radius:12px; border-left:4px solid var(--blue)">
                    <p style="font-size:13.5px; margin:0; color:var(--navy)"><strong>Catatan:</strong> HealTack hanya sebagai media pendukung, bukan pengganti pemeriksaan langsung oleh tenaga medis.</p>
                </div>
            </div>
            <div class="col-lg-7 fi">
                <div class="limit-box"><div class="limit-ic"><i class="bi bi-x-circle"></i></div><div><h5>Bukan Pengganti Diagnosis</h5><p>Keputusan medis tetap harus dilakukan dokter melalui pemeriksaan langsung.</p></div></div>
                <div class="limit-box"><div class="limit-ic"><i class="bi bi-exclamation-triangle"></i></div><div><h5>Tidak Untuk Kondisi Darurat</h5><p>Segera kunjungi fasilitas kesehatan terdekat jika mengalami kondisi darurat.</p></div></div>
                <div class="limit-box"><div class="limit-ic"><i class="bi bi-wifi-off"></i></div><div><h5>Bergantung pada Internet</h5><p>Layanan membutuhkan koneksi internet untuk dapat digunakan secara optimal.</p></div></div>
            </div>
        </div>
    </div>
</section>

<!-- Steps -->
<section id="langkah" class="steps">
    <div class="container">
        <div class="row gy-5 align-items-start">
            <div class="col-lg-5 fi">
                <div class="chip">Panduan Penggunaan</div>
                <h2 class="sec-title">Cara Menggunakan HealTack</h2>
                <p class="sec-desc">Ikuti langkah berikut untuk menggunakan fitur HealTack secara optimal.</p>
            </div>
            <div class="col-lg-7 fi">
                <div class="timeline">
                    <div class="step"><div class="step-n">1</div><div class="step-body"><h5>Register Akun</h5><p>Buat akun dan lengkapi data profil Anda.</p></div></div>
                    <div class="step"><div class="step-n">2</div><div class="step-body"><h5>Login ke Sistem</h5><p>Masuk menggunakan akun yang telah didaftarkan.</p></div></div>
                    <div class="step"><div class="step-n">3</div><div class="step-body"><h5>Kelola Catatan Medis</h5><p>Tambahkan dan simpan riwayat kesehatan secara digital.</p></div></div>
                    <div class="step"><div class="step-n">4</div><div class="step-body"><h5>Atur Notifikasi Obat</h5><p>Aktifkan pengingat minum obat melalui email sesuai jadwal.</p></div></div>
                    <div class="step"><div class="step-n">5</div><div class="step-body"><h5>Gunakan Layanan</h5><p>Lakukan konsultasi dengan dokter atau pembelian obat melalui sistem.</p></div></div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- FAQ -->
<section id="faq" class="faq">
    <div class="container">
        <div class="text-center mb-5 fi">
            <div class="chip mx-auto" style="width:fit-content">FAQ</div>
            <h2 class="sec-title">Pertanyaan Umum</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 fi">
                <div class="faq-item open">
                    <div class="faq-q" onclick="toggleFaq(this)"><h3>Apakah HealTack bisa menggantikan dokter?</h3><div class="faq-toggle"><i class="bi bi-plus"></i></div></div>
                    <div class="faq-a">Tidak. HealTack hanya sebagai sistem pendukung layanan kesehatan, bukan pengganti diagnosis dokter.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)"><h3>Apa saja fitur HealTack?</h3><div class="faq-toggle"><i class="bi bi-plus"></i></div></div>
                    <div class="faq-a">Fitur utama meliputi catatan medis digital, notifikasi minum obat via email, konsultasi dokter, dan pembelian obat.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)"><h3>Apakah harus register terlebih dahulu?</h3><div class="faq-toggle"><i class="bi bi-plus"></i></div></div>
                    <div class="faq-a">Ya. Pengguna harus melakukan registrasi dan mengisi profil sebelum menggunakan layanan.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)"><h3>Bagaimana sistem notifikasi obat bekerja?</h3><div class="faq-toggle"><i class="bi bi-plus"></i></div></div>
                    <div class="faq-a">Sistem mengirimkan pengingat melalui email sesuai jadwal obat yang telah Anda atur.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)"><h3>Apakah HealTack bisa digunakan kapan saja?</h3><div class="faq-toggle"><i class="bi bi-plus"></i></div></div>
                    <div class="faq-a">Ya, HealTack dapat diakses 24 jam selama terhubung dengan internet.</div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row gy-4">

            <!-- Branding & Deskripsi -->
            <div class="col-lg-4 col-md-6">
                <div class="branding">
                    <a href="#hero" class="logo-wrap">
                        <div class="logo-icon" style="background:transparent; padding:0; width:42px; height:42px;">
                            <img src="{{ asset('frontend/assets/img/logo_healtack.png') }}"
                                alt="HealTack"
                                style="width:42px; height:42px; object-fit:contain;">
                        </div>
                        <div class="logo-text" style="color:#fff">Heal<span>Tack</span></div>
                    </a>
                </div>
                <p>Platform sistem informasi pelayanan kesehatan berbasis web untuk pengelolaan data kesehatan secara digital.</p>
            </div>

            <!-- Navigasi -->
            <div class="col-lg-2 col-md-3">
                <h5>Navigasi</h5>
                <ul class="f-links">
                    <li><a href="#hero">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#keterbatasan">Keterbatasan</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>

            <!-- Fitur -->
            <div class="col-lg-2 col-md-3">
                <h5>Fitur</h5>
                <ul class="f-links">
                    <li><a href="#">Catatan Medis</a></li>
                    <li><a href="#">Notifikasi Obat</a></li>
                    <li><a href="#">Konsultasi</a></li>
                    <li><a href="#">Pembelian Obat</a></li>
                </ul>
            </div>

            <!-- Disclaimer -->
            <div class="col-lg-4 col-md-6">
                <h5>Disclaimer</h5>
                <p>HealTack bukan pengganti dokter dan tidak memberikan diagnosis medis. Selalu konsultasikan kondisi Anda ke tenaga medis berlisensi.</p>
            </div>

        </div>

        <div class=\"footer-bottom\">
            <p>&copy; 2026 HealTack - Sistem Informasi Pelayanan Kesehatan</p>
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href=\"#hero\" class=\"scroll-top\"><i class=\"bi bi-arrow-up-short\"></i></a>

<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js\"></script>
<script>
    /* FAQ */
    function toggleFaq(el){el.closest('.faq-item').classList.toggle('open')}

    /* FADE IN */
    const obs=new IntersectionObserver(e=>e.forEach(e=>e.isIntersecting&&e.target.classList.add('show')),{threshold:.1});
    document.querySelectorAll('.fi').forEach(el=>obs.observe(el));

    /* ACTIVE NAV */
    const sections=document.querySelectorAll('section[id]'),navLinks=document.querySelectorAll('.navmenu ul li a');
    window.addEventListener('scroll',()=>{
        let cur='';
        sections.forEach(s=>{if(window.scrollY>=s.offsetTop-120)cur=s.id});
        navLinks.forEach(a=>{a.classList.remove('active');if(a.getAttribute('href')==='#'+cur)a.classList.add('active')});
    });

    /* HAMBURGER */
    const hBtn=document.getElementById('hamburgerBtn'),mMenu=document.getElementById('mobileMenu'),
          mOvl=document.getElementById('mobileOverlay'),mClose=document.getElementById('mobileClose');
    const openMenu=()=>{mMenu.classList.add('open');hBtn.classList.add('open');document.body.style.overflow='hidden'};
    const closeMenu=()=>{mMenu.classList.remove('open');hBtn.classList.remove('open');document.body.style.overflow=''};
    hBtn.addEventListener('click',()=>mMenu.classList.contains('open')?closeMenu():openMenu());
    mClose.addEventListener('click',closeMenu);
    mOvl.addEventListener('click',closeMenu);

    /* COUNTER */
    function animateCounter(el){
        const target=parseInt(el.dataset.target,10),dur=1800,t0=performance.now();
        (function tick(now){
            const p=Math.min((now-t0)/dur,1),v=Math.floor((1-(1-p)**2)*target);
            el.textContent=v.toLocaleString('id-ID');
            p<1?requestAnimationFrame(tick):el.textContent=target.toLocaleString('id-ID');
        })(t0);
    }
    let fired=false;
    const statsSection=document.getElementById('statsSection');
    if(statsSection){
        new IntersectionObserver(e=>{if(e[0].isIntersecting&&!fired){fired=true;document.querySelectorAll('.counter-val').forEach(animateCounter)}},{threshold:.3})
        .observe(statsSection);
    }
</script>
</body>
</html>

