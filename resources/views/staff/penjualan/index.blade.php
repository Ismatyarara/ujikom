@extends('layouts.app')

@section('title', 'Penjualan Obat')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Data Penjualan Obat</h4>
          <a href="{{ route('staff.penjualan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Penjualan
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Tanggal Keluar</th>
                <th>Deskripsi</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($penjualan as $key => $item)
              <tr>
                <td>{{ $penjualan->firstItem() + $key }}</td>

                <td>
                  <span class="badge badge-primary">{{ $item->kode }}</span>
                </td>

                <td>
                  <strong>{{ $item->obat->nama_obat }}</strong><br>
                  <small class="text-muted">Kode: {{ $item->obat->kode_obat }}</small>
                </td>

                <td>
                  <span class="badge badge-danger px-3 py-2">
                    {{ $item->jumlah }}
                  </span>
                </td>

                <td>
                  {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}
                </td>

                <td>
                  {{ Str::limit($item->deskripsi ?? '-', 40) }}
                </td>

                <td class="text-center">
                  <a href="{{ route('staff.penjualan.show', $item->id) }}"
                     class="btn btn-outline-info btn-sm" title="Detail">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                  <p class="text-muted mb-0">Belum ada data penjualan</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $penjualan->links() }}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
