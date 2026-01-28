@extends('layouts.app')

@section('title', 'Data Pembelian Obat')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-1">Data Pembelian Obat</h4>
            <p class="text-muted mb-0">Riwayat transaksi pembelian obat</p>
          </div>
        </div>

        {{-- Filter --}}
        <div class="row mb-3">
          <div class="col-md-4">
            <form action="{{ route('admin.obat.pembelian') }}" method="GET">
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari kode/supplier..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Kode Pembelian</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pembelian as $key => $item)
              <tr>
                <td>{{ $pembelian->firstItem() + $key }}</td>
                <td><strong>{{ $item->kode_pembelian }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d-m-Y') }}</td>
                <td>{{ $item->supplier_nama ?? 'Supplier A' }}</td>
                <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                <td>{{ $item->jumlah }} {{ $item->obat->satuan ?? '' }}</td>
                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td><strong class="text-success">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></td>
                <td>
                  @if($item->status == 'selesai')
                    <span class="badge bg-success">Selesai</span>
                  @elseif($item->status == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                  @else
                    <span class="badge bg-secondary">{{ $item->status }}</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" class="text-center py-5">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted mb-0">Belum ada data pembelian obat</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
          {{ $pembelian->links() }}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection