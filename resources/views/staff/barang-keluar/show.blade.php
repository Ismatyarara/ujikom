@extends('layouts.app')

@section('title', 'Detail Barang Keluar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title mb-0">Detail Barang Keluar</h4>
                        <small class="text-muted">Dicatat {{ $barangKeluar->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('staff.barang-keluar.edit', $barangKeluar->id) }}"
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="badge bg-danger-subtle text-danger fs-6 px-3 py-2">
                        <i class="fas fa-barcode me-2"></i>{{ $barangKeluar->kode }}
                    </span>
                </div>

                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-pills me-2"></i>Informasi Obat
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td class="text-muted" width="40%">Nama Obat</td>
                                        <td class="fw-semibold">{{ $barangKeluar->obat->nama_obat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Kode Obat</td>
                                        <td>{{ $barangKeluar->obat->kode_obat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Satuan</td>
                                        <td>{{ $barangKeluar->obat->satuan ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td class="text-muted" width="40%">Stok Sekarang</td>
                                        <td>
                                            @php $stok = $barangKeluar->obat->stok ?? 0 @endphp
                                            <span class="badge {{ $stok > 10 ? 'bg-success' : ($stok > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                {{ $stok > 0 ? $stok : 'Habis' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Harga</td>
                                        <td>Rp {{ number_format($barangKeluar->obat->harga ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="text-muted mb-3">
                    <i class="fas fa-clipboard-list me-2"></i>Detail Transaksi
                </h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-danger h-100">
                            <div class="card-body text-center">
                                <div class="text-danger mb-1">
                                    <i class="fas fa-minus-circle fa-2x"></i>
                                </div>
                                <div class="fs-3 fw-bold text-danger">-{{ $barangKeluar->jumlah }}</div>
                                <div class="text-muted small">{{ $barangKeluar->obat->satuan ?? 'pcs' }} keluar</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <div class="text-primary mb-1">
                                    <i class="fas fa-calendar-check fa-2x"></i>
                                </div>
                                <div class="fw-semibold">{{ $barangKeluar->tanggal_keluar->format('d M Y') }}</div>
                                <div class="text-muted small">Tanggal Keluar</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($barangKeluar->deskripsi)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-sticky-note me-2"></i>Keterangan
                        </h6>
                        <div class="card border-0 bg-light">
                            <div class="card-body">{{ $barangKeluar->deskripsi }}</div>
                        </div>
                    </div>
                @endif

                <div class="text-muted small border-top pt-3">
                    <i class="fas fa-clock me-1"></i>
                    Dibuat: {{ $barangKeluar->created_at->format('d M Y H:i') }}
                    &nbsp;|&nbsp;
                    Diupdate: {{ $barangKeluar->updated_at->format('d M Y H:i') }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection