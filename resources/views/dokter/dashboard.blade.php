@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Dashboard Dokter</h1>
            <p class="text-muted mb-0">Selamat datang kembali, **dr. {{ auth()->user()->name }}**</p>
        </div>
        <div class="d-none d-sm-inline-block">
            <span class="badge bg-light text-primary border px-3 py-2">
                <i class="fas fa-calendar-alt me-1"></i> {{ date('d M Y') }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 small fw-bold">Total Pasien</div>
                            <div class="h2 mb-0 fw-bold text-dark">{{ $totalPasien ?? 0 }}</div>
                        </div>
                        <div class="bg-light p-3 rounded-circle">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 small fw-bold">Janji Hari Ini</div>
                            <div class="h2 mb-0 fw-bold text-dark">{{ $appointmentHariIni ?? 0 }}</div>
                        </div>
                        <div class="bg-light p-3 rounded-circle">
                            <i class="fas fa-calendar-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1 small fw-bold">Konsultasi (Bulan Ini)</div>
                            <div class="h2 mb-0 fw-bold text-dark">{{ $konsultasiBulanIni ?? 0 }}</div>
                        </div>
                        <div class="bg-light p-3 rounded-circle">
                            <i class="fas fa-comments fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 small fw-bold">Rating Dokter</div>
                            <div class="h2 mb-0 fw-bold text-dark">{{ number_format($rating ?? 4.8, 1) }}</div>
                        </div>
                        <div class="bg-light p-3 rounded-circle">
                            <i class="fas fa-star fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-user-circle me-2 text-primary"></i>Informasi Akun</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D6EFD&color=fff" 
                             class="rounded-circle shadow-sm" width="80" alt="Avatar">
                    </div>
                    <h5 class="fw-bold mb-0">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small">{{ auth()->user()->email }}</p>
                    
                    <hr class="my-4">
                    
                    <div class="table-responsive text-start">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th class="text-muted fw-normal">Status Akun</th>
                                <td class="text-end"><span class="badge bg-success-soft text-success px-3">Aktif</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Terdaftar Sejak</th>
                                <td class="text-end fw-bold">{{ auth()->user()->created_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-4">Edit Profil</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-clock me-2 text-primary"></i>Janji Mendatang</h5>
                    <a href="#" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <p class="text-center text-muted py-5">Belum ada jadwal janji untuk saat ini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .text-xs { font-size: .7rem; }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
</style>
@endsection