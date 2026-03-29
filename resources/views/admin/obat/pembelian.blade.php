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
            <p class="text-muted mb-0">Riwayat pembelian obat</p>
          </div>
        </div>

        {{-- Filter --}}
        <div class="row mb-3">
          <div class="col-md-4">
            <form action="{{ route('admin.obat.pembelian') }}" method="GET">
              <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama obat..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
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
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pembelian as $key => $item)
              <tr>
                <td>{{ $pembelian->firstItem() + $key }}</td>
                <td>{{ $item->kode_obat ?? '-' }}</td>
                <td><strong>{{ $item->nama_obat ?? '-' }}</strong></td>
                <td>{{ $item->satuan ?? '-' }}</td>
                <td>{{ $item->stok ?? 0 }}</td>
                <td>Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                <td>
                  @if($item->status)
                    <span class="badge bg-success">Aktif</span>
                  @else
                    <span class="badge bg-secondary">Nonaktif</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-5">
                  <p class="text-muted mb-0">Belum ada data obat</p>
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