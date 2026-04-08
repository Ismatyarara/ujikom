@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .riwayat-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f5f6fa;
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
    .btn-belanja {
        background: #4f6ef7;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        font-size: 0.82rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: opacity .15s;
    }
    .btn-belanja:hover { opacity: .87; color: #fff; }

    /* Empty */
    .empty-state {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,.07);
        text-align: center;
        padding: 64px 0;
        color: #a0a6c0;
    }
    .empty-state i { font-size: 2.8rem; opacity: .35; display: block; margin-bottom: 14px; }
    .empty-state p { font-size: 0.88rem; font-weight: 500; margin-bottom: 18px; }
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
        display: inline-block;
    }
    .btn-mulai:hover { opacity: .87; color: #fff; }

    /* Transaction card */
    .trx-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,.07);
        margin-bottom: 14px;
        overflow: hidden;
        transition: box-shadow .18s;
    }
    .trx-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.09); }

    /* Card header */
    .trx-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-bottom: 1.5px solid #f5f6fa;
        gap: 10px;
        flex-wrap: wrap;
    }
    .trx-code {
        font-size: 0.83rem;
        font-weight: 700;
        color: #1a1d2e;
        margin-bottom: 1px;
    }
    .trx-date {
        font-size: 0.72rem;
        color: #a0a6c0;
        font-weight: 500;
    }

    /* Status badge */
    .status-badge {
        font-size: 0.71rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: capitalize;
        flex-shrink: 0;
    }
    .status-pending      { background: #fff8e6; color: #d97706; }
    .status-dibayar      { background: #e8f4ff; color: #2563eb; }
    .status-diverifikasi { background: #edf0ff; color: #4f6ef7; }
    .status-selesai      { background: #edfaf3; color: #16a34a; }
    .status-dibatalkan   { background: #fff0f0; color: #ef4444; }
    .status-expired      { background: #f5f6fa; color: #8b91a8; }

    /* Card body */
    .trx-body { padding: 14px 16px; }

    /* Items list */
    .item-list { margin-bottom: 14px; }
    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1.5px solid #f5f6fa;
        gap: 10px;
    }
    .item-row:last-child { border-bottom: none; }
    .item-row-name {
        font-size: 0.83rem;
        font-weight: 600;
        color: #1a1d2e;
    }
    .item-row-qty {
        font-size: 0.74rem;
        color: #a0a6c0;
        font-weight: 500;
        margin-top: 1px;
    }
    .item-row-subtotal {
        font-size: 0.83rem;
        font-weight: 700;
        color: #1a1d2e;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Footer row */
    .trx-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-top: 12px;
        border-top: 1.5px solid #f0f2f8;
        gap: 12px;
        flex-wrap: wrap;
    }
    .trx-footer-left { font-size: 0.77rem; color: #8b91a8; line-height: 1.6; }
    .trx-footer-left strong { color: #5a607a; font-weight: 600; }

    .trx-footer-right { text-align: right; }
    .trx-total-label { font-size: 0.74rem; color: #a0a6c0; font-weight: 500; margin-bottom: 1px; }
    .trx-total-price { font-size: 1rem; font-weight: 700; color: #4f6ef7; }
    .trx-via { font-size: 0.72rem; color: #a0a6c0; margin-top: 2px; }

    /* Bayar ulang */
    .btn-bayar-ulang {
        background: #fff8e6;
        color: #d97706;
        border: 1.5px solid #fde68a;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.77rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all .15s;
        margin-top: 8px;
    }
    .btn-bayar-ulang:hover { background: #fef3c7; border-color: #f59e0b; }

    /* Pagination */
    .toko-pagination {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }
</style>

<div class="riwayat-wrap">
    <div class="container" style="max-width: 820px;">

        {{-- Header --}}
        <div class="page-header">
            <div class="page-title">📋 Riwayat Transaksi</div>
            <a href="{{ route('toko.index') }}" class="btn-belanja">
                <i class="fas fa-shopping-bag" style="font-size:.8rem;"></i> Belanja Lagi
            </a>
        </div>

        {{-- Empty --}}
        @if($transaksi->isEmpty())
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <p>Belum ada transaksi</p>
                <a href="{{ route('toko.index') }}" class="btn-mulai">Mulai Belanja</a>
            </div>

        @else
            @foreach($transaksi as $trx)
                @php
                    $statusClass = match($trx->status) {
                        'pending'      => 'status-pending',
                        'dibayar'      => 'status-dibayar',
                        'diverifikasi' => 'status-diverifikasi',
                        'selesai'      => 'status-selesai',
                        'dibatalkan'   => 'status-dibatalkan',
                        default        => 'status-expired',
                    };
                @endphp

                <div class="trx-card">

                    {{-- Header --}}
                    <div class="trx-header">
                        <div>
                            <div class="trx-code">{{ $trx->kode_transaksi }}</div>
                            <div class="trx-date">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="status-badge {{ $statusClass }}">{{ $trx->status }}</span>
                    </div>

                    {{-- Body --}}
                    <div class="trx-body">

                        {{-- Items --}}
                        <div class="item-list">
                            @foreach($trx->details as $detail)
                                <div class="item-row">
                                    <div>
                                        <div class="item-row-name">{{ $detail->obat->nama_obat ?? '-' }}</div>
                                        <div class="item-row-qty">
                                            {{ $detail->jumlah }} {{ $detail->obat->satuan ?? '' }}
                                            × Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="item-row-subtotal">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Footer --}}
                        <div class="trx-footer">
                            <div class="trx-footer-left">
                                <div><strong>Alamat:</strong> {{ $trx->alamat_pengiriman }}</div>
                                <div><strong>Telp:</strong> {{ $trx->no_telepon }}</div>
                            </div>
                            <div class="trx-footer-right">
                                <div class="trx-total-label">Total Pembayaran</div>
                                <div class="trx-total-price">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</div>
                                @if($trx->payment_type)
                                    <div class="trx-via">Via {{ ucfirst(str_replace('_', ' ', $trx->payment_type)) }}</div>
                                @endif
                                @if($trx->status === 'pending' && $trx->snap_token)
                                    <button class="btn-bayar-ulang"
                                            onclick="bayarUlang('{{ $trx->snap_token }}')">
                                        <i class="fas fa-redo" style="font-size:.65rem;"></i> Bayar Sekarang
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

            <div class="toko-pagination">
                {{ $transaksi->links() }}
            </div>
        @endif

    </div>
</div>

<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function bayarUlang(snapToken) {
        window.snap.pay(snapToken, {
            onSuccess: function () { location.reload(); },
            onPending: function () { location.reload(); },
            onError:   function () { alert('Pembayaran gagal.'); },
            onClose:   function () {}
        });
    }
</script>

@endsection
