@extends('layouts.app')
@section('title', 'Lengkapi Profile')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Lengkapi Profile Anda</h4>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="icon-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="alert alert-info">
                        <i class="icon-info mr-2"></i>
                        Lengkapi profile Anda untuk dapat mengakses semua fitur aplikasi.
                    </div>

                    <form action="{{ route('user.profile.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        
                        <!-- Nama Lengkap -->
                        <div class="form-group row">
                            <label for="nama_panjang" class="col-sm-3 col-form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control @error('nama_panjang') is-invalid @enderror" 
                                       id="nama_panjang" 
                                       name="nama_panjang" 
                                       placeholder="Masukkan nama lengkap" 
                                       value="{{ old('nama_panjang') }}" 
                                       required>
                                @error('nama_panjang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="form-group row">
                            <label for="tanggal_lahir" class="col-sm-3 col-form-label">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="date" 
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" 
                                       name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir') }}" 
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-sm-3 col-form-label">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" 
                                        name="jenis_kelamin" 
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Golongan Darah -->
                        <div class="form-group row">
                            <label for="golongan_darah" class="col-sm-3 col-form-label">
                                Golongan Darah
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control @error('golongan_darah') is-invalid @enderror" 
                                        id="golongan_darah" 
                                        name="golongan_darah">
                                    <option value="">Pilih Golongan Darah (Opsional)</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                     <option value="-" {{ old('golongan_darah') == '-' ? 'selected' : '' }}>tidak tahu</option>
                                </select>
                                @error('golongan_darah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="form-group row">
                            <label for="no_hp" class="col-sm-3 col-form-label">
                                No HP <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="tel" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" 
                                       name="no_hp" 
                                       placeholder="08xxxxxxxxxx" 
                                       value="{{ old('no_hp') }}" 
                                       required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-3 col-form-label">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3" 
                                          placeholder="Masukkan alamat lengkap" 
                                          required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Foto Profile -->
                        <div class="form-group row">
                            <label for="foto" class="col-sm-3 col-form-label">
                                Foto Profile
                            </label>
                            <div class="col-sm-9">
                                <input type="file" 
                                       class="form-control @error('foto') is-invalid @enderror" 
                                       id="foto" 
                                       name="foto" 
                                       accept="image/jpeg,image/png,image/jpg">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: JPG, PNG, JPEG. Max: 2MB</small>
                                <div class="mt-3">
                                    <img id="preview" class="img-thumbnail" style="max-width: 200px; display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="icon-check"></i> Simpan Profile
                                </button>
                                <button type="reset" class="btn btn-light">
                                    <i class="icon-refresh"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('foto').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    const file = e.target.files[0];
    
    if (file) {
        if (file.size > 2048000) {
            alert('Ukuran file terlalu besar. Maksimal 2MB');
            this.value = '';
            preview.style.display = 'none';
            return;
        }
        
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush