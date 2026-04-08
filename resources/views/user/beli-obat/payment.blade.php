@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .payment-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f5f6fa;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
    }

    .payment-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 16px rgba(0,0,0,.08);
        width: 100%;
        max-width: 420px;
        overflow: hidden;
    }

    /* Top accent bar */
    .payment-topbar {
        height: 4px;
        background: linear-gradient(90deg, #4f6ef7, #7c9bff);
    }

    .payment-body {
        padding: 36px 32px 32px;
        text-align: center;
    }

    /* Icon */
    .payment-icon {
        width: 60px;
        height: 60px;
        background: #f0f3ff;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.5rem;
        color: #4f6ef7;
    }

    .payment-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 18px;
    }

    /* Info box */
    .payment-info {
        background: #f8f9ff;
        border: 1.5px solid #e8eaf2;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 22px;
        text-align: left;
    }
    .payment-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.82rem;
    }
    .payment-info-row:not(:last-child) {
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1.5px solid #eef0f8;
    }
    .info-label {
        color: #8b91a8;
        font-weight: 500;
    }
    .info-value {
        font-weight: 700;
        color: #1a1d2e;
        font-size: 0.82rem;
    }
    .info-value.price {
        color: #4f6ef7;
        font-size: 1rem;
    }

    /* Pay button */
    .btn-pay {
        width: 100%;
        background: #4f6ef7;
        color: #fff;
        border: none;
        border-radius: 11px;
        padding: 13px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: opacity .15s, transform .1s;
        margin-bottom: 14px;
    }
    .btn-pay:hover { opacity: .87; }
    .btn-pay:active { transform: scale(.98); }
    .btn-pay i { font-size: .8rem; }

    /* Loading state */
    .btn-pay.loading {
        opacity: .7;
        cursor: not-allowed;
        pointer-events: none;
    }

    .payment-note {
        font-size: 0.74rem;
        color: #a0a6c0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-weight: 500;
    }
    .payment-note i { font-size: .65rem; color: #5bb97b; }
</style>

<div class="payment-wrap">
    <div class="payment-card">
        <div class="payment-topbar"></div>
        <div class="payment-body">

            <div class="payment-icon">
                <i class="fas fa-credit-card"></i>
            </div>

            <div class="payment-title">Selesaikan Pembayaran</div>

            <div class="payment-info">
                <div class="payment-info-row">
                    <span class="info-label">Kode Transaksi</span>
                    <span class="info-value">{{ $transaksi->kode_transaksi }}</span>
                </div>
                <div class="payment-info-row">
                    <span class="info-label">Total Pembayaran</span>
                    <span class="info-value price">
                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <button id="pay-button" class="btn-pay">
                <i class="fas fa-lock"></i> Bayar Sekarang
            </button>

            <div class="payment-note">
                <i class="fas fa-shield-alt"></i>
                Pembayaran aman diproses oleh Midtrans
            </div>

        </div>
    </div>
</div>

{{-- Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    const payBtn = document.getElementById('pay-button');

    payBtn.onclick = function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('toko.riwayat') }}";
            },
            onPending: function (result) {
                window.location.href = "{{ route('toko.riwayat') }}";
            },
            onError: function (result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
                window.location.href = "{{ route('toko.riwayat') }}";
            },
            onClose: function () {
                alert('Kamu menutup popup pembayaran sebelum selesai.');
            }
        });
    };

    // Auto buka popup saat halaman load
    window.onload = function () {
        payBtn.click();
    };
</script>

@endsection