@extends('layouts.app')

@section('title', 'Detail Spesialisasi')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Detail Spesialisasi</h4>
          <div>
            <a href="{{ route('admin.spesialisasi.edit', $spesialisasi->id) }}"
               class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.spesialisasi.index') }}"
               class="btn btn-light btn-sm">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>

        {{-- Info Spesialisasi --}}
        <div class="row">
          <div class="col-md-3 text-center">
            @if ($spesialisasi->foto)
              <img src="{{ asset('storage/'.$spesialisasi->foto) }}"
                   class="rounded mb-3"
                   width="120">
            @else
              <span class="text-muted">Tidak ada foto</span>
            @endif
          </div>

          <div class="col-md-9">
            <table class="table table-borderless mb-0">
              <tbody>
                <tr>
                  <td width="200"><strong>Nama Spesialisasi</strong></td>
                  <td>: {{ $spesialisasi->name }}</td>
                </tr>
                <tr>
                  <td><strong>Jumlah Dokter</strong></td>
                  <td>: {{ $spesialisasi->dokter_count ?? 0 }} Dokter</td>
                </tr>
                <tr>
                  <td><strong>Dibuat Pada</strong></td>
                  <td>: {{ $spesialisasi->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Terakhir Diupdate</strong></td>
                  <td>: {{ $spesialisasi->updated_at->format('d M Y H:i') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        {{-- Daftar Dokter --}}
        @if($spesialisasi->dokter && $spesialisasi->dokter->count())
        <hr>
        <h5 class="mb-3">
          Daftar Dokter ({{ $spesialisasi->dokter->count() }})
        </h5>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Dokter</th>
                <th>Email</th>
                <th>Jadwal</th>
                <th>Tempat Praktik</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($spesialisasi->dokter as $key => $dokter)
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                  <img src="{{ $dokter->foto
                        ? asset('storage/'.$dokter->foto)
                        : asset('assets/images/faces/face1.jpg') }}"
                       class="rounded-circle"
                       width="40" height="40">
                </td>
                <td>
                  <strong>{{ $dokter->nama }}</strong><br>
                  <small class="text-muted">
                    {{ $dokter->pengguna->name ?? '-' }}
                  </small>
                </td>
                <td>{{ $dokter->pengguna->email ?? '-' }}</td>
                <td>
                  <small>
                    <i class="fas fa-calendar"></i> {{ $dokter->jadwal_praktik_hari }}<br>
                    <i class="fas fa-clock"></i> {{ $dokter->jadwal_praktik_waktu }}
                  </small>
                </td>
                <td>{{ Str::limit($dokter->tempat_praktik, 25) }}</td>
                <td class="text-center">
                  <a href="{{ route('admin.dokter.show', $dokter->id) }}"
                     class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.dokter.edit', $dokter->id) }}"
                     class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <hr>
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i>
          Belum ada dokter pada spesialisasi ini.
        </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection
