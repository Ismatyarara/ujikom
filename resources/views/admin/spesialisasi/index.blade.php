@extends('layouts.app')

@section('title', 'Data Spesialisasi')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Data Spesialisasi</h4>
                    <a href="{{ route('admin.spesialisasi.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </a>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">No</th>
                                <th style="width:80px">Foto</th>
                                <th>Nama Spesialisasi</th>
                                <th class="text-center" style="width:150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($spesialisasis as $key => $item)
                                <tr>
                                    <td>{{ $spesialisasis->firstItem() + $key }}</td>

                                    <td>
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/'.$item->foto) }}"
                                                 width="45" height="45"
                                                 class="rounded-circle object-fit-cover">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>{{ $item->name }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.spesialisasi.show', $item->id) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.spesialisasi.edit', $item->id) }}"
                                           class="btn btn-warning btn-sm mx-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.spesialisasi.destroy', $item->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Belum ada data spesialisasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-end">
                    {{ $spesialisasis->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
