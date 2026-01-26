@extends('layouts.app')

@section('title', 'Tambah Spesialisasi')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Tambah Data Spesialisasi</h4>
        <p class="card-description">Lengkapi form di bawah ini</p>
        
        <form action="{{ route('admin.spesialisasi.store') }}" method="POST" class="forms-sample">
          @csrf
          
          <div class="form-group">
            <label for="name">Nama Spesialisasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" 
                   placeholder="Contoh: Spesialis Penyakit Dalam" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
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