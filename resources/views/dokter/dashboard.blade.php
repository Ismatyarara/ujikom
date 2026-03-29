@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Dashboard Dokter</h1>
            <p class="text-muted mb-0">Selamat datang kembali, dr. {{ auth()->user()->name }}</p>
        </div>
        <div class="d-none d-sm-inline-block">
            <span class="badge bg-light text-primary border px-3 py-2">
                {{ date('d M Y') }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    {{-- Info + Janji --}}
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">Informasi Akun</h5>
                </div>
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D6EFD&color=fff"
                         class="rounded-circle shadow-sm mb-3" width="80" alt="Avatar">

                    <h5 class="fw-bold mb-0">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small">{{ auth()->user()->email }}</p>

                    <hr>

                    <table class="table table-sm table-borderless mb-0 text-start">
                        <tr>
                            <td class="text-muted">Status Akun</td>
                            <td class="text-end"><span class="badge bg-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terdaftar Sejak</td>
                            <td class="text-end fw-bold">{{ auth()->user()->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary px-4">Edit Profil</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold text-dark">Janji Mendatang</h5>
                    <a href="#" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <p class="text-muted">Belum ada jadwal janji untuk saat ini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
</style>
@endsection