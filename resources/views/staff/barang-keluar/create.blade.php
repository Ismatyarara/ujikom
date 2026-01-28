@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Tambah Barang Keluar</h4>
                    <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-light btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Terdapat kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('staff.barang-keluar.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Informasi Obat</h5>

                                    <div class="form-group">
                                        <label for="id_obat">Pilih Obat <span class="text-danger">*</span></label>
                                        <select name="id_obat" id="id_obat"
                                                class="form-control @error('id_obat') is-invalid @enderror" required>
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($obat as $item)
                                                <option value="{{ $item->id }}" 
                                                        data-stok="{{ $item->stok }}"
                                                        data-satuan="{{ $item->satuan }}"
                                                        {{ old('id_obat') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->kode_obat }} - {{ $item->nama_obat }} 
                                                    (Stok: {{ $item->stok }} {{ $item->satuan }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_obat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jumlah">Jumlah Keluar <span class="text-danger">*</span></label>
                                        <input type="number" name="jumlah" id="jumlah"
                                               class="form-control @error('jumlah') is-invalid @enderror"
                                               value="{{ old('jumlah') }}"
                                               min="1" placeholder="0" required>
                                        @error('jumlah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted" id="stok-info"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Informasi Tanggal</h5>

                                    <div class="form-group">
                                        <label for="tanggal_keluar">Tanggal Keluar <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                                               class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                               value="{{ old('tanggal_keluar', date('Y-m-d')) }}"
                                               max="{{ date('Y-m-d') }}" required>
                                        @error('tanggal_keluar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi/Tujuan <span class="text-danger">*</span></label>
                                        <textarea name="deskripsi" id="deskripsi" rows="4"
                                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                                  placeholder="Contoh: Untuk keperluan ruang rawat inap, dll"
                                                  required>{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body bg-light">
                            <div class="alert alert-info mb-0">
                                <i class="mdi mdi-information"></i>
                                <strong>Perhatian:</strong> Stok obat akan otomatis berkurang sesuai jumlah yang diinput.
                                Pastikan jumlah yang diinput benar.
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="mdi mdi-content-save"></i> Simpan Barang Keluar
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-light btn-block">
                                        <i class="mdi mdi-close"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const obat = document.getElementById('id_obat');
    const jumlah = document.getElementById('jumlah');
    const info = document.getElementById('stok-info');

    obat.addEventListener('change', () => {
        const opt = obat.options[obat.selectedIndex];
        const stok = opt.dataset.stok;
        const satuan = opt.dataset.satuan;

        if (stok) {
            info.textContent = `Stok tersedia: ${stok} ${satuan}`;
            jumlah.max = stok;
        } else {
            info.textContent = '';
            jumlah.removeAttribute('max');
        }
    });
</script>
@endpush
@endsection