@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Penjualan</h1>
            <small class="text-muted">Koreksi data penjualan jika ada kesalahan</small>
        </div>
        <a href="{{ route('staff.penjualan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-edit me-1"></i> Edit Data —
                        <span class="badge bg-dark">{{ $penjualan->kode }}</span>
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.penjualan.update', $penjualan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Obat (readonly, tidak bisa ubah obat) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Obat</label>
                            <input type="text"
                                   class="form-control bg-light"
                                   value="{{ $penjualan->obat->nama_obat ?? '-' }}"
                                   readonly>
                            <small class="text-muted">Obat tidak dapat diubah. Hapus & buat ulang jika perlu.</small>
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-3">
                            <label for="jumlah" class="form-label fw-semibold">
                                Jumlah <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       id="jumlah"
                                       name="jumlah"
                                       class="form-control @error('jumlah') is-invalid @enderror"
                                       value="{{ old('jumlah', $penjualan->jumlah) }}"
                                       min="1"
                                       required>
                                <span class="input-group-text">{{ $penjualan->obat->satuan ?? 'pcs' }}</span>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                Stok saat ini: <strong>{{ $penjualan->obat->stok ?? 0 }}</strong>
                                (belum termasuk jumlah ini)
                            </small>
                        </div>

                        {{-- Tanggal Keluar --}}
                        <div class="mb-3">
                            <label for="tanggal_keluar" class="form-label fw-semibold">
                                Tanggal Keluar <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   id="tanggal_keluar"
                                   name="tanggal_keluar"
                                   class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                   value="{{ old('tanggal_keluar', \Carbon\Carbon::parse($penjualan->tanggal_keluar)->format('Y-m-d')) }}"
                                   required>
                            @error('tanggal_keluar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3">{{ old('deskripsi', $penjualan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('staff.penjualan.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection