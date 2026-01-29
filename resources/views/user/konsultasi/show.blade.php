@extends('layouts.app')

@section('title', 'Konsultasi')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold">Pilih Dokter</h3>
        <p class="text-muted">Pilih dokter untuk memulai konsultasi</p>
    </div>

    <div class="row g-3">
        @forelse ($dokter as $konsulChat)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 hover-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2">
                            {{-- Foto Dokter --}}
                            <img src="{{ $konsulChat->foto_url }}"
                                 alt="{{ $konsulChat->nama }}"
                                 class="rounded flex-shrink-0"
                                 style="width: 65px; height: 80px; object-fit: cover;">

                            {{-- Info Dokter --}}
                            <div class="flex-grow-1 d-flex flex-column ms-1">
                                <h6 class="mb-1 fw-bold">{{ $konsulChat->nama }}</h6>
                                <p class="text-muted mb-2 small">{{ $konsulChat->spesialisasi->nama ?? 'Dokter Umum' }}</p>
                                
                                <div class="small text-muted mb-2" style="font-size: 0.8rem;">
                                    @if($konsulChat->jadwal_praktik_hari)
                                    <div class="mb-1 d-flex align-items-center">
                                        <i class="bi bi-briefcase me-1" style="font-size: 0.7rem;"></i>
                                        <span>{{ Str::limit($konsulChat->jadwal_praktik_hari, 20) }}</span>
                                    </div>
                                    @endif

                                    @if($konsulChat->jadwal_praktik_waktu)
                                    <div class="mb-1 d-flex align-items-center">
                                        <i class="bi bi-clock me-1" style="font-size: 0.7rem;"></i>
                                        <span>{{ $konsulChat->jadwal_praktik_waktu }}</span>
                                    </div>
                                    @endif

                                    @if($konsulChat->tempat_praktik)
                                    <div class="d-flex align-items-center text-success">
                                        <i class="bi bi-geo-alt me-1" style="font-size: 0.7rem;"></i>
                                        <span class="fw-semibold">{{ Str::limit($konsulChat->tempat_praktik, 25) }}</span>
                                    </div>
                                    @endif
                                </div>

                                {{-- Footer dengan harga dan button --}}
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;"></span>
                                    
                                    {{-- Button Chat Hijau --}}
                                    <a href="{{ url('Chat/' . $konsulChat->id_user) }}"
                                       class="btn btn-success btn-sm px-4 py-2">
                                        Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada dokter tersedia saat ini.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($dokter, 'hasPages') && $dokter->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $dokter->links() }}
        </div>
    @endif
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
    .btn-success {
        background: #28a745;
        border: none;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 6px;
    }
    .btn-success:hover {
        background: #218838;
    }
</style>
@endsection