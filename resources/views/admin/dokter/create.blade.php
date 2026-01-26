@extends('layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Tambah Data Dokter</h4>
        <p class="card-description">Lengkapi form di bawah ini</p>
        
        <form action="{{ route('admin.dokter.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Nama User <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" 
                       placeholder="Nama untuk login" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       placeholder="email@example.com" required>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" 
                       placeholder="Minimal 8 karakter" required>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama Dokter <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                       id="nama" name="nama" value="{{ old('nama') }}" 
                       placeholder="Dr. Nama Lengkap" required>
                @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="id_spesialisasi">Spesialisasi <span class="text-danger">*</span></label>
                <select class="form-control @error('id_spesialisasi') is-invalid @enderror" 
                        id="id_spesialisasi" name="id_spesialisasi" required>
                  <option value="">-- Pilih Spesialisasi --</option>
                  @foreach($spesialisasi as $item)
                    <option value="{{ $item->id }}" {{ old('id_spesialisasi') == $item->id ? 'selected' : '' }}>
                      {{ $item->name }}
                    </option>
                  @endforeach
                </select>
                @error('id_spesialisasi')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="foto">Foto Profil</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                       id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Max: 2MB</small>
                @error('foto')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="imagePreview" class="mt-2" style="display: none;">
                  <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="jadwal_praktik_hari">Jadwal Praktik (Hari) <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jadwal_praktik_hari') is-invalid @enderror" 
                       id="jadwal_praktik_hari" name="jadwal_praktik_hari" value="{{ old('jadwal_praktik_hari') }}" 
                       placeholder="Senin - Jumat" required>
                @error('jadwal_praktik_hari')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="jadwal_praktik_waktu">Jadwal Praktik (Waktu) <span class="text-danger">*</span></label>
                <div class="row">
                  <div class="col-5">
                    <input type="time" class="form-control @error('jadwal_praktik_waktu') is-invalid @enderror" 
                           id="waktu_mulai" value="{{ old('waktu_mulai', '08:00') }}" required>
                  </div>
                  <div class="col-2 text-center pt-2">
                    <span>s/d</span>
                  </div>
                  <div class="col-5">
                    <input type="time" class="form-control @error('jadwal_praktik_waktu') is-invalid @enderror" 
                           id="waktu_selesai" value="{{ old('waktu_selesai', '16:00') }}" required>
                  </div>
                </div>
                <input type="hidden" name="jadwal_praktik_waktu" id="jadwal_praktik_waktu" value="{{ old('jadwal_praktik_waktu') }}">
                @error('jadwal_praktik_waktu')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="tempat_praktik">Tempat Praktik <span class="text-danger">*</span></label>
            <textarea class="form-control @error('tempat_praktik') is-invalid @enderror" 
                      id="tempat_praktik" name="tempat_praktik" rows="3" 
                      placeholder="Alamat lengkap tempat praktik" required>{{ old('tempat_praktik') }}</textarea>
            @error('tempat_praktik')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-save"></i> Simpan
          </button>
          <a href="{{ route('admin.dokter.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function previewImage(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      preview.src = e.target.result;
      imagePreview.style.display = 'block';
    }
    reader.readAsDataURL(file);
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const update = () => jadwal_praktik_waktu.value = `${waktu_mulai.value} - ${waktu_selesai.value}`;
  update();
  waktu_mulai.onchange = waktu_selesai.onchange = update;
});
</script>
@endsection