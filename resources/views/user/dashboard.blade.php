@extends('layouts.app')

@push('styles')
<style>
    .dash-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
        transition: transform .2s, box-shadow .2s;
    }
    .dash-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
    }
    .avatar {
        width: 90px; height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #e9ecef;
    }
    .info-row {
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .info-row:last-child { border-bottom: none; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="mb-4">
    <h3 class="font-weight-bold mb-1">
        Selamat Datang, {{ $profile->nama_panjang ?? Auth::user()->name }}!
    </h3>
    <p class="text-muted mb-0"><span class="text-primary font-weight-bold">HealTack</span> — Sistem Informasi Kesehatan Anda</p>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

{{-- Top Row: Profile + Info --}}
<div class="row mb-4">

    {{-- Profile --}}
    <div class="col-md-4 mb-4 mb-md-0">
        <div class="card dash-card h-100">
            <div class="card-body text-center py-4">
                <img src="{{ $profile && $profile->foto ? asset('storage/'.$profile->foto) : asset('assets/images/faces/face1.jpg') }}"
                     class="avatar mb-3">

                <h5 class="mb-1">{{ $profile->nama_panjang ?? '-' }}</h5>
                <small class="text-muted d-block mb-2">{{ Auth::user()->email }}</small>

                <span class="badge badge-{{ ($profile->jenis_kelamin ?? '') == 'L' ? 'info' : 'warning' }} mb-2">
                    {{ ($profile->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>

                @if($profile->tanggal_lahir)
                    <p class="text-muted small mb-3">
                        {{ \Carbon\Carbon::parse($profile->tanggal_lahir)->age }} tahun
                    </p>
                @endif

                <a href="{{ route('user.profile.show') }}" class="btn btn-primary btn-sm btn-block">
                    Lihat Profile
                </a>
            </div>
        </div>
    </div>

    {{-- Quick Info --}}
    <div class="col-md-8">
        <div class="card dash-card h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">Informasi Pribadi</h5>

                @php
                $infos = [
                    ['label' => 'Golongan Darah', 'value' => $profile->golongan_darah ?? '-'],
                    ['label' => 'No. HP',         'value' => $profile->no_hp ?? '-'],
                    ['label' => 'Alamat',         'value' => $profile->alamat ?? '-'],
                ];
                @endphp

                @foreach($infos as $info)
                    <div class="info-row">
                        <small class="text-muted d-block">{{ $info['label'] }}</small>
                        <strong>{{ $info['value'] }}</strong>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>

{{-- Menu Cards --}}
<h5 class="mb-3 font-weight-bold">Menu Utama</h5>
<div class="row">

    @php
    $menus = [
        ['color' => 'primary', 'title' => 'Konsultasi',  'desc' => 'Chat dengan dokter',  'url' => '#'],
        ['color' => 'success', 'title' => 'Lihat Obat',  'desc' => 'Informasi obat',      'url' => '#'],
        ['color' => 'warning', 'title' => 'Jadwal Obat', 'desc' => 'Atur jadwal minum',   'url' => '#'],
        ['color' => 'info',    'title' => 'Profile',     'desc' => 'Kelola data diri',    'url' => route('user.profile.show')],
    ];
    @endphp

    @foreach($menus as $menu)
    <div class="col-6 col-md-3 mb-4">
        <div class="card dash-card text-center">
            <div class="card-body py-4">
                <h6 class="font-weight-bold mb-1">{{ $menu['title'] }}</h6>
                <p class="text-muted small mb-3">{{ $menu['desc'] }}</p>
                <a href="{{ $menu['url'] }}" class="btn btn-outline-{{ $menu['color'] }} btn-sm">Buka</a>
            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection