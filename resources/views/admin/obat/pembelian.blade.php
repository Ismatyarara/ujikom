@extends('layouts.app')

@section('title', 'Monitoring Pembelian Obat')

@section('content')
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
          <h4 class="card-title mb-1">Monitoring Pembelian Obat</h4>
          <p class="text-muted mb-0">Admin dapat memantau riwayat transaksi pembelian tanpa mengubah data operasional.</p>
        </div>
        <div class="mt-3 mt-md-0">
          <span class="badge badge-light px-3 py-2">Total transaksi: {{ $pembelian->total() }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-lg-5">
      <form action="{{ route('admin.obat.pembelian') }}" method="GET">
        <div class="input-group">
          <input type="text" name="search" class="form-control"
                 placeholder="Cari kode transaksi, nama user, email, atau status..."
                 value="{{ request('search') }}">
          <button class="btn btn-primary" type="submit">Cari</button>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Kode Transaksi</th>
                  <th>Pembeli</th>
                  <th>Jumlah Item</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pembelian as $key => $item)
                  @php
                    $statusClass = match($item->status) {
                        'dibayar' => 'success',
                        'diverifikasi' => 'primary',
                        'selesai' => 'info',
                        'dibatalkan' => 'danger',
                        'expired' => 'secondary',
                        default => 'warning',
                    };
                  @endphp
                  <tr>
                    <td>{{ $pembelian->firstItem() + $key }}</td>
                    <td>
                      <span class="font-weight-bold">{{ $item->kode_transaksi }}</span>
                    </td>
                    <td>
                      <div class="font-weight-bold">{{ $item->user->name ?? '-' }}</div>
                      <small class="text-muted">{{ $item->user->email ?? '-' }}</small>
                    </td>
                    <td>{{ $item->details->sum('jumlah') }} item</td>
                    <td>Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td>
                      <span class="badge badge-{{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                    </td>
                    <td>{{ optional($item->created_at)->format('d M Y H:i') ?? '-' }}</td>
                    <td class="text-center">
                      <a href="{{ route('admin.obat.pembelian.show', $item) }}" class="btn btn-sm btn-outline-info">
                        Detail
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center py-5">
                      <p class="text-muted mb-0">Belum ada transaksi pembelian yang dapat dimonitor.</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            {{ $pembelian->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
