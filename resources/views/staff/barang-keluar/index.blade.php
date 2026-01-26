@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Data Barang Keluar</h1>
        <a href="{{ route('staff.barang-keluar.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Barang Keluar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th class="text-center">Jumlah</th>
                            <th>Tanggal Keluar</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="width:15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangKeluar as $item)
                        <tr>
                            <td>{{ $barangKeluar->firstItem() + $loop->index }}</td>
                            <td><span class="badge bg-primary text-white">{{ $item->kode }}</span></td>
                            <td>{{ $item->obat->nama_obat }}</td>
                            <td class="text-center">{{ $item->jumlah }} {{ $item->obat->satuan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}</td>
                            <td>{{ $item->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('staff.barang-keluar.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('staff.barang-keluar.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('staff.barang-keluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus? Stok obat akan dikembalikan.')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">Tidak ada data barang keluar</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $barangKeluar->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            paging: false,
            searching: true,
            ordering: true,
            info: false,
            responsive: true,
            language: {
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Tidak ada data"
            }
        });
    });
</script>
@endpush
