@extends('layouts.app')

@section('title', 'Data Pembelian Obat')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="card-title mb-0">Data Pembelian Obat</h4>
          <a href="{{ route('admin.obat.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Data Obat
          </a>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Satuan</th>
                <th>Tanggal Update</th>
              </tr>
            </thead>
            <tbody>
              @forelse($obat as $key => $item)
              <tr>
                <td>{{ $obat->firstItem() + $key }}</td>
                <td>{{ $item->kode_obat }}</td>
                <td>{{ $item->nama_obat }}</td>
                <td>{{ $item->stok }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->satuan }}</td>
                <td>{{ $item->updated_at->format('d-m-Y H:i') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-2x mb-2"></i><br>
                  Belum ada data pembelian obat
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
          {{ $obat->links() }}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
