@extends('layouts.app')

@section('title', 'Data Barang Keluar')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-0">Data Barang Keluar</h4>
                        <small class="text-muted">Riwayat pengeluaran stok obat (manual)</small>
                    </div>
                    <a href="{{ route('staff.barang-keluar.create') }}" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-minus"></i> Tambah Barang Keluar
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Tanggal Keluar</th>
                                <th>Keterangan</th>
                                <th>Dicatat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangKeluar as $key => $item)
                                <tr>
                                    <td>{{ $barangKeluar->firstItem() + $key }}</td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger">
                                            {{ $item->kode }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->obat->nama_obat ?? '-' }}</div>
                                        <small class="text-muted">{{ $item->obat->kode_obat ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger fs-6">
                                            -{{ $item->jumlah }} {{ $item->obat->satuan ?? '' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->tanggal_keluar->format('d M Y') }}</td>
                                    <td>
                                        <span class="text-muted small">
                                            {{ $item->deskripsi ? Str::limit($item->deskripsi, 30) : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.barang-keluar.show', $item->id) }}"
                                           class="btn btn-info btn-sm"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('staff.barang-keluar.edit', $item->id) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.barang-keluar.destroy', $item->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin hapus? Stok obat akan dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="fas fa-box-open fa-3x mb-3 d-block opacity-25"></i>
                                        Belum ada data barang keluar
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    {{ $barangKeluar->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection