@extends('layouts.app')
@section('title', 'Konsultasi')
@section('content')
    <div class="container py-5">
        <div class="mb-4">
            <h3 class="fw-bold">Konsultasi Kesehatan</h3>
            <p class="text-muted mb-0">
                Layanan konsultasi kesehatan online
            </p>
        </div>

        {{-- Chat Konsultasi --}}
        <div class="mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1">💬 Chat Konsultasi</h5>
                        <p class="text-muted mb-0">Konsultasi langsung dengan dokter.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Spesialisasi --}}
        <div class="mb-3">
            <h5 class="fw-bold">Pilih Spesialisasi</h5>
        </div>
        <div class="row g-3">
            @foreach ($spesialisasis as $items)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('user.konsultasi.show', $items->id) }}" 
                       class="text-decoration-none text-dark">
                        <div class="text-center">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-2" 
                                 style="width: 80px; height: 80px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $items->foto) }}" 
                                     alt="{{ $items->name }}"
                                     class="w-100 h-100" 
                                     style="object-fit: cover;">
                            </div>
                            <p class="small mb-0 text-center" style="font-size: 0.85rem;">
                                {{ $items->name }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($spesialisasis->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $spesialisasis->links() }}
            </div>
        @endif
    </div>
@endsection