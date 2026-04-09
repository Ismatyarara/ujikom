@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .detail-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background:
            radial-gradient(circle at top right, rgba(79, 110, 247, 0.08), transparent 28%),
            linear-gradient(180deg, #f8f9ff 0%, #f4f6fb 100%);
        min-height: 100vh;
        padding: 28px 0 48px;
    }

    .btn-back {
        font-size: 0.8rem;
        font-weight: 600;
        color: #8b91a8;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 13px;
        border-radius: 8px;
        background: #fff;
        border: 1.5px solid #e8eaf2;
        transition: all .15s;
        margin-bottom: 20px;
    }
    .btn-back:hover { color: #4f6ef7; border-color: #4f6ef7; background: #f0f3ff; }

    /* Layout */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 768px) {
        .detail-layout { grid-template-columns: 1fr; }
    }

    /* Image */
    .detail-img-wrap {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #eef1f7;
        box-shadow: 0 10px 30px rgba(26,29,46,.06);
        overflow: hidden;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .detail-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .detail-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f2f8;
        color: #c4c9dc;
        font-size: 4rem;
    }

    /* Info card */
    .info-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #eef1f7;
        box-shadow: 0 10px 30px rgba(26,29,46,.06);
        padding: 28px;
    }

    .obat-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1d2e;
        line-height: 1.3;
        margin-bottom: 6px;
    }
    .obat-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4f6ef7;
        margin-bottom: 10px;
    }
    .obat-stock {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.76rem;
        font-weight: 600;
        color: #16a34a;
        background: #edfaf3;
        border-radius: 7px;
        padding: 4px 10px;
        margin-bottom: 20px;
    }

    /* Info sections */
    .info-divider {
        border: none;
        border-top: 1.5px solid #f0f2f8;
        margin: 16px 0;
    }
    .info-section { margin-bottom: 14px; }
    .info-section:last-of-type { margin-bottom: 0; }
    .info-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #a0a6c0;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 5px;
    }
    .info-text {
        font-size: 0.85rem;
        color: #5a607a;
        line-height: 1.6;
        font-weight: 500;
    }

    /* Qty + add to cart */
    .action-section {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1.5px solid #f0f2f8;
    }
    .qty-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #5a607a;
        margin-bottom: 8px;
    }
    .qty-row {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid #e8eaf2;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 14px;
    }
    .qty-btn {
        background: #f5f6fa;
        border: none;
        width: 36px;
        height: 36px;
        font-size: 1rem;
        font-weight: 600;
        color: #4f6ef7;
        cursor: pointer;
        transition: background .12s;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qty-btn:hover { background: #e8eaf2; }
    .qty-input {
        border: none;
        text-align: center;
        font-size: 0.9rem;
        font-weight: 700;
        color: #1a1d2e;
        width: 52px;
        background: #fff;
        outline: none;
        height: 36px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
    .qty-unit {
        font-size: 0.75rem;
        color: #a0a6c0;
        padding: 0 10px;
        font-weight: 600;
        background: #f5f6fa;
        height: 36px;
        display: flex;
        align-items: center;
        border-left: 1.5px solid #e8eaf2;
    }

    .btn-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .btn-add-cart {
        background: #4f6ef7;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 24px;
        font-size: 0.87rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: opacity .15s, transform .1s;
        width: 100%;
        justify-content: center;
    }
    .btn-add-cart.secondary {
        background: #eef2ff;
        color: #4f6ef7;
    }
    .btn-add-cart:hover { opacity: .87; }
    .btn-add-cart:active { transform: scale(.98); }
    .btn-add-cart i { font-size: .8rem; }
    .btn-add-cart:disabled {
        opacity: .65;
        cursor: wait;
        pointer-events: none;
    }
</style>

<div class="detail-wrap">
    <div class="container" style="max-width: 860px;">

        <a href="{{ route('toko.index') }}" class="btn-back">
            <i class="fas fa-arrow-left" style="font-size:.7rem;"></i> Kembali ke Toko
        </a>

        <div class="detail-layout">

            {{-- Foto --}}
            <div class="detail-img-wrap">
                @if($obat->foto)
                    <img src="{{ asset('storage/' . $obat->foto) }}"
                         class="detail-img" alt="{{ $obat->nama_obat }}">
                @else
                    <div class="detail-img-placeholder">
                        <i class="fas fa-pills"></i>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="info-card">
                <div class="obat-name">{{ $obat->nama_obat }}</div>
                <div class="obat-price">Rp {{ number_format($obat->harga, 0, ',', '.') }}</div>
                <div class="obat-stock">
                    <i class="fas fa-box" style="font-size:.65rem;"></i>
                    Stok {{ $obat->stok }} {{ $obat->satuan }}
                </div>

                @if($obat->deskripsi)
                    <hr class="info-divider">
                    <div class="info-section">
                        <div class="info-label">Deskripsi</div>
                        <div class="info-text">{{ $obat->deskripsi }}</div>
                    </div>
                @endif

                @if($obat->aturan_pakai)
                    <hr class="info-divider">
                    <div class="info-section">
                        <div class="info-label">Aturan Pakai</div>
                        <div class="info-text">{{ $obat->aturan_pakai }}</div>
                    </div>
                @endif

                @if($obat->efek_samping)
                    <hr class="info-divider">
                    <div class="info-section">
                        <div class="info-label">Efek Samping</div>
                        <div class="info-text">{{ $obat->efek_samping }}</div>
                    </div>
                @endif

                {{-- Form --}}
                <div class="action-section">
                    <form action="{{ route('toko.tambahKeranjang') }}" method="POST"
                          onsubmit="return submitObatDetail(this)">
                        @csrf
                        <input type="hidden" name="id_obat" value="{{ $obat->id }}">
                        <input type="hidden" name="jumlah" class="jumlah-hidden">

                        <div class="qty-label">Jumlah</div>
                        <div class="qty-row">
                            <button type="button" class="qty-btn"
                                    onclick="stepQty(-1)">−</button>
                            <input type="number" id="qty-detail" class="qty-input"
                                   value="1" min="1" max="{{ $obat->stok }}">
                            <span class="qty-unit">{{ $obat->satuan }}</span>
                            <button type="button" class="qty-btn"
                                    onclick="stepQty(1, {{ $obat->stok }})">+</button>
                        </div>

                        <div class="btn-actions">
                            <button type="submit" class="btn-add-cart secondary">
                                <i class="fas fa-cart-plus"></i> Keranjang
                            </button>

                            <button
                                type="submit"
                                class="btn-add-cart"
                                formaction="{{ route('toko.beliSekarang') }}"
                                data-loading-text="Memproses..."
                            >
                                <i class="fas fa-bolt"></i> Beli Sekarang
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function stepQty(delta, max) {
        const input = document.getElementById('qty-detail');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        if (max && val > max) val = max;
        input.value = val;
    }

    function submitObatDetail(form) {
        const input = document.getElementById('qty-detail');
        const qty = parseInt(input.value || 1, 10);
        const min = parseInt(input.min || 1, 10);
        const max = parseInt(input.max || qty, 10);
        const finalQty = Math.min(Math.max(qty, min), max);

        input.value = finalQty;
        form.querySelector('.jumlah-hidden').value = finalQty;

        const submitter = document.activeElement;
        const buttons = form.querySelectorAll('button[type="submit"]');
        buttons.forEach((button) => {
            button.disabled = true;
        });

        if (submitter && submitter.tagName === 'BUTTON') {
            submitter.textContent = submitter.dataset.loadingText || 'Memproses...';
        }

        return true;
    }
</script>

@endsection
