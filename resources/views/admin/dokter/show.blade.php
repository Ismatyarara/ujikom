@extends('layouts.app')

@section('title', 'Detail Dokter')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Detail Dokter</h4>
          <div>
            <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-light btn-sm">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-5 mb-4">
            <div class="text-center">
              <img src="{{ $dokter->foto_url }}" alt="Foto Dokter" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">
              <h5 class="mb-2">{{ $dokter->nama }}</h5>
              <span class="badge badge-info badge-pill mb-3">{{ $dokter->spesialisasi->name ?? '-' }}</span>
              <div class="text-muted small">
                <div class="mb-1"><i class="fas fa-user"></i> {{ $dokter->pengguna->name ?? '-' }}</div>
                <div><i class="fas fa-envelope"></i> {{ $dokter->pengguna->email ?? '-' }}</div>
              </div>
            </div>
          </div>

          <div class="col-lg-8 col-md-7">
            <h5 class="mb-3"><i class="fas fa-info-circle text-primary"></i> Informasi Dokter</h5>
            <div class="table-responsive">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td width="200" class="font-weight-bold">Nama Lengkap</td>
                    <td>{{ $dokter->nama }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Spesialisasi</td>
                    <td><span class="badge badge-info">{{ $dokter->spesialisasi->name ?? '-' }}</span></td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Jadwal Praktik</td>
                    <td>
                      <div><i class="fas fa-calendar text-primary"></i> {{ $dokter->jadwal_praktik_hari }}</div>
                      <div><i class="fas fa-clock text-primary"></i> {{ $dokter->jadwal_praktik_waktu }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Tempat Praktik</td>
                    <td>{{ $dokter->tempat_praktik }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Status Akun</td>
                    <td>
                      @if($dokter->pengguna->email_verified_at)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                      @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Belum Terverifikasi</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Terdaftar Sejak</td>
                    <td>{{ $dokter->created_at->format('d M Y, H:i') }} WIB</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Terakhir Diupdate</td>
                    <td>{{ $dokter->updated_at->format('d M Y, H:i') }} WIB</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <hr class="my-4">

            <h5 class="mb-3"><i class="fas fa-chart-line text-success"></i> Statistik Konsultasi</h5>
            <div class="row">
              <div class="col-sm-6 mb-3">
                <div class="card bg-gradient-primary text-white">
                  <div class="card-body text-center py-3">
                    <i class="fas fa-comments fa-2x mb-2"></i>
                    <h3 class="mb-1">0</h3>
                    <p class="mb-0 small">Total Konsultasi</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 mb-3">
                <div class="card bg-gradient-success text-white">
                  <div class="card-body text-center py-3">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h3 class="mb-1">0</h3>
                    <p class="mb-0 small">Selesai</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection