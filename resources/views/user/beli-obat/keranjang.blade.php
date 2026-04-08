@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .keranjang-wrap {
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

    /* Alert */
    .alert-slim {
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.83rem;
        margin-bottom: 16px;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 72px 0;
        color: #a0a6c0;
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 14px;
        display: block;
        opacity: .4;
    }
    .empty-state p {
        font-size: 0.9rem;
        margin-bottom: 18px;
        font-weight: 500;
    }
    .btn-mulai {
        background: #4f6ef7;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity .15s;
    }
    .btn-mulai:hover { opacity: .85; color: #fff; }

    /* Layout */
    .keranjang-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 768px) {
        .keranjang-layout { grid-template-columns: 1fr; }
    }

    /* Item list card */
    .list-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #eef1f7;
        box-shadow: 0 10px 30px rgba(26,29,46,.06);
        overflow: hidden;
    }
    .list-card-header {
        padding: 13px 16px;
        border-bottom: 1.5px solid #f0f2f8;
        font-size: 0.8rem;
        font-weight: 700;
        color: #8b91a8;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    /* Cart item row */
    .cart-item {
        display: flex;
        align-items: center;
        padding: 13px 16px;
        gap: 14px;
        border-bottom: 1.5px solid #f5f6fa;
        transition: background .12s;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: #fafbff; }

    .item-info { flex: 1; min-width: 0; }
    .item-name {
        font-size: 0.87rem;
        font-weight: 700;
        color: #1a1d2e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }
    .item-price {
        font-size: 0.76rem;
        color: #a0a6c0;
        font-weight: 500;
    }

    /* Qty stepper */
    .qty-row {
        display: flex;
        align-items: center;
        border: 1.5px solid #e8eaf2;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .qty-btn {
        background: #f5f6fa;
        border: none;
        width: 28px;
        height: 28px;
        font-size: 0.95rem;
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
        font-size: 0.82rem;
        font-weight: 600;
        color: #1a1d2e;
        width: 38px;
        background: #fff;
        outline: none;
        height: 28px;
        font-family: inherit;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

    /* Subtotal */
    .item-subtotal {
        font-size: 0.87rem;
        font-weight: 700;
        color: #4f6ef7;
        min-width: 90px;
        text-align: right;
        flex-shrink: 0;
    }

    /* Delete btn */
    .btn-hapus {
        background: none;
        border: none;
        color: #d0d4e4;
        cursor: pointer;
        padding: 4px 6px;
        border-radius: 6px;
        font-size: 0.8rem;
        transition: color .15s, background .15s;
        flex-shrink: 0;
        text-decoration: none;
    }
    .btn-hapus:hover { color: #ef4444; background: #fff0f0; }

    /* Summary card */
    .summary-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #eef1f7;
        box-shadow: 0 10px 30px rgba(26,29,46,.06);
        padding: 18px;
        position: sticky;
        top: 20px;
    }
    .summary-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 14px;
    }
    .summary-note {
        font-size: 0.76rem;
        color: #8b91a8;
        line-height: 1.5;
        margin-bottom: 14px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.82rem;
        color: #8b91a8;
        margin-bottom: 8px;
        font-weight: 500;
    }
    .summary-divider {
        border: none;
        border-top: 1.5px solid #f0f2f8;
        margin: 12px 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 0.92rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 16px;
    }
    .summary-total-price { color: #4f6ef7; }

    .btn-checkout {
        width: 100%;
        background: #4f6ef7;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
        transition: opacity .15s;
        font-family: inherit;
    }
    .btn-checkout:hover { opacity: .87; color: #fff; }
</style>

<div class="keranjang-wrap">
    <div class="container" style="max-width: 900px;">

        {{-- Header --}}
        <div class="page-header">
            <div class="page-title">🛒 Keranjang Belanja</div>
            <a href="{{ route('toko.index') }}" class="btn-back">
                <i class="fas fa-arrow-left" style="font-size:.7rem;"></i> Lanjut Belanja
            </a>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-slim alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Empty --}}
        @if(empty($keranjang))
            <div class="list-card">
                <div class="empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <p>Keranjang kamu masih kosong</p>
                    <a href="{{ route('toko.index') }}" class="btn-mulai">Mulai Belanja</a>
                </div>
            </div>

        {{-- Isi keranjang --}}
        @else
            <div class="keranjang-layout">

                {{-- Item List --}}
                <div class="list-card">
                    <div class="list-card-header">{{ count($keranjang) }} item di keranjang</div>

                    @foreach($keranjang as $id => $item)
                        <div class="cart-item">
                            <div class="item-info">
                                <div class="item-name">{{ $item['nama_obat'] }}</div>
                                <div class="item-price">Rp {{ number_format($item['harga'], 0, ',', '.') }} / satuan</div>
                            </div>

                            {{-- Qty stepper --}}
                            <form action="{{ route('toko.updateKeranjang') }}" method="POST" id="form-{{ $id }}">
                                @csrf
                                <input type="hidden" name="id_obat" value="{{ $id }}">
                                <div class="qty-row">
                                    <button type="button" class="qty-btn"
                                        onclick="stepQty('{{ $id }}', -1)">−</button>
                                    <input type="number" name="jumlah" id="qty-{{ $id }}"
                                           class="qty-input"
                                           value="{{ $item['jumlah'] }}" min="1"
                                           onchange="submitForm('{{ $id }}')">
                                    <button type="button" class="qty-btn"
                                        onclick="stepQty('{{ $id }}', 1)">+</button>
                                </div>
                            </form>

                            <div class="item-subtotal">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>

                            <a href="{{ route('toko.hapusKeranjang', $id) }}"
                               class="btn-hapus"
                               onclick="return confirm('Hapus item ini?')"
                               title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Summary --}}
                <div class="summary-card">
                    <div class="summary-title">Ringkasan Belanja</div>
                    <div class="summary-note">Pastikan jumlah item sudah benar sebelum lanjut ke proses checkout.</div>
                    <div class="summary-row">
                        <span>Total Item</span>
                        <span>{{ count($keranjang) }} item</span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-total">
                        <span>Total Harga</span>
                        <span class="summary-total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('toko.checkout') }}" class="btn-checkout">
                        <i class="fas fa-credit-card" style="font-size:.8rem;"></i>
                        Lanjut Checkout
                    </a>
                </div>

            </div>
        @endif

    </div>
</div>

<script>
    function stepQty(id, delta) {
        const input = document.getElementById('qty-' + id);
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
        submitForm(id);
    }

    function submitForm(id) {
        document.getElementById('form-' + id).submit();
    }
</script>

@endsection
