@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">🏪 Toko Obat</h2>
        <a href="{{ route('toko.keranjang') }}" class="btn btn-primary position-relative">
            <i class="fas fa-shopping-cart"></i> Keranjang
            @if($totalKeranjang > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $totalKeranjang }}
                </span>
            @endif
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Daftar Obat --}}
    <div class="row">
        @forelse($obat as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}"
                             class="card-img-top" alt="{{ $item->nama_obat }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <i class="fas fa-pills fa-3x text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->nama_obat }}</h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit($item->deskripsi, 100) }}
                        </p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary mb-0">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </h5>
                                <span class="badge bg-info text-dark">
                                    Stok: {{ $item->stok }} {{ $item->satuan }}
                                </span>
                            </div>

                            {{-- Input Jumlah (shared untuk kedua tombol) --}}
                            <div class="input-group mb-2">
                                <input type="number" id="jumlah-{{ $item->id }}"
                                       class="form-control" value="1"
                                       min="1" max="{{ $item->stok }}">
                                <span class="input-group-text">{{ $item->satuan }}</span>
                            </div>

                            {{-- Tombol + Keranjang --}}
                            <form action="{{ route('toko.tambahKeranjang') }}" method="POST"
                                  class="mb-2" onsubmit="syncJumlah({{ $item->id }}, this)">
                                @csrf
                                <input type="hidden" name="id_obat" value="{{ $item->id }}">
                                <input type="hidden" name="jumlah" class="jumlah-hidden">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-cart-plus"></i> + Keranjang
                                </button>
                            </form>

                            {{-- Tombol Beli Sekarang --}}
                            <form action="{{ route('toko.beliSekarang') }}" method="POST"
                                  onsubmit="syncJumlah({{ $item->id }}, this)">
                                @csrf
                                <input type="hidden" name="id_obat" value="{{ $item->id }}">
                                <input type="hidden" name="jumlah" class="jumlah-hidden">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-bolt"></i> Beli Sekarang
                                </button>
                            </form>

                            <a href="{{ route('toko.show', $item->id) }}"
                               class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada obat yang tersedia.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $obat->links() }}
    </div>

</div>

<script>
    // Sync input jumlah ke hidden field sebelum form submit
    function syncJumlah(id, form) {
        const jumlah = document.getElementById('jumlah-' + id).value;
        form.querySelector('.jumlah-hidden').value = jumlah;
    }
</script>

@endsection