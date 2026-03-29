@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow">
                    <div class="card-body py-5">
                        <i class="fas fa-credit-card fa-3x text-primary mb-3"></i>
                        <h4 class="fw-bold">Selesaikan Pembayaran</h4>
                        <p class="text-muted mb-1">Kode Transaksi: <strong>{{ $transaksi->kode_transaksi }}</strong></p>
                        <h3 class="text-primary mb-4">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </h3>
                        {{-- DEBUG: hapus setelah selesai --}}
                        <p>Client Key: {{ config('midtrans.client_key') }}</p>
                        <p>Token: {{ $snapToken }}</p>
                        <button id="pay-button" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-lock"></i> Bayar Sekarang
                        </button>

                        <p class="text-muted small mt-3">
                            Kamu akan diarahkan ke halaman pembayaran Midtrans yang aman.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script>
        document.getElementById('pay-button').onclick = function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('toko.riwayat') }}";
                },
                onPending: function(result) {
                    window.location.href = "{{ route('toko.riwayat') }}";
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    window.location.href = "{{ route('toko.riwayat') }}";
                },
                onClose: function() {
                    alert('Kamu menutup popup pembayaran sebelum selesai.');
                }
            });
        };

        // Auto buka popup saat halaman load
        window.onload = function() {
            document.getElementById('pay-button').click();
        };
    </script>
@endsection
