@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="mb-4">
                <h3 class="mb-2">Data Obat</h3>
                <p class="text-muted">Daftar obat yang tersedia</p>
            </div>

            <!-- Cards Grid -->
            <div class="row">
                @forelse($obat as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <!-- Foto Obat -->
                        <div class="card-img-top bg-light text-center p-4">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" 
                                     alt="{{ $item->nama_obat }}" 
                                     class="img-fluid"
                                     style="height: 150px; object-fit: contain;">
                            @else
                                <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="icon-bag" style="font-size: 60px; color: #ddd;"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <!-- Nama Obat -->
                            <h6 class="card-title mb-2">{{ $item->nama_obat }}</h6>
                            
                            <!-- Satuan -->
                            <p class="text-muted small mb-3">Per {{ ucfirst($item->satuan) }}</p>

                            <!-- Harga -->
                            <div class="mb-3 mt-auto">
                                <h5 class="text-primary mb-0">Rp{{ number_format($item->harga, 0, ',', '.') }}</h5>
                                
                                <!-- Stok Info -->
                                @if($item->stok <= 10)
                                    <small class="text-danger">
                                        <i class="icon-exclamation"></i> Stok rendah ({{ $item->stok }})
                                    </small>
                                @else
                                    <small class="text-success">
                                        <i class="icon-check"></i> Stok tersedia ({{ $item->stok }})
                                    </small>
                                @endif
                            </div>

                            <!-- Button -->
                            <a href="{{ route('dokter.data-obat.show', $item->id) }}" 
                               class="btn btn-outline-primary w-100">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="icon-bag" style="font-size: 60px; color: #ddd;"></i>
                            <h5 class="mt-3 text-muted">Belum ada data obat</h5>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.card-title {
    font-size: 14px;
    font-weight: 600;
    min-height: 40px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection