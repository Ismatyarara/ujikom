@extends('layouts.app')

@section('title', 'Detail Penjualan Obat')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-1">Detail Penjualan Obat</h4>
            <p class="text-muted mb-0">Informasi lengkap transaksi penjualan</p>
          </div>
          <a href="{{ route('staff.penjualan.index') }}" class="btn btn-light btn-sm">
            <i class="mdi mdi-arrow-left"></i> Kembali
          </a>
        </div>

        <div class="row">
          <!-- Informasi Transaksi -->
          <div class="col-md-6 mb-3">
            <div class="card border-left-primary h-100">
              <div class="card-body">
                <h5 class="card-title mb-4 text-primary">
                  <i class="mdi mdi-file-document-outline"></i> Informasi Transaksi
                </h5>
                
                <table class="table table-borderless mb-0">
                  <tbody>
                    <tr>
                      <td class="font-weight-bold" style="width: 40%;">Kode Transaksi</td>
                      <td>:</td>
                      <td><span class="badge badge-primary badge-pill">{{ $penjualan->kode }}</span></td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Tanggal Penjualan</td>
                      <td>:</td>
                      <td>
                        <i class="mdi mdi-calendar text-muted"></i>
                        {{ \Carbon\Carbon::parse($penjualan->tanggal_keluar)->translatedFormat('l, d F Y') }}
                      </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Waktu Input</td>
                      <td>:</td>
                      <td>
                        <i class="mdi mdi-clock-outline text-muted"></i>
                        {{ $penjualan->created_at->translatedFormat('d F Y, H:i') }} WIB
                      </td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Status</td>
                      <td>:</td>
                      <td><span class="badge badge-success">Selesai</span></td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold align-top">Deskripsi</td>
                      <td class="align-top">:</td>
                      <td>{{ $penjualan->deskripsi ?? '-' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Informasi Obat -->
          <div class="col-md-6 mb-3">
            <div class="card border-left-success h-100">
              <div class="card-body">
                <h5 class="card-title mb-4 text-success">
                  <i class="mdi mdi-pill"></i> Informasi Obat
                </h5>
                
                @if($penjualan->obat->foto)
                <div class="text-center mb-3">
                  <img src="{{ $penjualan->obat->foto_url }}" 
                       alt="{{ $penjualan->obat->nama_obat }}" 
                       class="img-thumbnail rounded" 
                       style="max-width: 150px; max-height: 150px; object-fit: cover;">
                </div>
                @endif

                <table class="table table-borderless mb-0">
                  <tbody>
                    <tr>
                      <td class="font-weight-bold" style="width: 40%;">Kode Obat</td>
                      <td>:</td>
                      <td><span class="badge badge-secondary badge-pill">{{ $penjualan->obat->kode }}</span></td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Nama Obat</td>
                      <td>:</td>
                      <td class="font-weight-bold text-dark">{{ $penjualan->obat->nama_obat }}</td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Harga Satuan</td>
                      <td>:</td>
                      <td class="text-success font-weight-bold">Rp {{ number_format($penjualan->obat->harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Jumlah Terjual</td>
                      <td>:</td>
                      <td><span class="badge badge-danger badge-pill px-3 py-2">{{ number_format($penjualan->jumlah) }}</span></td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Stok Saat Ini</td>
                      <td>:</td>
                      <td>
                        @if($penjualan->obat->stok > 10)
                          <span class="badge badge-success badge-pill px-3">{{ number_format($penjualan->obat->stok) }} Tersedia</span>
                        @elseif($penjualan->obat->stok > 0)
                          <span class="badge badge-warning badge-pill px-3">{{ number_format($penjualan->obat->stok) }} Terbatas</span>
                        @else
                          <span class="badge badge-danger badge-pill px-3">Habis</span>
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Penjualan -->
        <div class="row">
          <div class="col-12 mb-3">
            <div class="card bg-gradient-primary text-white">
              <div class="card-body py-4">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <h5 class="text-white mb-2">
                      <i class="mdi mdi-cash-multiple"></i> Total Nilai Penjualan
                    </h5>
                    <p class="mb-0 text-white-50">
                      {{ number_format($penjualan->jumlah) }} x Rp {{ number_format($penjualan->obat->harga, 0, ',', '.') }}
                    </p>
                  </div>
                  <div class="col-md-4 text-md-right">
                    <h2 class="text-white mb-0">
                      Rp {{ number_format($penjualan->jumlah * $penjualan->obat->harga, 0, ',', '.') }}
                    </h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Informasi Detail Obat -->
        <div class="row">
          @if($penjualan->obat->deskripsi)
          <div class="col-md-4 mb-3">
            <div class="card h-100">
              <div class="card-body">
                <h6 class="card-title text-info mb-3">
                  <i class="mdi mdi-information-outline"></i> Deskripsi Obat
                </h6>
                <p class="text-muted mb-0">{{ $penjualan->obat->deskripsi }}</p>
              </div>
            </div>
          </div>
          @endif

          @if($penjualan->obat->aturan_pakai)
          <div class="col-md-4 mb-3">
            <div class="card h-100">
              <div class="card-body">
                <h6 class="card-title text-success mb-3">
                  <i class="mdi mdi-file-document-edit-outline"></i> Aturan Pakai
                </h6>
                <p class="text-muted mb-0">{{ $penjualan->obat->aturan_pakai }}</p>
              </div>
            </div>
          </div>
          @endif

          @if($penjualan->obat->efek_samping)
          <div class="col-md-4 mb-3">
            <div class="card h-100">
              <div class="card-body">
                <h6 class="card-title text-warning mb-3">
                  <i class="mdi mdi-alert-outline"></i> Efek Samping
                </h6>
                <p class="text-muted mb-0">{{ $penjualan->obat->efek_samping }}</p>
              </div>
            </div>
          </div>
          @endif
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 d-flex justify-content-between align-items-center">
          <a href="{{ route('staff.penjualan.index') }}" class="btn btn-light">
            <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar
          </a>
          <div>
            <button onclick="window.print()" class="btn btn-info">
              <i class="mdi mdi-printer"></i> Cetak
            </button>
            @can('edit-penjualan')
            <a href="{{ route('staff.penjualan.edit', $penjualan->id) }}" class="btn btn-warning">
              <i class="mdi mdi-pencil"></i> Edit
            </a>
            @endcan
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
.border-left-primary {
  border-left: 4px solid #4B49AC !important;
}

.border-left-success {
  border-left: 4px solid #57B657 !important;
}

.table-borderless td {
  padding: 0.5rem 0.25rem;
  vertical-align: top;
}

.badge-pill {
  border-radius: 10rem;
}

.bg-gradient-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

@media print {
  .btn, .sidebar, .navbar, .footer, .page-header {
    display: none !important;
  }
  
  .card {
    border: 1px solid #dee2e6 !important;
    box-shadow: none !important;
    margin-bottom: 1rem;
  }
  
  .bg-gradient-primary {
    background: #667eea !important;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  
  body {
    background: white !important;
  }
  
  .content-wrapper {
    padding: 0 !important;
  }
}

@media (max-width: 768px) {
  .table-borderless td:first-child {
    width: 35% !important;
  }
}
</style>
@endpush
@endsection