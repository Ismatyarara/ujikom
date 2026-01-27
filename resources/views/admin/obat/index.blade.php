@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Data Obat</h4>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Foto</th>
                                <th>Nama Obat</th>
                                <th>Harga</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($obat as $key => $item)
                                <tr>
                                    <td>{{ $obat->firstItem() + $key }}</td>
                                    <td>{{ $item->kode_obat }}</td>
                                    <td>
                                        <img src="{{ $item->foto_url }}" class="img-thumbnail" width="50" height="50"
                                            style="object-fit:cover">
                                    </td>
                                    <td>{{ $item->nama_obat }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>
                                        @if ($item->status === 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.obat.pembelian') }}" class="btn btn-secondary btn-sm mb-1">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                        <a href="{{ route('admin.obat.show', $item->id) }}" class="btn btn-info btn-sm mb-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada data obat
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
