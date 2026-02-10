@extends('layouts.app')

@section('title', 'Konsultasi')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">

        {{-- Card Konsultasi --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-comments fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Konsultasi Dokter</h5>
                    <p class="card-text">
                        Mulai konsultasi dengan dokter secara online.
                    </p>
                    <a href="{{ route('konsultasi.create') }}" class="btn btn-primary">
                        Mulai Konsultasi
                    </a>
                </div>
            </div>
        </div>

        {{-- Card Catatan Medis --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-notes-medical fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Catatan Medis</h5>
                    <p class="card-text">
                        Lihat riwayat dan hasil konsultasi medis Anda.
                    </p>
                    <a href="{{ route('catatan-medis.index') }}" class="btn btn-success">
                        Lihat Catatan
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
