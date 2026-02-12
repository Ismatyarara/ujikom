@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Catatan Medis</h3>
                <a href="{{ route('dokter.catatan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Catatan
                </a>
            </div>

            <!-- Alert Success -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Pasien</th>
                                    <th width="15%">Dokter</th>
                                    <th width="10%">Diagnosa</th>
                                    <th width="12%">Tanggal</th>
                                    <th width="20%">Keluhan</th>
                                    <th width="18%">Deskripsi</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($catatan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->dokter->nama ?? '-' }}</td>
                                    <td>{{ $item->diagnosa }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_catatan)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div data-bs-toggle="tooltip" title="{{ $item->keluhan }}">
                                            {{ Str::limit($item->keluhan, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div data-bs-toggle="tooltip" title="{{ $item->deskripsi }}">
                                            {{ Str::limit($item->deskripsi, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('dokter.catatan.edit', $item->id) }}"
                                           class="btn btn-warning btn-sm"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                           <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('dokter.catatan.destroy', $item->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada catatan medis</td>
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

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection