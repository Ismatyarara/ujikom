@extends('layouts.app')

@section('content')

{{-- Greeting --}}
<div class="row mb-4">
    <div class="col-12 col-xl-8">
        <h3 class="font-weight-bold">
            Selamat Datang, {{ $profile->nama_panjang ?? Auth::user()->name }}!
        </h3>
        <h6 class="font-weight-normal mb-0">
            <span class="text-primary">HealTack</span> - Sistem Informasi Kesehatan Anda
        </h6>
    </div>
</div>

{{-- Alert --}}
@if(session('success'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show">
            <i class="icon-check"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    </div>
</div>
@endif

<div class="row">

    {{-- Profile Card --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">

                <img
                    src="{{ $profile && $profile->foto
                        ? asset('storage/'.$profile->foto)
                        : asset('assets/images/faces/face1.jpg') }}"
                    class="rounded-circle mb-3"
                    style="width:100px;height:100px;object-fit:cover;">

                <h5 class="mb-1">{{ $profile->nama_panjang ?? '-' }}</h5>
                <small class="text-muted">{{ Auth::user()->email }}</small>

                <div class="my-2">
                    <span class="badge badge-{{ ($profile->jenis_kelamin ?? '') == 'L' ? 'info' : 'warning' }}">
                        {{ ($profile->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </div>

                <small class="text-muted">
                    <i class="icon-calendar"></i>
                  {{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age.' tahun' : '-' }}
                </small>

                <hr>

                <a href="{{ route('user.profile.show') }}"
                   class="btn btn-primary btn-sm btn-block">
                    <i class="icon-user"></i> Lihat Profile Lengkap
                </a>
            </div>
        </div>
    </div>

    {{-- Quick Info --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informasi Cepat</h4>

                <div class="row">

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-primary text-white rounded-circle mr-3">
                                <i class="icon-drop"></i>
                            </div>
                            <div>
                                <small class="text-muted">Golongan Darah</small>
                                <h5 class="mb-0">{{ $profile->golongan_darah ?? '-' }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-success text-white rounded-circle mr-3">
                                <i class="icon-phone"></i>
                            </div>
                            <div>
                                <small class="text-muted">No. HP</small>
                                <h6 class="mb-0">{{ $profile->no_hp ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrapper bg-info text-white rounded-circle mr-3">
                                <i class="icon-location-pin"></i>
                            </div>
                            <div>
                                <small class="text-muted">Alamat</small>
                                <p class="mb-0">{{ $profile->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

{{-- Menu --}}
<div class="row">
@php
$menus = [
    ['icon'=>'icon-paper','color'=>'primary','title'=>'Konsultasi','desc'=>'Chat dengan dokter'],
    ['icon'=>'fas fa-pills','color'=>'success','title'=>'Lihat Obat','desc'=>'Informasi obat'],
    ['icon'=>'icon-calendar','color'=>'warning','title'=>'Jadwal Obat','desc'=>'Atur jadwal'],
    ['icon'=>'icon-user','color'=>'info','title'=>'Profile','desc'=>'Kelola profile','url'=>route('user.profile.show')],
];
@endphp

@foreach($menus as $menu)
<div class="col-md-3 grid-margin stretch-card">
    <div class="card card-menu-hover text-center">
        <div class="card-body">
            <i class="{{ $menu['icon'] }} text-{{ $menu['color'] }}" style="font-size:3rem"></i>
            <h5 class="mt-3">{{ $menu['title'] }}</h5>
            <p class="text-muted">{{ $menu['desc'] }}</p>
            <a href="{{ $menu['url'] ?? '#' }}"
               class="btn btn-{{ $menu['color'] }} btn-sm">Buka</a>
        </div>
    </div>
</div>
@endforeach
</div>

@push('styles')
<style>
.card-menu-hover {
    transition: .3s;
}
.card-menu-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,.1);
}
.icon-wrapper {
    width: 50px;
    height: 50px;
    display:flex;
    align-items:center;
    justify-content:center;
}
</style>
@endpush

@endsection
