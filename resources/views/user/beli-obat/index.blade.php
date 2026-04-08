@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .toko-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background:
            radial-gradient(circle at top right, rgba(79, 110, 247, 0.08), transparent 28%),
            linear-gradient(180deg, #f8f9ff 0%, #f4f6fb 100%);
        min-height: 100vh;
        padding: 28px 0 48px;
    }

    /* Header */
    .toko-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }
    .toko-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1d2e;
        letter-spacing: -0.3px;
    }
    .toko-title span {
        font-size: 1.1rem;
    }
    .search-form {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
        background: #fff;
        border: 1px solid #e7ebf5;
        border-radius: 14px;
        padding: 10px;
        box-shadow: 0 10px 30px rgba(26,29,46,.05);
    }
    .search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.88rem;
        color: #1a1d2e;
        background: transparent;
        padding: 4px 8px;
    }
    .search-input::placeholder {
        color: #9aa3bd;
    }
    .search-btn,
    .search-reset {
        border: none;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .search-btn {
        background: #4f6ef7;
        color: #fff;
    }
    .search-reset {
        background: #eef2ff;
        color: #4f6ef7;
    }
    .search-meta {
        margin-top: -8px;
        margin-bottom: 18px;
        font-size: 0.8rem;
        color: #7f879f;
    }

    /* Cart button */
    .btn-cart {
        background: #1a1d2e;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        font-size: 0.82rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 7px;
        position: relative;
        transition: background .18s;
        text-decoration: none;
    }
    .btn-cart:hover { background: #2e3350; color: #fff; }
    .btn-cart .badge-count {
        position: absolute;
        top: -7px;
        right: -7px;
        background: #ef4444;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Alert */
    .alert-slim {
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.83rem;
        margin-bottom: 16px;
    }

    /* Card Grid */
    .obat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }

    /* Card */
    .obat-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #eef1f7;
        box-shadow: 0 10px 30px rgba(26,29,46,.06);
        transition: transform .18s, box-shadow .18s;
        display: flex;
        flex-direction: column;
    }
    .obat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 38px rgba(26,29,46,.12);
    }

    /* Image */
    .obat-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
    }
    .obat-img-placeholder {
        width: 100%;
        height: 140px;
        background: #f0f2f8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #c4c9dc;
        font-size: 2rem;
    }

    /* Body */
    .obat-body {
        padding: 12px 13px 13px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .obat-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 3px;
        line-height: 1.3;
    }
    .obat-desc {
        font-size: 0.75rem;
        color: #8b91a8;
        line-height: 1.4;
        margin-bottom: 10px;
        flex: 1;
    }

    /* Price row */
    .obat-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 9px;
    }
    .obat-price {
        font-size: 0.95rem;
        font-weight: 700;
        color: #4f6ef7;
    }
    .obat-stock {
        font-size: 0.7rem;
        font-weight: 600;
        color: #5bb97b;
        background: #edfaf3;
        border-radius: 6px;
        padding: 2px 7px;
    }

    /* Qty input */
    .qty-row {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 8px;
        border: 1.5px solid #e8eaf2;
        border-radius: 8px;
        overflow: hidden;
    }
    .qty-btn {
        background: #f5f6fa;
        border: none;
        width: 30px;
        height: 30px;
        font-size: 1rem;
        font-weight: 600;
        color: #4f6ef7;
        cursor: pointer;
        transition: background .12s;
        flex-shrink: 0;
    }
    .qty-btn:hover { background: #e8eaf2; }
    .qty-input {
        border: none;
        text-align: center;
        font-size: 0.82rem;
        font-weight: 600;
        color: #1a1d2e;
        width: 100%;
        background: #fff;
        outline: none;
        height: 30px;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
    .qty-unit {
        font-size: 0.7rem;
        color: #a0a6c0;
        padding: 0 8px;
        flex-shrink: 0;
        font-weight: 500;
    }

    /* Action buttons */
    .obat-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-bottom: 6px;
    }
    .btn-obat {
        border: none;
        border-radius: 8px;
        padding: 7px 6px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity .15s, transform .1s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }
    .btn-obat:active { transform: scale(.97); }
    .btn-obat.outline {
        background: #f0f3ff;
        color: #4f6ef7;
    }
    .btn-obat.outline:hover { background: #e0e6ff; }
    .btn-obat.solid {
        background: #4f6ef7;
        color: #fff;
    }
    .btn-obat.solid:hover { opacity: .88; }
    .btn-detail {
        display: block;
        text-align: center;
        font-size: 0.73rem;
        font-weight: 600;
        color: #a0a6c0;
        text-decoration: none;
        padding: 4px;
        border-radius: 6px;
        transition: color .15s, background .15s;
    }
    .btn-detail:hover { color: #4f6ef7; background: #f0f3ff; }

    /* Empty */
    .obat-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 48px 0;
        color: #a0a6c0;
        font-size: 0.88rem;
    }
    .obat-empty i { font-size: 2.5rem; margin-bottom: 12px; display: block; }

    /* Pagination */
    .toko-pagination {
        display: flex;
        justify-content: center;
        margin-top: 28px;
    }
</style>

<div class="toko-wrap">
    <div class="container" style="max-width: 1100px;">

        {{-- Header --}}
        <div class="toko-header">
            <div class="toko-title">
                <span>🏪</span> Toko Obat
            </div>
            <a href="{{ route('toko.keranjang') }}" class="btn-cart">
                <i class="fas fa-shopping-bag" style="font-size:.8rem;"></i>
                Keranjang
                @if($totalKeranjang > 0)
                    <span class="badge-count">{{ $totalKeranjang }}</span>
                @endif
            </a>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-slim alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-slim alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('toko.index') }}" method="GET" class="search-form">
            <i class="fas fa-search" style="color:#9aa3bd; padding-left:6px;"></i>
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                class="search-input"
                placeholder="Cari nama obat, kode obat, atau deskripsi..."
            >
            <button type="submit" class="search-btn">
                Cari
            </button>
            @if(!empty($search))
                <a href="{{ route('toko.index') }}" class="search-reset">Reset</a>
            @endif
        </form>

        @if(!empty($search))
            <div class="search-meta">
                Hasil pencarian untuk: <strong>{{ $search }}</strong>
            </div>
        @endif

        {{-- Grid --}}
        <div class="obat-grid">
            @forelse($obat as $item)
                <div class="obat-card">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}"
                             class="obat-img" alt="{{ $item->nama_obat }}">
                    @else
                        <div class="obat-img-placeholder">
                            <i class="fas fa-pills"></i>
                        </div>
                    @endif

                    <div class="obat-body">
                        <div class="obat-name">{{ $item->nama_obat }}</div>
                        <div class="obat-desc">{{ Str::limit($item->deskripsi, 80) }}</div>

                        <div class="obat-meta">
                            <div class="obat-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                            <div class="obat-stock">Stok {{ $item->stok }}</div>
                        </div>

                        {{-- Qty Stepper --}}
                        <div class="qty-row">
                            <button type="button" class="qty-btn"
                                onclick="changeQty({{ $item->id }}, -1)">−</button>
                            <input type="number" id="jumlah-{{ $item->id }}"
                                   class="qty-input" value="1"
                                   min="1" max="{{ $item->stok }}">
                            <span class="qty-unit">{{ $item->satuan }}</span>
                            <button type="button" class="qty-btn"
                                onclick="changeQty({{ $item->id }}, 1, {{ $item->stok }})">+</button>
                        </div>

                        {{-- Actions --}}
                        <div class="obat-actions">
                            <form action="{{ route('toko.tambahKeranjang') }}" method="POST"
                                  onsubmit="syncJumlah({{ $item->id }}, this)">
                                @csrf
                                <input type="hidden" name="id_obat" value="{{ $item->id }}">
                                <input type="hidden" name="jumlah" class="jumlah-hidden">
                                <button type="submit" class="btn-obat outline w-100">
                                    <i class="fas fa-cart-plus" style="font-size:.7rem;"></i> Keranjang
                                </button>
                            </form>

                            <form action="{{ route('toko.beliSekarang') }}" method="POST"
                                  onsubmit="syncJumlah({{ $item->id }}, this)">
                                @csrf
                                <input type="hidden" name="id_obat" value="{{ $item->id }}">
                                <input type="hidden" name="jumlah" class="jumlah-hidden">
                                <button type="submit" class="btn-obat solid w-100">
                                    <i class="fas fa-bolt" style="font-size:.7rem;"></i> Beli
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('toko.show', $item->id) }}" class="btn-detail">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @empty
                <div class="obat-empty">
                    <i class="fas fa-box-open"></i>
                    {{ !empty($search) ? 'Obat yang kamu cari belum ditemukan.' : 'Belum ada obat yang tersedia.' }}
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="toko-pagination">
            {{ $obat->links() }}
        </div>

    </div>
</div>

<script>
    function syncJumlah(id, form) {
        const jumlah = document.getElementById('jumlah-' + id).value;
        form.querySelector('.jumlah-hidden').value = jumlah;
    }

    function changeQty(id, delta, max) {
        const input = document.getElementById('jumlah-' + id);
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        if (max && val > max) val = max;
        input.value = val;
    }
</script>

@endsection
