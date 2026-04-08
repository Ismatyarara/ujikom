@extends('layouts.app')

@section('title', 'Data Pesanan User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Data Pesanan User</h1>
            <small class="text-muted">Daftar transaksi pesanan dari toko online</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Kode</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelian as $item)
                            <tr>
                                <td>{{ $pembelian->firstItem() + $loop->index }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $item->kode_transaksi }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->user->name ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->user->email ?? '-' }}</small>
                                </td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>
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
                                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                                </td>
                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('staff.pembelian.show', $item->id) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Belum ada data pembelian user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $pembelian->links() }}
    </div>
</div>
@endsection
