@extends('layouts.app')

@section('title', 'Edit Spesialisasi')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Data Spesialisasi</h4>
        <p class="card-description">Perbarui data spesialisasi</p>

        <form action="{{ route('admin.spesialisasi.update', $spesialisasi->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="forms-sample">
          @csrf
          @method('PUT')

          {{-- Nama --}}
          <div class="form-group">
            <label>Nama Spesialisasi <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $spesialisasi->name) }}"
                   placeholder="Contoh: Spesialis Penyakit Dalam"
                   required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Foto lama --}}
          @if ($spesialisasi->foto)
            <div class="form-group">
              <label>Foto Saat Ini</label><br>
              <img src="{{ asset('storage/'.$spesialisasi->foto) }}"
                   width="80" height="80"
                   class="rounded mb-2">
            </div>
          @endif

          {{-- Foto baru --}}
          <div class="form-group">
            <label>Ganti Foto</label>
            <input type="file"
                   name="foto"
                   class="form-control @error('foto') is-invalid @enderror">
            @error('foto')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Button --}}
          <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-save"></i> Update
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
