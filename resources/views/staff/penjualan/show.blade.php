@extends('layouts.app')

@section('title', 'Detail Penjualan Obat')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Detail Penjualan Obat</h4>
          <a href="{{ route('staff.penjualan.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        <div class="row">
          <!-- Informasi Transaksi -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-4">
                  <i class="fas fa-file-invoice text-primary"></i> Informasi Transaksi
                </h5>
                
                <div class="mb-3">
                  <label class="font-weight-bold">Kode Transaksi:</label>
                  <p><span class="badge badge-info">{{ $penjualan->kode }}</span></p>
                </div>

                <div class="mb-3">
                  <label class="font-weight-bold">Tanggal Penjualan:</label>
                  <p>{{ \Carbon\Carbon::parse($penjualan->tanggal_keluar)->format('d F Y') }}</p>
                </div>

                <div class="mb-3">
                  <label class="font-weight-bold">Waktu Input:</label>
                  <p>{{ $penjualan->created_at->format('d F Y, H:i') }} WIB</p>
                </div>

                <div class="mb-3">
                  <label class="font-weight-bold">Deskripsi:</label>
                  <p>{{ $penjualan->deskripsi ?? '-' }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Informasi Obat -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-4">
                  <i class="fas fa-pills text-success"></i> Informasi Obat
                </h5>
                
                @if($penjualan->obat->foto)
                <div class="text-center mb-3">
                  <img src="{{ $penjualan->obat->foto_url }}" alt="Foto Obat" class="img-thumbnail" style="max-width: 150px;">
                </div>
                @endif

                <div class="mb-3">
                  <label class="font-weight-bold">Kode Obat:</label>
                  <p><span class="badge badge-secondary">{{ $penjualan->obat->kode }}</span></p>
                </div>

                <div class="mb-3">
                  <label class="font-weight-bold">Nama Obat:</label>
                  <p class="h5">{{ $penjualan->obat->nama_obat }}</p>
                </div>

                <div class="mb-3">
                  <label class="font-weight-bold">Jumlah Terjual:</label>
                  <p><span class="badge badge-danger badge-lg">{{ $penjualan->jumlah }}</span></p>
                </div>

                <div class="mb-3">
                  <label class="font-weight-bold">Stok Saat Ini:</label>
                  <p>
                    @if($penjualan->obat->stok > 10)
                      <span class="badge badge-success">{{ $penjualan->obat->stok }}</span>
                    @elseif($penjualan->obat->stok > 0)
                      <span class="badge badge-warning">{{ $penjualan->obat->stok }}</span>
                    @else
                      <span class="badge badge-danger">Habis</span>
                    @endif
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Deskripsi Obat -->
        @if($penjualan->obat->deskripsi)
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-3">
                  <i class="fas fa-info-circle text-info"></i> Deskripsi Obat
                </h5>
                <p>{{ $penjualan->obat->deskripsi }}</p>
              </div>
            </div>
          </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-4">
          <a href="{{ route('staff.penjualan.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
          </a>
          <button onclick="window.print()" class="btn btn-info">
            <i class="fas fa-print"></i> Cetak
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
@media print {
  .btn, .sidebar, .navbar, .footer {
    display: none !important;
  }
  .card {
    border: 1px solid #000 !important;
  }
}
</style>
@endpush
@endsection