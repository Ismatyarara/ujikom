@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">🛒 Keranjang Belanja</h2>
        <a href="{{ route('toko.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Lanjut Belanja
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(empty($keranjang))
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Keranjang kamu kosong</h5>
            <a href="{{ route('toko.index') }}" class="btn btn-primary mt-2">Mulai Belanja</a>
        </div>
    @else
        <div class="row">
            {{-- Daftar Item --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Obat</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keranjang as $id => $item)
                                    <tr>
                                        <td class="align-middle">
                                            <strong>{{ $item['nama_obat'] }}</strong>
                                        </td>
                                        <td class="align-middle">
                                            Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                        </td>
                                        <td class="align-middle" style="width: 130px;">
                                            <form action="{{ route('toko.updateKeranjang') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_obat" value="{{ $id }}">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="jumlah"
                                                           class="form-control"
                                                           value="{{ $item['jumlah'] }}"
                                                           min="1" onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td class="align-middle">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('toko.hapusKeranjang', $id) }}"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Hapus item ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Item</span>
                            <span>{{ count($keranjang) }} item</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold mb-3">
                            <span>Total Harga</span>
                            <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('toko.checkout') }}" class="btn btn-primary w-100">
                            <i class="fas fa-credit-card"></i> Lanjut Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection