@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('dokter.data-obat.index') }}" class="btn btn-outline-secondary">
                    <i class="icon-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Foto Obat -->
                        <div class="col-md-4">
                            <div class="bg-light rounded text-center p-4 mb-3">
                                @if($obat->foto)
                                    <img src="{{ asset('storage/' . $obat->foto) }}" 
                                         alt="{{ $obat->nama_obat }}" 
                                         class="img-fluid"
                                         style="max-height: 300px; object-fit: contain;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <i class="icon-bag" style="font-size: 100px; color: #ddd;"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Info Card -->
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Kode Obat</small>
                                        <strong>{{ $obat->kode_obat }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Harga</small>
                                        <h4 class="text-primary mb-0">Rp{{ number_format($obat->harga, 0, ',', '.') }}</h4>
                                        <small class="text-muted">Per {{ ucfirst($obat->satuan) }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-1">Stok Tersedia</small>
                                        @if($obat->stok <= 10)
                                            <span class="badge bg-danger">{{ $obat->stok }} {{ $obat->satuan }}</span>
                                            <small class="text-danger d-block mt-1">Stok rendah</small>
                                        @else
                                            <strong class="text-success">{{ $obat->stok }} {{ $obat->satuan }}</strong>
                                        @endif
                                    </div>
                                    @if($obat->tanggal_kadaluarsa)
                                    <div>
                                        <small class="text-muted d-block mb-1">Kadaluarsa</small>
                                        <strong>{{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d F Y') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Detail Info -->
                        <div class="col-md-8">
                            <!-- Nama Obat -->
                            <h3 class="mb-3">{{ $obat->nama_obat }}</h3>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <h5 class="mb-2">
                                    <i class="icon-docs text-primary"></i> Deskripsi
                                </h5>
                                <p class="text-muted">{{ $obat->deskripsi }}</p>
                            </div>

                            <!-- Aturan Pakai -->
                            <div class="mb-4">
                                <h5 class="mb-2">
                                    <i class="icon-notebook text-success"></i> Aturan Pakai
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $obat->aturan_pakai }}</p>
                                </div>
                            </div>

                            <!-- Efek Samping -->
                            <div class="mb-4">
                                <h5 class="mb-2">
                                    <i class="icon-exclamation text-warning"></i> Efek Samping
                                </h5>
                                <div class="alert alert-warning mb-0">
                                    <p class="mb-0">{{ $obat->efek_samping }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
}

.bg-light.rounded {
    border-radius: 8px;
}
</style>
@endsection