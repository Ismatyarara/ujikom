@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    <h3 class="font-weight-bold">Selamat Datang, {{ auth()->user()->name }}!</h3>
    <p class="text-muted">Berikut adalah ringkasan sistem HealTack Anda</p>
  </div>
</div>

<div class="row">
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1">Total Dokter</p>
            <h3 class="mb-0 font-weight-bold">{{ $totalDokter }}</h3>
          </div>
          <div class="icon-holder bg-gradient-primary text-white rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-user-md fa-2x"></i>
          </div>
        </div>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-link btn-sm p-0 mt-2">
          Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1">Total User</p>
            <h3 class="mb-0 font-weight-bold">{{ $totalUser }}</h3>
          </div>
          <div class="icon-holder bg-gradient-success text-white rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-users fa-2x"></i>
          </div>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-link btn-sm p-0 mt-2">
          Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1">Total Staff</p>
            <h3 class="mb-0 font-weight-bold">{{ $totalStaff }}</h3>
          </div>
          <div class="icon-holder bg-gradient-info text-white rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-user-tie fa-2x"></i>
          </div>
        </div>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-link btn-sm p-0 mt-2">
          Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1">Total Obat</p>
            <h3 class="mb-0 font-weight-bold">{{ $totalObat }}</h3>
          </div>
          <div class="icon-holder bg-gradient-warning text-white rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-pills fa-2x"></i>
          </div>
        </div>
        <a href="{{ route('admin.obat.index') }}" class="btn btn-link btn-sm p-0 mt-2">
          Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Stok Obat</h4>
        <div class="d-flex align-items-center">
          <div class="mr-3">
            <i class="fas fa-box fa-3x text-primary"></i>
          </div>
          <div>
            <h2 class="mb-1 font-weight-bold">{{ number_format($stokObat) }}</h2>
            <p class="text-muted mb-0">Total Unit Tersedia</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Obat Menipis</h4>
        <div class="d-flex align-items-center">
          <div class="mr-3">
            <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
          </div>
          <div>
            <h2 class="mb-1 font-weight-bold">{{ $obatMenupis }}</h2>
            <p class="text-muted mb-0">Jenis Obat</p>
          </div>
        </div>
        @if($obatMenupis > 0)
        <a href="{{ route('admin.obat.index') }}" class="btn btn-warning btn-sm mt-3">
          <i class="fas fa-eye"></i> Cek Obat
        </a>
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Sistem</h4>
        <div class="d-flex align-items-center">
          <div class="mr-3">
            <i class="fas fa-cog fa-3x text-info"></i>
          </div>
          <div>
            <h5 class="mb-1 font-weight-bold">HealTack v1.0</h5>
            <p class="text-muted mb-0">Sistem Manajemen Klinik</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Quick Actions</h4>
        <div class="row">
          <div class="col-6 mb-3">
            <a href="{{ route('admin.dokter.create') }}" class="btn btn-outline-primary btn-block">
              <i class="fas fa-user-md"></i> Tambah Dokter
            </a>
          </div>
          <div class="col-6 mb-3">
            <a href="{{ route('admin.staff.create') }}" class="btn btn-outline-info btn-block">
              <i class="fas fa-user-tie"></i> Tambah Staff
            </a>
          </div>
          <div class="col-6 mb-3">
            <a href="{{ route('admin.obat.pembelian') }}" class="btn btn-outline-warning btn-block">
              <i class="fas fa-pills"></i> lihat pembelian
            </a>
          </div>
          <div class="col-6 mb-3">
            <a href="{{ route('admin.spesialisasi.create') }}" class="btn btn-outline-success btn-block">
              <i class="fas fa-stethoscope"></i> Tambah Spesialisasi
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Informasi</h4>
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> 
          <strong>Selamat Datang di HealTack!</strong>
          <p class="mb-0 mt-2">Sistem manajemen klinik terintegrasi untuk mengelola data dokter, staff, obat, dan konsultasi pasien.</p>
        </div>
        <div class="mt-3">
          <small class="text-muted">
            <i class="fas fa-calendar"></i> {{ now()->isoFormat('dddd, D MMMM YYYY') }}<br>
            <i class="fas fa-clock"></i> {{ now()->format('H:i') }} WIB
          </small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection