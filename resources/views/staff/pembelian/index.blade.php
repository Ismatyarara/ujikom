@extends('layouts.app')

@section('title', 'Data Pembelian Obat')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Pembelian Obat</h4>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah Masuk</th>
                            <th>Tanggal Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembelian as $item)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration + ($pembelian->currentPage() - 1) * $pembelian->perPage() }}
                            </td>
                            <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('staff.pembelian.show', $item->id) }}"
                                   class="btn btn-sm btn-info">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data pembelian belum tersedia
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
@endsection
