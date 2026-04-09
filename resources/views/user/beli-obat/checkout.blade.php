@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .checkout-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background:
            radial-gradient(circle at top right, rgba(79, 110, 247, 0.08), transparent 28%),
            linear-gradient(180deg, #f8f9ff 0%, #f4f6fb 100%);
        min-height: 100vh;
        padding: 28px 0 48px;
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }
    .page-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1d2e;
        letter-spacing: -0.3px;
    }
    .btn-back {
        font-size: 0.8rem;
        font-weight: 600;
        color: #8b91a8;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 13px;
        border-radius: 8px;
        background: #fff;
        border: 1.5px solid #e8eaf2;
        transition: all .15s;
    }
    .btn-back:hover { color: #4f6ef7; border-color: #4f6ef7; background: #f0f3ff; }

    /* Layout */
    .checkout-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 768px) {
        .checkout-layout { grid-template-columns: 1fr; }
    }

    /* Section card */
    .section-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #eef1f7;
        box-shadow: 0 10px 30px rgba(26,29,46,.06);
        overflow: hidden;
        margin-bottom: 16px;
    }
    .section-card:last-child { margin-bottom: 0; }
    .section-header {
        padding: 13px 18px;
        border-bottom: 1.5px solid #f0f2f8;
        font-size: 0.8rem;
        font-weight: 700;
        color: #8b91a8;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .section-body { padding: 18px; }

    /* Form fields */
    .field-group { margin-bottom: 15px; }
    .field-group:last-child { margin-bottom: 0; }

    .field-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #5a607a;
        margin-bottom: 6px;
        display: block;
    }
    .field-label .req { color: #ef4444; margin-left: 2px; }

    .field-input {
        width: 100%;
        border: 1.5px solid #e8eaf2;
        border-radius: 9px;
        padding: 9px 12px;
        font-size: 0.85rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1a1d2e;
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        resize: none;
        box-sizing: border-box;
    }
    .field-input:focus {
        border-color: #4f6ef7;
        box-shadow: 0 0 0 3px rgba(79,110,247,.1);
    }
    .field-input:disabled {
        background: #f5f6fa;
        color: #a0a6c0;
        cursor: not-allowed;
    }
    .field-input.is-invalid { border-color: #ef4444; }
    .field-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,.1); }
    .field-error {
        font-size: 0.75rem;
        color: #ef4444;
        font-weight: 500;
        margin-top: 5px;
    }

    /* Order summary */
    .summary-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #eef1f7;
        box-shadow: 0 10px 30px rgba(26,29,46,.06);
        overflow: hidden;
        position: sticky;
        top: 20px;
    }
    .summary-caption {
        font-size: 0.76rem;
        color: #8b91a8;
        line-height: 1.5;
        padding: 0 18px 14px;
        border-bottom: 1.5px solid #f0f2f8;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 11px 18px;
        border-bottom: 1.5px solid #f5f6fa;
        gap: 12px;
    }
    .order-item:last-child { border-bottom: none; }

    .order-item-name {
        font-size: 0.83rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 2px;
    }
    .order-item-qty {
        font-size: 0.74rem;
        color: #a0a6c0;
        font-weight: 500;
    }
    .order-item-price {
        font-size: 0.83rem;
        font-weight: 700;
        color: #1a1d2e;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 13px 18px;
        background: #f8f9ff;
        border-top: 1.5px solid #e8eaf2;
    }
    .order-total-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1a1d2e;
    }
    .order-total-price {
        font-size: 1rem;
        font-weight: 700;
        color: #4f6ef7;
    }

    /* Action buttons */
    .action-wrap { padding: 14px 18px 18px; }
    .btn-bayar {
        width: 100%;
        background: #4f6ef7;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: opacity .15s;
        margin-bottom: 8px;
    }
    .btn-bayar:hover { opacity: .87; }
    .btn-bayar i { font-size: .8rem; }
    .btn-bayar:disabled {
        opacity: .65;
        cursor: wait;
        pointer-events: none;
    }
</style>

<div class="checkout-wrap">
    <div class="container" style="max-width: 920px;">

        {{-- Header --}}
        <div class="page-header">
            <div class="page-title">📦 Checkout</div>
            <a href="{{ route('toko.keranjang') }}" class="btn-back">
                <i class="fas fa-arrow-left" style="font-size:.7rem;"></i> Kembali ke Keranjang
            </a>
        </div>

        <div class="checkout-layout">

            {{-- Kiri: Form --}}
            <div>
                <form action="{{ route('toko.prosesCheckout') }}" method="POST" id="form-checkout">
                    @csrf

                    <div class="section-card">
                        <div class="section-header">Data Pengiriman</div>
                        <div class="section-body">

                            <div class="field-group">
                                <label class="field-label">Nama Penerima</label>
                                <input type="text" class="field-input"
                                       value="{{ auth()->user()->name }}" disabled>
                            </div>

                            <div class="field-group">
                                <label class="field-label">
                                    No. Telepon <span class="req">*</span>
                                </label>
                                <input type="text" name="no_telepon"
                                       class="field-input @error('no_telepon') is-invalid @enderror"
                                       value="{{ old('no_telepon') }}"
                                       placeholder="Contoh: 08123456789" required>
                                @error('no_telepon')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="field-label">
                                    Alamat Pengiriman <span class="req">*</span>
                                </label>
                                <textarea name="alamat_pengiriman" rows="3"
                                          class="field-input @error('alamat_pengiriman') is-invalid @enderror"
                                          placeholder="Masukkan alamat lengkap..." required>{{ old('alamat_pengiriman') }}</textarea>
                                @error('alamat_pengiriman')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="field-label">Catatan <span style="color:#a0a6c0;font-weight:500;">(opsional)</span></label>
                                <textarea name="catatan" rows="2"
                                          class="field-input"
                                          placeholder="Catatan tambahan untuk pesanan...">{{ old('catatan') }}</textarea>
                            </div>

                        </div>
                    </div>

                </form>
            </div>

            {{-- Kanan: Summary + Bayar --}}
            <div>
                <div class="summary-card">
                    <div class="section-header" style="padding: 13px 18px;">Ringkasan Pesanan</div>
                    <div class="summary-caption">
                        Cek kembali jumlah item dan data pengiriman sebelum melanjutkan pembayaran.
                    </div>

                    @foreach($keranjang as $item)
                        <div class="order-item">
                            <div>
                                <div class="order-item-name">{{ $item['nama_obat'] }}</div>
                                <div class="order-item-qty">
                                    {{ $item['jumlah'] }} × Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="order-item-price">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach

                    <div class="order-total">
                        <span class="order-total-label">Total Pembayaran</span>
                        <span class="order-total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="action-wrap">
                        <button type="submit" form="form-checkout" class="btn-bayar">
                            <i class="fas fa-lock"></i> Bayar Sekarang
                        </button>
                        <a href="{{ route('toko.keranjang') }}" class="btn-back w-100 justify-content-center"
                           style="display:flex;">
                            <i class="fas fa-arrow-left" style="font-size:.7rem;"></i> Edit Keranjang
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('form-checkout')?.addEventListener('submit', function () {
        const submitButton = document.querySelector('.btn-bayar');

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        }
    });
</script>

@endsection
