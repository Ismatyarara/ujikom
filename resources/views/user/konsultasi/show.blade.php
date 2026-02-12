@extends('layouts.app')

@section('title', 'Dokter ' . ($spesialisasi->nama ?? 'Spesialisasi'))

@section('content')
<div class="container py-4">
    {{-- Header Section --}}
    <div class="mb-4">
        <a href="{{ route('user.konsultasi.index') }}" class="btn btn-link text-decoration-none ps-0 mb-3">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
        
        @if(isset($spesialisasi))
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    @if($spesialisasi->foto)
                        <div class="rounded-3 bg-gradient d-flex align-items-center justify-content-center me-4 shadow-sm" 
                             style="width: 80px; height: 80px; overflow: hidden; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <img src="{{ asset('storage/' . $spesialisasi->foto) }}" 
                                 alt="{{ $spesialisasi->nama }}"
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        </div>
                    @else
                        <div class="rounded-3 bg-gradient d-flex align-items-center justify-content-center me-4 shadow-sm" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-heart-pulse text-white" style="font-size: 2.5rem;"></i>
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <h3 class="fw-bold mb-2 text-dark">{{ $spesialisasi->nama }}</h3>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <i class="bi bi-people-fill me-1"></i>
                                {{ $dokters->count() }} Dokter Tersedia
                            </span>
                            <span class="text-muted">
                                <i class="bi bi-check-circle-fill text-success me-1"></i>
                                Konsultasi Online
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Filter & Sort (Optional) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Pilih Dokter</h5>
        {{-- <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary active">Semua</button>
            <button type="button" class="btn btn-outline-secondary">Tersedia Hari Ini</button>
        </div> --}}
    </div>

    {{-- Daftar Dokter --}}
    <div class="row g-4">
        @forelse ($dokters ?? [] as $dokter)
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm hover-card h-100">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Foto Dokter --}}
                            <div class="col-auto">
                                <div class="position-relative">
                                    <img src="{{ $dokter->foto_url }}"
                                         alt="{{ $dokter->nama }}"
                                         class="rounded-3 shadow-sm"
                                         style="width: 90px; height: 110px; object-fit: cover;">
                                    <span class="position-absolute bottom-0 end-0 translate-middle badge rounded-pill bg-success shadow-sm">
                                        <i class="bi bi-check-lg"></i>
                                    </span>
                                </div>
                            </div>

                            {{-- Info Dokter --}}
                            <div class="col">
                                <div class="d-flex flex-column h-100">
                                    {{-- Nama & Spesialisasi --}}
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-1 text-dark">{{ $dokter->nama }}</h5>
                                        <p class="text-muted mb-0 d-flex align-items-center">
                                            <i class="bi bi-award-fill text-primary me-2"></i>
                                            {{ $dokter->spesialisasi->nama ?? 'Dokter Umum' }}
                                        </p>
                                    </div>

                                    {{-- Detail Info --}}
                                    <div class="mb-3">
                                        @if($dokter->jadwal_praktik_hari)
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="bg-light rounded-2 p-2 me-2" style="min-width: 32px; height: 32px;">
                                                <i class="bi bi-calendar3 text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Hari Praktik</small>
                                                <span class="fw-semibold text-dark" style="font-size: 0.85rem;">{{ $dokter->jadwal_praktik_hari }}</span>
                                            </div>
                                        </div>
                                        @endif

                                        @if($dokter->jadwal_praktik_waktu)
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="bg-light rounded-2 p-2 me-2" style="min-width: 32px; height: 32px;">
                                                <i class="bi bi-clock text-success"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Waktu Praktik</small>
                                                <span class="fw-semibold text-dark" style="font-size: 0.85rem;">{{ $dokter->jadwal_praktik_waktu }}</span>
                                            </div>
                                        </div>
                                        @endif

                                        @if($dokter->tempat_praktik)
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="bg-light rounded-2 p-2 me-2" style="min-width: 32px; height: 32px;">
                                                <i class="bi bi-hospital text-danger"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Tempat Praktik</small>
                                                <span class="fw-semibold text-dark" style="font-size: 0.85rem;">{{ Str::limit($dokter->tempat_praktik, 30) }}</span>
                                            </div>
                                        </div>
                                        @endif

                                        @if($dokter->pengalaman)
                                        <div class="d-flex align-items-start">
                                            <div class="bg-light rounded-2 p-2 me-2" style="min-width: 32px; height: 32px;">
                                                <i class="bi bi-briefcase text-warning"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">Pengalaman</small>
                                                <span class="fw-semibold text-dark" style="font-size: 0.85rem;">{{ $dokter->pengalaman }}</span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Button Chat --}}
                                    <div class="mt-auto">
                                        <a href="{{ route('user', $dokter->pengguna->id) }}"
                                           class="btn btn-success w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                            <i class="bi bi-chat-dots-fill"></i>
                                            Mulai Konsultasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Belum Ada Dokter Tersedia</h5>
                        <p class="text-muted mb-4">Saat ini belum ada dokter yang tersedia untuk spesialisasi ini.</p>
                        <a href="{{ route('user.konsultasi.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali ke Spesialisasi
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .hover-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
        border-color: rgba(40, 167, 69, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1aa67d 100%);
        box-shadow: 0 6px 16px rgba(40, 167, 69, 0.3);
        transform: translateY(-2px);
    }

    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .card {
        border-radius: 1rem;
        overflow: hidden;
    }

    .badge {
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .rounded-3 {
        border-radius: 0.75rem !important;
    }
</style>
@endpush
@endsection