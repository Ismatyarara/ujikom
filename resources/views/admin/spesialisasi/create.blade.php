@extends('layouts.app')

@section('title', 'Tambah Spesialisasi')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Tambah Data Spesialisasi</h4>
        <p class="card-description">Lengkapi form di bawah ini</p>

        <form action="{{ route('admin.spesialisasi.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="forms-sample">
          @csrf

          {{-- Nama --}}
          <div class="form-group">
            <label>Nama Spesialisasi <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}"
                   placeholder="Contoh: Spesialis Penyakit Dalam"
                   required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Foto --}}
          <div class="form-group">
            <label>Foto</label>
            <input type="file"
                   name="foto"
                   class="form-control @error('foto') is-invalid @enderror">
            @error('foto')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Button --}}
          <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-save"></i> Simpan
          </button>
          <a href="{{ route('admin.spesialisasi.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
