@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="h3 mb-1">Dashboard Dokter</h1>
        <p class="text-muted">Selamat datang, {{ $dokter->name }}</p>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Pasien</h6>
                    <h2 class="mb-0">{{ $totalPasien ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Janji Hari Ini</h6>
                    <h2 class="mb-0">{{ $appointmentHariIni ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Konsultasi Bulan Ini</h6>
                    <h2 class="mb-0">{{ $konsultasiBulanIni ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Rating</h6>
                    <h2 class="mb-0">{{ number_format($rating ?? 4.8, 1) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Info Akun -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="100">Nama</th>
                            <td>{{ $dokter->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $dokter->email }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge badge-success">Aktif</span></td>
                        </tr>
                    </table>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection