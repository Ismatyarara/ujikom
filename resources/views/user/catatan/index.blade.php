@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="mb-4">
                <h3><i class="fas fa-notes-medical text-primary"></i> Riwayat Catatan Medis</h3>
            </div>

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Diagnosa</th>
                                    <th width="20%">Dokter</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="30%">Keluhan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($catatan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $item->diagnosa }}</strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-user-md text-primary"></i>
                                        Dr. {{ $item->dokter->pengguna->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_catatan)->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <div data-bs-toggle="tooltip" title="{{ $item->keluhan }}">
                                            {{ Str::limit($item->keluhan, 60) }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.catatan.show', $item->id) }}"
                                           class="btn btn-primary btn-sm"
                                           data-bs-toggle="tooltip"
                                           title="Lihat Detail">
                                           <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-notes-medical fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">Belum ada catatan medis</p>
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