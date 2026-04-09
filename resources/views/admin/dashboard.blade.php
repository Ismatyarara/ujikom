@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
  .admin-hero {
    margin-bottom: 22px;
  }
  .admin-hero-title {
    font-weight: 800;
    color: #111827;
    margin-bottom: 6px;
  }
  .stat-card {
    border: 1px solid #edf1f7;
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
  }
  .quick-card {
    border: 1px solid #edf1f7;
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
  }
</style>
<div class="row">
  <div class="col-12 admin-hero">
    <h3 class="admin-hero-title">Selamat Datang, {{ auth()->user()->name }}!</h3>
    <p class="text-muted">Berikut adalah ringkasan sistem HealTack Anda</p>
  </div>
</div>

<div class="row">
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card stat-card">
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
    <div class="card stat-card">
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
    <div class="card stat-card">
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
    <div class="card stat-card">
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
    <div class="card stat-card">
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
    <div class="card stat-card">
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
    <div class="card stat-card">
      <div class="card-body">
        <h4 class="card-title">Hari Ini</h4>
        <div class="d-flex align-items-center">
          <div class="mr-3">
            <i class="fas fa-calendar-day fa-3x text-info"></i>
          </div>
          <div>
            <h5 class="mb-1 font-weight-bold">{{ now()->isoFormat('dddd') }}</h5>
            <p class="text-muted mb-0">{{ now()->isoFormat('D MMMM YYYY') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card quick-card">
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
              <i class="fas fa-pills"></i> Monitoring Pembelian
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
</div>
@endsection
