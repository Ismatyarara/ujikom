@extends('layouts.user')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Selamat Datang, {{ $profile->nama_panjang }}!</h3>
                    <h6 class="font-weight-normal mb-0">
                        <span class="text-primary">HealTack</span> - Sistem Informasi Kesehatan Anda
                    </h6>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon-check"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <!-- Card Profile Summary -->
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($profile->foto)
                            <img src="{{ asset('storage/'.$profile->foto) }}" 
                                 alt="Foto Profile" 
                                 class="rounded-circle" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/images/faces/face1.jpg') }}" 
                                 alt="Default Photo" 
                                 class="rounded-circle" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $profile->nama_panjang }}</h5>
                    <p class="text-muted mb-2">
                        <small>{{ Auth::user()->email }}</small>
                    </p>
                    <span class="badge badge-{{ $profile->jenis_kelamin == 'L' ? 'info' : 'warning' }} mb-2">
                        {{ $profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                    <p class="text-muted mb-0">
                        <small><i class="icon-calendar"></i> {{ $profile->usia }} tahun</small>
                    </p>
                    <hr>
                    <a href="{{ route('user.profile.show') }}" class="btn btn-primary btn-sm btn-block">
                        <i class="icon-user"></i> Lihat Profile Lengkap
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informasi Cepat</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-primary text-white rounded-circle p-3 mr-3">
                                    <i class="icon-drop"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Golongan Darah</p>
                                    <h5 class="mb-0">{{ $profile->golongan_darah ?? '-' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-success text-white rounded-circle p-3 mr-3">
                                    <i class="icon-phone"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">No. HP</p>
                                    <h6 class="mb-0">{{ $profile->no_hp ?? '-' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-wrapper bg-info text-white rounded-circle p-3 mr-3">
                                    <i class="icon-location-pin"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Alamat</p>
                                    <p class="mb-0">{{ $profile->alamat ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-menu-hover">
                <div class="card-body text-center">
                    <i class="icon-paper text-primary" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Konsultasi</h5>
                    <p class="text-muted">Chat dengan dokter</p>
                    <a href="#" class="btn btn-primary btn-sm">Mulai Chat</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-menu-hover">
                <div class="card-body text-center">
                    <i class="fas fa-pills text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Lihat Obat</h5>
                    <p class="text-muted">Informasi obat</p>
                    <a href="#" class="btn btn-success btn-sm">Lihat</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-menu-hover">
                <div class="card-body text-center">
                    <i class="icon-calendar text-warning" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Jadwal Minum Obat</h5>
                    <p class="text-muted">Atur jadwal</p>
                    <a href="#" class="btn btn-warning btn-sm">Atur</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-menu-hover">
                <div class="card-body text-center">
                    <i class="icon-user text-info" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Profile Saya</h5>
                    <p class="text-muted">Kelola profile</p>
                    <a href="{{ route('user.profile.show') }}" class="btn btn-info btn-sm">Lihat</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card-menu-hover {
    transition: all 0.3s ease;
    cursor: pointer;
}
.card-menu-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.icon-wrapper {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush
@endsection