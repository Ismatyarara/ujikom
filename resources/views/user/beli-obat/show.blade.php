@extends('layouts.app')

@section('content')
<div class="container py-4">

    <a href="{{ route('toko.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Kembali ke Toko
    </a>

    <div class="row">
        {{-- Foto Obat --}}
        <div class="col-md-5 mb-4">
            @if($obat->foto)
                <img src="{{ asset('storage/' . $obat->foto) }}"
                     class="img-fluid rounded shadow" alt="{{ $obat->nama_obat }}">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center shadow"
                     style="height: 350px;">
                    <i class="fas fa-pills fa-5x text-muted"></i>
                </div>
            @endif
        </div>

        {{-- Info Obat --}}
        <div class="col-md-7">
            <h2 class="fw-bold">{{ $obat->nama_obat }}</h2>
            <h3 class="text-primary mb-3">Rp {{ number_format($obat->harga, 0, ',', '.') }}</h3>

            <span class="badge bg-info text-dark mb-3">
                Stok: {{ $obat->stok }} {{ $obat->satuan }}
            </span>

            @if($obat->deskripsi)
                <h6 class="fw-bold mt-3">Deskripsi</h6>
                <p class="text-muted">{{ $obat->deskripsi }}</p>
            @endif

            @if($obat->aturan_pakai)
                <h6 class="fw-bold mt-3">Aturan Pakai</h6>
                <p class="text-muted">{{ $obat->aturan_pakai }}</p>
            @endif

            @if($obat->efek_samping)
                <h6 class="fw-bold mt-3">Efek Samping</h6>
                <p class="text-muted">{{ $obat->efek_samping }}</p>
            @endif

            {{-- Form Tambah Keranjang --}}
            <form action="{{ route('toko.tambahKeranjang') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="id_obat" value="{{ $obat->id }}">
                <div class="input-group mb-3" style="max-width: 200px;">
                    <input type="number" name="jumlah" class="form-control"
                           value="1" min="1" max="{{ $obat->stok }}" required>
                    <span class="input-group-text">{{ $obat->satuan }}</span>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>

</div>
@endsection