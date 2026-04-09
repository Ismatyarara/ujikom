@extends('layouts.app')

@section('title', 'Detail Monitoring Pembelian')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Detail Monitoring Pembelian</h4>
            <p class="text-muted mb-0">Ringkasan transaksi untuk kebutuhan pengawasan admin.</p>
        </div>
        <a href="{{ route('admin.obat.pembelian') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Informasi Transaksi</h5>
                    <div class="mb-3">
                        <div class="text-muted small">Kode Transaksi</div>
                        <div class="font-weight-bold">{{ $pembelian->kode_transaksi }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Pembeli</div>
                        <div class="font-weight-bold">{{ $pembelian->user->name ?? '-' }}</div>
                        <small class="text-muted">{{ $pembelian->user->email ?? '-' }}</small>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Status</div>
                        <div class="text-capitalize">{{ $pembelian->status ?? '-' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">No Telepon</div>
                        <div>{{ $pembelian->no_telepon ?? '-' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Alamat Pengiriman</div>
                        <div>{{ $pembelian->alamat_pengiriman ?? '-' }}</div>
                    </div>
                    <div class="mb-0">
                        <div class="text-muted small">Total Belanja</div>
                        <div class="h5 text-primary mb-0">Rp {{ number_format($pembelian->total_harga ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Item Pembelian</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Obat</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembelian->details as $detail)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $detail->obat->nama_obat ?? '-' }}</div>
                                            <small class="text-muted">{{ $detail->obat->satuan ?? '-' }}</small>
                                        </td>
                                        <td>Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $detail->jumlah ?? 0 }}</td>
                                        <td>Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Tidak ada detail item pada transaksi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
