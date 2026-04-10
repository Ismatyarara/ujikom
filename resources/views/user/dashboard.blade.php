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
    .avatar-fallback {
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #2563eb;
        color: #fff;
        font-weight: 700;
        font-size: 2rem;
    }
    .info-row {
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .info-row:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
@php
    $unreadDoctorReplyCount = $unreadDoctorReplyCount ?? 0;
    $latestDoctorReplies = $latestDoctorReplies ?? collect();
@endphp
<div class="mb-4">
    <h3 class="font-weight-bold mb-1">Selamat Datang, {{ $profile->nama_panjang ?? Auth::user()->name }}!</h3>
    <p class="text-muted mb-0"><span class="text-primary font-weight-bold">HealTack</span> - Sistem Informasi Kesehatan Anda</p>
</div>

@if($unreadDoctorReplyCount > 0)
    <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
        <div>
            <strong>{{ $unreadDoctorReplyCount }} balasan dokter belum dibaca.</strong>
            <div class="small">Buka chat untuk melihat pesan terbaru.</div>
        </div>
        <a href="{{ route(config('chatify.routes.prefix')) }}" class="btn btn-sm btn-primary">Buka Chat</a>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-md-4 mb-4 mb-md-0">
        <div class="card dash-card h-100">
            <div class="card-body text-center py-4">
                @if($profile && $profile->foto)
                    <img src="{{ asset('storage/'.$profile->foto) }}" class="avatar mb-3">
                @else
                    <div class="avatar avatar-fallback">{{ Auth::user()->initials }}</div>
                @endif

                <h5 class="mb-1">{{ $profile->nama_panjang ?? '-' }}</h5>
                <small class="text-muted d-block mb-2">{{ Auth::user()->email }}</small>

                <span class="badge badge-{{ ($profile->jenis_kelamin ?? '') == 'L' ? 'info' : 'warning' }} mb-2">
                    {{ ($profile->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>

                @if($profile->tanggal_lahir)
                    <p class="text-muted small mb-3">{{ \Carbon\Carbon::parse($profile->tanggal_lahir)->age }} tahun</p>
                @endif

                <a href="{{ route('user.profile.show') }}" class="btn btn-primary btn-sm btn-block">Lihat Profile</a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card dash-card h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">Informasi Pribadi</h5>

                @php
                $infos = [
                    ['label' => 'Golongan Darah', 'value' => $profile->golongan_darah ?? '-'],
                    ['label' => 'No. HP', 'value' => $profile->no_hp ?? '-'],
                    ['label' => 'Alamat', 'value' => $profile->alamat ?? '-'],
                ];
                @endphp

                @foreach($infos as $info)
                    <div class="info-row">
                        <small class="text-muted d-block">{{ $info['label'] }}</small>
                        <strong>{{ $info['value'] }}</strong>
                    </div>
                @endforeach

                @if($latestDoctorReplies->isNotEmpty())
                    <hr>
                    <h6 class="font-weight-bold">Balasan Dokter Terbaru</h6>
                    @foreach($latestDoctorReplies as $reply)
                        <div class="info-row">
                            <small class="text-muted d-block">{{ $reply->sender->name ?? 'Dokter' }}</small>
                            <strong>{{ \Illuminate\Support\Str::limit($reply->body, 60) }}</strong>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3 font-weight-bold">Menu Utama</h5>
<div class="row">
    @php
    $menus = [
        ['color' => 'primary', 'title' => 'Konsultasi', 'desc' => 'Chat dengan dokter', 'url' => route(config('chatify.routes.prefix'))],
        ['color' => 'success', 'title' => 'Lihat Obat', 'desc' => 'Informasi obat', 'url' => '#'],
        ['color' => 'warning', 'title' => 'Jadwal Obat', 'desc' => 'Atur jadwal minum', 'url' => '#'],
        ['color' => 'info', 'title' => 'Profile', 'desc' => 'Kelola data diri', 'url' => route('user.profile.show')],
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
