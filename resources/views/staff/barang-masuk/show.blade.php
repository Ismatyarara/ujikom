@extends('layouts.app')

@section('title', 'Detail Barang Masuk')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-0">Detail Barang Masuk</h4>
            <small class="text-muted">Dicatat {{ $barangMasuk->created_at->diffForHumans() }}</small>
          </div>
          <div class="d-flex gap-2">
            <a href="{{ route('staff.barang-masuk.edit', $barangMasuk->id) }}"
               class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-secondary btn-sm">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>

        {{-- Badge Kode --}}
        <div class="mb-4">
          <span class="badge bg-primary fs-6 px-3 py-2">
            <i class="fas fa-barcode me-2"></i>{{ $barangMasuk->kode }}
          </span>
        </div>

        {{-- Info Obat --}}
        <div class="card bg-light border-0 mb-4">
          <div class="card-body">
            <h6 class="text-muted mb-3"><i class="fas fa-pills me-2"></i>Informasi Obat</h6>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-borderless table-sm mb-0">
                  <tr>
                    <td class="text-muted" width="40%">Nama Obat</td>
                    <td class="fw-semibold">{{ $barangMasuk->obat->nama_obat ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="text-muted">Kode Obat</td>
                    <td>{{ $barangMasuk->obat->kode_obat ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="text-muted">Satuan</td>
                    <td>{{ $barangMasuk->obat->satuan ?? '-' }}</td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-borderless table-sm mb-0">
                  <tr>
                    <td class="text-muted" width="40%">Stok Sekarang</td>
                    <td>
                      @php $stok = $barangMasuk->obat->stok ?? 0; @endphp
                      @if($stok > 10)
                        <span class="badge bg-success">{{ $stok }}</span>
                      @elseif($stok > 0)
                        <span class="badge bg-warning text-dark">{{ $stok }}</span>
                      @else
                        <span class="badge bg-danger">Habis</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td class="text-muted">Harga</td>
                    <td>Rp {{ number_format($barangMasuk->obat->harga ?? 0, 0, ',', '.') }}</td>
                  </tr>
                  <tr>
                    <td class="text-muted">Status</td>
                    <td>
                      @if(($barangMasuk->obat->status ?? false))
                        <span class="badge bg-success">Aktif</span>
                      @else
                        <span class="badge bg-secondary">Nonaktif</span>
                      @endif
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- Info Transaksi --}}
        <h6 class="text-muted mb-3"><i class="fas fa-clipboard-list me-2"></i>Detail Transaksi</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <div class="card border-success h-100">
              <div class="card-body text-center">
                <div class="text-success mb-1">
                  <i class="fas fa-plus-circle fa-2x"></i>
                </div>
                <div class="fs-3 fw-bold text-success">+{{ $barangMasuk->jumlah }}</div>
                <div class="text-muted small">{{ $barangMasuk->obat->satuan ?? 'pcs' }} masuk</div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 bg-light h-100">
              <div class="card-body text-center">
                <div class="text-primary mb-1">
                  <i class="fas fa-calendar-check fa-2x"></i>
                </div>
                <div class="fw-semibold">{{ $barangMasuk->tanggal_masuk->format('d M Y') }}</div>
                <div class="text-muted small">Tanggal Masuk</div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 bg-light h-100">
              <div class="card-body text-center">
                @php
                  $selisih = now()->diffInDays($barangMasuk->tanggal_kadaluwarsa, false);
                @endphp
                <div class="{{ $selisih < 0 ? 'text-danger' : ($selisih <= 30 ? 'text-warning' : 'text-muted') }} mb-1">
                  <i class="fas fa-calendar-times fa-2x"></i>
                </div>
                <div class="fw-semibold">{{ $barangMasuk->tanggal_kadaluwarsa->format('d M Y') }}</div>
                <div class="small">
                  @if($selisih < 0)
                    <span class="text-danger">Sudah kadaluwarsa</span>
                  @elseif($selisih <= 30)
                    <span class="text-warning">{{ $selisih }} hari lagi</span>
                  @else
                    <span class="text-muted">Tanggal Kadaluwarsa</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Keterangan --}}
        @if($barangMasuk->deskripsi)
          <div class="mb-4">
            <h6 class="text-muted mb-2"><i class="fas fa-sticky-note me-2"></i>Keterangan</h6>
            <div class="card border-0 bg-light">
              <div class="card-body">
                {{ $barangMasuk->deskripsi }}
              </div>
            </div>
          </div>
        @endif

        {{-- Timestamp --}}
        <div class="text-muted small border-top pt-3">
          <i class="fas fa-clock me-1"></i>
          Dibuat: {{ $barangMasuk->created_at->format('d M Y H:i') }} &nbsp;|&nbsp;
          Diupdate: {{ $barangMasuk->updated_at->format('d M Y H:i') }}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection