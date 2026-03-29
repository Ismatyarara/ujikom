@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold mb-4">📦 Checkout</h2>

    <div class="row">
        {{-- Form Pengiriman --}}
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">Data Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('toko.prosesCheckout') }}" method="POST" id="form-checkout">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Penerima</label>
                            <input type="text" class="form-control"
                                   value="{{ auth()->user()->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telepon"
                                   class="form-control @error('no_telepon') is-invalid @enderror"
                                   value="{{ old('no_telepon') }}"
                                   placeholder="Contoh: 08123456789" required>
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Pengiriman <span class="text-danger">*</span></label>
                            <textarea name="alamat_pengiriman" rows="3"
                                      class="form-control @error('alamat_pengiriman') is-invalid @enderror"
                                      placeholder="Masukkan alamat lengkap..." required>{{ old('alamat_pengiriman') }}</textarea>
                            @error('alamat_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan (opsional)</label>
                            <textarea name="catatan" rows="2"
                                      class="form-control"
                                      placeholder="Catatan tambahan untuk pesanan...">{{ old('catatan') }}</textarea>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($keranjang as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item['nama_obat'] }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                    </small>
                                </div>
                                <span class="fw-semibold">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-primary fs-5">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <button type="submit" form="form-checkout" class="btn btn-primary w-100 btn-lg">
                <i class="fas fa-lock"></i> Bayar Sekarang
            </button>

            <a href="{{ route('toko.keranjang') }}" class="btn btn-outline-secondary w-100 mt-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
            </a>
        </div>
    </div>

</div>
@endsection