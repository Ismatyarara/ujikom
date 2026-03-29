@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">📋 Riwayat Transaksi</h2>
        <a href="{{ route('toko.index') }}" class="btn btn-primary">
            <i class="fas fa-shopping-bag"></i> Belanja Lagi
        </a>
    </div>

    @if($transaksi->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada transaksi</h5>
            <a href="{{ route('toko.index') }}" class="btn btn-primary mt-2">Mulai Belanja</a>
        </div>
    @else
        @foreach($transaksi as $trx)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $trx->kode_transaksi }}</strong>
                        <span class="text-muted small ms-2">
                            {{ $trx->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                    @php
                        $badge = match($trx->status) {
                            'pending'      => 'warning',
                            'dibayar'      => 'info',
                            'diverifikasi' => 'primary',
                            'selesai'      => 'success',
                            'dibatalkan'   => 'danger',
                            'expired'      => 'secondary',
                            default        => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $badge }} text-capitalize">
                        {{ $trx->status }}
                    </span>
                </div>

                <div class="card-body">
                    {{-- Detail Item --}}
                    <div class="table-responsive">
                        <table class="table table-sm mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Obat</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trx->details as $detail)
                                    <tr>
                                        <td>{{ $detail->obat->nama_obat ?? '-' }}</td>
                                        <td>{{ $detail->jumlah }} {{ $detail->obat->satuan ?? '' }}</td>
                                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Info Pengiriman & Total --}}
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Alamat Pengiriman:</small>
                            <p class="mb-1">{{ $trx->alamat_pengiriman }}</p>
                            <small class="text-muted">No. Telepon: {{ $trx->no_telepon }}</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="fw-bold fs-5">
                                Total: <span class="text-primary">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                            </div>
                            @if($trx->payment_type)
                                <small class="text-muted">Via: {{ ucfirst(str_replace('_', ' ', $trx->payment_type)) }}</small>
                            @endif

                            {{-- Tombol bayar ulang jika masih pending dan ada snap_token --}}
                            @if($trx->status === 'pending' && $trx->snap_token)
                                <div class="mt-2">
                                    <button class="btn btn-warning btn-sm"
                                            onclick="bayarUlang('{{ $trx->snap_token }}')">
                                        <i class="fas fa-redo"></i> Bayar Sekarang
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $transaksi->links() }}
        </div>
    @endif

</div>

{{-- Midtrans Snap untuk bayar ulang --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
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