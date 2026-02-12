@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <a href="{{ route('user.catatan.index') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-notes-medical"></i> Detail Catatan Medis
                    </h4>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4 pb-3 border-bottom">
                        <div class="col-md-6">
                            <label class="text-muted small">Dokter Pemeriksa</label>
                            <h6>
                                <i class="fas fa-user-md text-primary"></i> 
                                Dr. {{ $catatan->dokter->pengguna->name ?? '-' }}
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Tanggal Pemeriksaan</label>
                            <h6>
                                <i class="fas fa-calendar text-primary"></i>
                                {{ \Carbon\Carbon::parse($catatan->tanggal_catatan)->format('d F Y, H:i') }} WIB
                            </h6>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted fw-bold mb-2">
                            <i class="fas fa-stethoscope"></i> Diagnosa
                        </label>
                        <div class="alert alert-info">
                            <h5 class="mb-0">{{ $catatan->diagnosa }}</h5>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted fw-bold mb-2">
                            <i class="fas fa-comment-medical"></i> Keluhan Pasien
                        </label>
                        <div class="p-3 bg-light rounded border">
                            {{ $catatan->keluhan }}
                        </div>
                    </div>

                    @if($catatan->deskripsi)
                    <div class="mb-4">
                        <label class="text-muted fw-bold mb-2">
                            <i class="fas fa-file-medical"></i> Catatan Dokter
                        </label>
                        <div class="p-3 bg-light rounded border">
                            {{ $catatan->deskripsi }}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer text-muted">
                    <small>
                        <i class="fas fa-info-circle"></i>
                        Catatan dibuat pada {{ \Carbon\Carbon::parse($catatan->created_at)->format('d F Y, H:i') }} WIB
                    </small>
                </div>
            </div>

            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-outline-primary">
                    <i class="fas fa-print"></i> Cetak Catatan
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .btn, .card-footer, nav, footer {
            display: none !important;
        }
    }
</style>
@endpush
@endsection