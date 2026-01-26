@extends('layouts.app')

@section('title', 'Edit Staff')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Data Staff</h4>
        <p class="card-description">Perbarui data staff</p>
        
        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" class="forms-sample">
          @csrf
          @method('PUT')
          
          <div class="form-group">
            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $staff->name) }}" 
                   placeholder="Nama lengkap staff" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $staff->email) }}" 
                   placeholder="email@example.com" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" 
                       placeholder="Kosongkan jika tidak ingin mengubah password">
                <small class="form-text text-muted">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah.</small>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" class="form-control" 
                       id="password_confirmation" name="password_confirmation" 
                       placeholder="Ulangi password">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('status') is-invalid @enderror" 
                    id="status" name="status" required>
              <option value="">-- Pilih Status --</option>
              <option value="aktif" {{ old('status', $staff->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="nonaktif" {{ old('status', $staff->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-save"></i> Update
          </button>
          <a href="{{ route('admin.staff.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection