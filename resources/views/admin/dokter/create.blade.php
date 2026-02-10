@extends('layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Data Dokter</h4>
                        <p class="card-subtitle">Lengkapi form di bawah ini</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.dokter.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama --}}
                            <div class="form-group mb-3">
                                <label for="nama">Nama Dokter <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}"
                                    placeholder="Masukkan nama dokter" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group mb-3">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan password (minimal 8 karakter)" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tempat Praktik --}}
                            <div class="form-group mb-3">
                                <label for="tempat_praktik">Tempat Praktik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tempat_praktik') is-invalid @enderror"
                                    id="tempat_praktik" name="tempat_praktik" value="{{ old('tempat_praktik') }}"
                                    placeholder="Masukkan tempat praktik" required>
                                @error('tempat_praktik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Spesialisasi --}}
                            <div class="form-group mb-3">
                                <label for="spesialisasi_id">Spesialisasi <span class="text-danger">*</span></label>
                                <select class="form-control @error('spesialisasi_id') is-invalid @enderror"
                                    id="spesialisasi_id" name="spesialisasi_id" required>
                                    <option value="">-- Pilih Spesialisasi --</option>
                                    @foreach ($spesialisasi as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('spesialisasi_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('spesialisasi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Foto --}}
                            <div class="form-group mb-3">
                                <label for="foto">Foto Dokter</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/jpeg,image/png,image/jpg">
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jadwal Praktik Hari --}}
                            <div class="form-group mb-3">
                                <label>Jadwal Praktik (Hari) <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control @error('jadwal_praktik_hari') is-invalid @enderror" 
                                                id="hari_dari" required>
                                            <option value="">-- Dari Hari --</option>
                                            <option value="Senin" {{ old('hari_dari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                            <option value="Selasa" {{ old('hari_dari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                            <option value="Rabu" {{ old('hari_dari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                            <option value="Kamis" {{ old('hari_dari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                            <option value="Jumat" {{ old('hari_dari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                            <option value="Sabtu" {{ old('hari_dari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                            <option value="Minggu" {{ old('hari_dari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control @error('jadwal_praktik_hari') is-invalid @enderror" 
                                                id="hari_sampai" required>
                                            <option value="">-- Sampai Hari --</option>
                                            <option value="Senin" {{ old('hari_sampai') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                            <option value="Selasa" {{ old('hari_sampai') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                            <option value="Rabu" {{ old('hari_sampai') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                            <option value="Kamis" {{ old('hari_sampai') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                            <option value="Jumat" {{ old('hari_sampai') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                            <option value="Sabtu" {{ old('hari_sampai') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                            <option value="Minggu" {{ old('hari_sampai') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="jadwal_praktik_hari" name="jadwal_praktik_hari" value="{{ old('jadwal_praktik_hari') }}">
                                @error('jadwal_praktik_hari')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jadwal Praktik Waktu --}}
                            <div class="form-group mb-3">
                                <label>Jadwal Praktik (Waktu) <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="time" class="form-control @error('jadwal_praktik_waktu') is-invalid @enderror"
                                               id="waktu_dari" value="{{ old('waktu_dari', '08:00') }}" required>
                                        <small class="form-text text-muted">Waktu Mulai</small>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control @error('jadwal_praktik_waktu') is-invalid @enderror"
                                               id="waktu_sampai" value="{{ old('waktu_sampai', '16:00') }}" required>
                                        <small class="form-text text-muted">Waktu Selesai</small>
                                    </div>
                                </div>
                                <input type="hidden" id="jadwal_praktik_waktu" name="jadwal_praktik_waktu" value="{{ old('jadwal_praktik_waktu') }}">
                                @error('jadwal_praktik_waktu')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pengalaman --}}
                            <div class="form-group mb-3">
                                <label for="pengalaman">Pengalaman Dokter</label>
                                <textarea class="form-control @error('pengalaman') is-invalid @enderror" id="pengalaman" name="pengalaman"
                                    rows="3" placeholder="Contoh: 5 tahun di RS, 2 tahun praktik mandiri">{{ old('pengalaman') }}</textarea>
                                @error('pengalaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
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
$(document).ready(function() {
    // Fungsi untuk menggabungkan hari
    function updateJadwalHari() {
        var hariDari = $('#hari_dari').val();
        var hariSampai = $('#hari_sampai').val();
        
        if (hariDari && hariSampai) {
            if (hariDari === hariSampai) {
                $('#jadwal_praktik_hari').val(hariDari);
            } else {
                $('#jadwal_praktik_hari').val(hariDari + ' - ' + hariSampai);
            }
        }
    }
    
    // Fungsi untuk menggabungkan waktu
    function updateJadwalWaktu() {
        var waktuDari = $('#waktu_dari').val();
        var waktuSampai = $('#waktu_sampai').val();
        
        if (waktuDari && waktuSampai) {
            $('#jadwal_praktik_waktu').val(waktuDari + ' - ' + waktuSampai);
        }
    }
    
    // Event listener untuk hari
    $('#hari_dari, #hari_sampai').on('change', function() {
        updateJadwalHari();
    });
    
    // Event listener untuk waktu
    $('#waktu_dari, #waktu_sampai').on('change', function() {
        updateJadwalWaktu();
    });
    
    // Set initial values saat halaman dimuat
    updateJadwalHari();
    updateJadwalWaktu();
    
    // Preview foto
    $('#foto').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Validasi ukuran file (max 2MB)
            if (file.size > 2048000) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                $(this).val('');
                return;
            }
            
            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung! Gunakan JPEG, PNG, atau JPG');
                $(this).val('');
                return;
            }
        }
    });
    
    // Validasi sebelum submit
    $('form').on('submit', function(e) {
        var hariDari = $('#hari_dari').val();
        var hariSampai = $('#hari_sampai').val();
        var waktuDari = $('#waktu_dari').val();
        var waktuSampai = $('#waktu_sampai').val();
        
        if (!hariDari || !hariSampai) {
            e.preventDefault();
            alert('Silakan pilih hari praktik (dari dan sampai)');
            $('#hari_dari').focus();
            return false;
        }
        
        if (!waktuDari || !waktuSampai) {
            e.preventDefault();
            alert('Silakan isi waktu praktik (dari dan sampai)');
            $('#waktu_dari').focus();
            return false;
        }
        
        // Validasi waktu dari harus lebih kecil dari waktu sampai
        if (waktuDari >= waktuSampai) {
            e.preventDefault();
            alert('Waktu mulai harus lebih awal dari waktu selesai!');
            $('#waktu_dari').focus();
            return false;
        }
        
        // Update hidden fields sebelum submit
        updateJadwalHari();
        updateJadwalWaktu();
    });
});
</script>
@endpush