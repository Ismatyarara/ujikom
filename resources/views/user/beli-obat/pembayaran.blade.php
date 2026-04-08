@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

    * { box-sizing: border-box; }

    .pay-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f0f2f8;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
        position: relative;
        overflow: hidden;
    }

    /* Background decoration */
    .pay-page::before {
        content: '';
        position: fixed;
        top: -120px;
        right: -120px;
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, rgba(79,110,247,0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .pay-page::after {
        content: '';
        position: fixed;
        bottom: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(91,185,123,0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Card */
    .pay-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 8px 40px rgba(26,29,46,0.10), 0 1px 4px rgba(26,29,46,0.06);
        width: 100%;
        max-width: 440px;
        overflow: hidden;
        position: relative;
        animation: slideUp .4s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Gradient top bar */
    .pay-topbar {
        height: 5px;
        background: linear-gradient(90deg, #3a56e8, #6b8fff, #5bb97b);
        background-size: 200% 100%;
        animation: shimmerBar 3s linear infinite;
    }
    @keyframes shimmerBar {
        0%   { background-position: 0% 0%; }
        100% { background-position: 200% 0%; }
    }

    /* Body */
    .pay-body {
        padding: 36px 32px 32px;
    }

    /* Status badge */
    .pay-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff8e6;
        color: #c07a00;
        border: 1.5px solid #fde9a2;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 12px;
        margin-bottom: 20px;
        letter-spacing: .3px;
        text-transform: uppercase;
    }
    .pay-status .dot {
        width: 6px;
        height: 6px;
        background: #f59e0b;
        border-radius: 50%;
        animation: pulse 1.5s ease-in-out infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: .5; transform: scale(.7); }
    }

    /* Icon */
    .pay-icon-wrap {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #eef1ff, #dce3ff);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 6px;
        font-size: 1.6rem;
        color: #4f6ef7;
        box-shadow: 0 4px 14px rgba(79,110,247,.18);
    }

    /* Title */
    .pay-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1d2e;
        margin-bottom: 4px;
        text-align: center;
    }
    .pay-subtitle {
        font-size: 0.8rem;
        color: #a0a6c0;
        font-weight: 500;
        text-align: center;
        margin-bottom: 24px;
    }

    /* Info card */
    .pay-info {
        background: #f8f9ff;
        border: 1.5px solid #e8eaf2;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 22px;
    }

    .pay-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        gap: 12px;
    }
    .pay-info-row + .pay-info-row {
        border-top: 1.5px solid #eef0f8;
    }
    .pay-info-row:last-child {
        background: #f0f3ff;
        border-top: 2px solid #dce3ff;
    }

    .info-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #8b91a8;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .info-label i {
        width: 18px;
        text-align: center;
        color: #b0b8d8;
        font-size: .75rem;
    }

    .info-value {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1a1d2e;
        text-align: right;
    }
    .info-value.kode {
        font-family: 'Courier New', monospace;
        font-size: 0.8rem;
        background: #fff;
        border: 1.5px solid #e0e4f4;
        border-radius: 7px;
        padding: 3px 9px;
        color: #4f6ef7;
        letter-spacing: .5px;
    }
    .info-value.harga {
        font-size: 1.05rem;
        font-weight: 800;
        color: #4f6ef7;
    }

    /* Detail items collapsible */
    .detail-toggle {
        width: 100%;
        background: none;
        border: 1.5px dashed #d4d9f0;
        border-radius: 10px;
        padding: 9px 14px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #8b91a8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all .15s;
        margin-bottom: 22px;
    }
    .detail-toggle:hover {
        background: #f5f6fb;
        border-color: #b0b8d8;
        color: #5a607a;
    }
    .detail-toggle .arrow {
        transition: transform .25s;
        font-size: .65rem;
    }
    .detail-toggle.open .arrow { transform: rotate(180deg); }

    .detail-items {
        display: none;
        background: #f8f9ff;
        border: 1.5px solid #e8eaf2;
        border-radius: 12px;
        overflow: hidden;
        margin-top: -14px;
        margin-bottom: 22px;
        animation: fadeIn .2s ease;
    }
    .detail-items.show { display: block; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 14px;
        font-size: 0.8rem;
        gap: 12px;
    }
    .detail-item + .detail-item {
        border-top: 1px solid #eef0f8;
    }
    .detail-item-name {
        font-weight: 600;
        color: #1a1d2e;
        flex: 1;
    }
    .detail-item-qty {
        font-size: 0.73rem;
        color: #a0a6c0;
        font-weight: 500;
        margin-top: 1px;
    }
    .detail-item-sub {
        font-weight: 700;
        color: #5a607a;
        white-space: nowrap;
    }

    /* Pay button */
    .btn-pay {
        width: 100%;
        background: linear-gradient(135deg, #4f6ef7, #3a56e8);
        color: #fff;
        border: none;
        border-radius: 13px;
        padding: 14px;
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all .2s;
        box-shadow: 0 4px 16px rgba(79,110,247,.35);
        position: relative;
        overflow: hidden;
        margin-bottom: 12px;
    }
    .btn-pay::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,.15), transparent);
        opacity: 0;
        transition: opacity .2s;
    }
    .btn-pay:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(79,110,247,.45); }
    .btn-pay:hover::after { opacity: 1; }
    .btn-pay:active { transform: scale(.98); }
    .btn-pay.loading {
        opacity: .7;
        cursor: not-allowed;
        pointer-events: none;
    }
    .btn-pay i { font-size: .82rem; }

    /* Spinner */
    .spinner {
        display: none;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin .7s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-pay.loading .spinner { display: block; }
    .btn-pay.loading .btn-label { display: none; }

    /* Footer note */
    .pay-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 0.73rem;
        color: #b0b8d8;
        font-weight: 500;
    }
    .pay-note i { color: #5bb97b; font-size: .68rem; }

    /* Back link */
    .pay-back {
        display: block;
        text-align: center;
        margin-top: 14px;
        font-size: 0.76rem;
        color: #b0b8d8;
        font-weight: 600;
        text-decoration: none;
        transition: color .15s;
    }
    .pay-back:hover { color: #8b91a8; }

    /* Midtrans logo area */
    .midtrans-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1.5px solid #f0f2f8;
    }
    .midtrans-badge span {
        font-size: 0.7rem;
        color: #c0c6dc;
        font-weight: 600;
    }
    .midtrans-badge .brand {
        font-size: 0.72rem;
        font-weight: 800;
        color: #a0a6c0;
        letter-spacing: -.2px;
    }
</style>

<div class="pay-page">
    <div class="pay-card">
        <div class="pay-topbar"></div>

        <div class="pay-body">

            {{-- Status badge --}}
            <div style="text-align:center;">
                <div class="pay-status" style="display:inline-flex;">
                    <span class="dot"></span>
                    Menunggu Pembayaran
                </div>
            </div>

            {{-- Icon --}}
            <div class="pay-icon-wrap">
                <i class="fas fa-credit-card"></i>
            </div>

            {{-- Title --}}
            <div class="pay-title">Selesaikan Pembayaran</div>
            <div class="pay-subtitle">Segera selesaikan pembayaran sebelum pesanan kedaluwarsa</div>

            {{-- Info --}}
            <div class="pay-info">
                <div class="pay-info-row">
                    <span class="info-label">
                        <i class="fas fa-hashtag"></i> Kode Transaksi
                    </span>
                    <span class="info-value kode">{{ $transaksi->kode_transaksi }}</span>
                </div>
                <div class="pay-info-row">
                    <span class="info-label">
                        <i class="fas fa-user"></i> Pemesan
                    </span>
                    <span class="info-value">{{ auth()->user()->name }}</span>
                </div>
                <div class="pay-info-row">
                    <span class="info-label">
                        <i class="fas fa-map-marker-alt"></i> Pengiriman ke
                    </span>
                    <span class="info-value" style="max-width:180px; text-align:right; line-height:1.4;">
                        {{ $transaksi->alamat_pengiriman }}
                    </span>
                </div>
                <div class="pay-info-row">
                    <span class="info-label">
                        <i class="fas fa-tag"></i> Total Pembayaran
                    </span>
                    <span class="info-value harga">
                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Toggle detail item --}}
            @if($transaksi->details && $transaksi->details->count() > 0)
                <button class="detail-toggle" id="toggleDetail" onclick="toggleDetail()">
                    <span>
                        <i class="fas fa-box" style="margin-right:6px;font-size:.7rem;"></i>
                        {{ $transaksi->details->count() }} item pesanan
                    </span>
                    <i class="fas fa-chevron-down arrow"></i>
                </button>

                <div class="detail-items" id="detailItems">
                    @foreach($transaksi->details as $detail)
                        <div class="detail-item">
                            <div>
                                <div class="detail-item-name">{{ $detail->obat->nama_obat ?? '-' }}</div>
                                <div class="detail-item-qty">
                                    {{ $detail->jumlah }} {{ $detail->obat->satuan ?? 'pcs' }}
                                    × Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="detail-item-sub">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Pay button --}}
            <button id="pay-button" class="btn-pay" onclick="startPay()">
                <span class="spinner"></span>
                <span class="btn-label">
                    <i class="fas fa-lock"></i>&nbsp; Bayar Sekarang
                </span>
            </button>

            {{-- Note --}}
            <div class="pay-note">
                <i class="fas fa-shield-alt"></i>
                Pembayaran aman &amp; terenkripsi
            </div>

            {{-- Back --}}
            <a href="{{ route('toko.riwayat') }}" class="pay-back">
                ← Lihat riwayat transaksi
            </a>

            {{-- Midtrans badge --}}
            <div class="midtrans-badge">
                <span>Diproses oleh</span>
                <span class="brand">🔒 Midtrans</span>
            </div>

        </div>
    </div>
</div>

{{-- Midtrans Snap JS --}}
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    const snapToken = '{{ $snapToken }}';
    const payBtn    = document.getElementById('pay-button');

    function startPay() {
        payBtn.classList.add('loading');

        window.snap.pay(snapToken, {
            onSuccess: function (result) {
                window.location.href = "{{ route('toko.riwayat') }}";
            },
            onPending: function (result) {
                window.location.href = "{{ route('toko.riwayat') }}";
            },
            onError: function (result) {
                payBtn.classList.remove('loading');
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function () {
                payBtn.classList.remove('loading');
            }
        });
    }

    function toggleDetail() {
        const btn   = document.getElementById('toggleDetail');
        const items = document.getElementById('detailItems');
        btn.classList.toggle('open');
        items.classList.toggle('show');
    }

    // Auto buka popup saat halaman load
    window.addEventListener('load', function () {
        setTimeout(startPay, 600);
    });
</script>

@endsection
