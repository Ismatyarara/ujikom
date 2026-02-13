@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Beli Obat</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('user.keranjang') }}" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Keranjang 
                @if($totalKeranjang > 0)
                    <span class="badge bg-danger">{{ $totalKeranjang }}</span>
                @endif
            </a>
        </div>
    </div>

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

    <div class="row">
        @forelse($obat as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" alt="{{ $item->nama_obat }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->nama_obat }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($item->deskripsi, 100) }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-primary mb-0">Rp {{ number_format($item->harga, 0, ',', '.') }}</h4>
                                <span class="badge bg-info">Stok: {{ $item->stok }} {{ $item->satuan }}</span>
                            </div>

                            <form action="{{ route('user.keranjang.tambah', $item->id) }}" method="POST">
                                @csrf
                                <div class="input-group mb-2">
                                    <input type="number" name="jumlah" class="form-control" value="1" min="1" max="{{ $item->stok }}" required>
                                    <span class="input-group-text">{{ $item->satuan }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </form>

                            <a href="{{ route('user.beli-obat.show', $item->id) }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada obat yang tersedia
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection