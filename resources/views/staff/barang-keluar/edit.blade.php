{{-- ====================== edit.blade.php ====================== --}}
@extends('layouts.app')

@section('title', 'Edit Barang Keluar')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-0">Edit Barang Keluar</h4>
            <small class="text-muted">Kode: <strong>{{ $barangKeluar->kode }}</strong></small>
          </div>
          <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        <div class="alert alert-warning d-flex align-items-center mb-4">
          <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
          <div>
            Mengedit data ini akan <strong>menyesuaikan stok obat secara otomatis</strong>.
            Stok lama akan dikembalikan, lalu stok baru dikurangi.
          </div>
        </div>

        <form action="{{ route('staff.barang-keluar.update', $barangKeluar->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="id_obat" class="form-label fw-semibold">
              Obat <span class="text-danger">*</span>
            </label>
            <select name="id_obat" id="id_obat"
                    class="form-select @error('id_obat') is-invalid @enderror">
              <option value="">-- Pilih Obat --</option>
              @foreach($obat as $item)
                <option value="{{ $item->id }}"
                  data-stok="{{ $item->stok }}"
                  data-satuan="{{ $item->satuan }}"
                  {{ old('id_obat', $barangKeluar->id_obat) == $item->id ? 'selected' : '' }}>
                  {{ $item->nama_obat }} ({{ $item->kode_obat }}) — Stok: {{ $item->stok }} {{ $item->satuan }}
                </option>
              @endforeach
            </select>
            @error('id_obat')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="jumlah" class="form-label fw-semibold">
              Jumlah <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input type="number" name="jumlah" id="jumlah" min="1"
                     class="form-control @error('jumlah') is-invalid @enderror"
                     value="{{ old('jumlah', $barangKeluar->jumlah) }}">
              <span class="input-group-text">{{ $barangKeluar->obat->satuan ?? 'pcs' }}</span>
              @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-text">Jumlah sebelumnya: <strong>{{ $barangKeluar->jumlah }}</strong></div>
          </div>

          <div class="mb-3">
            <label for="tanggal_keluar" class="form-label fw-semibold">
              Tanggal Keluar <span class="text-danger">*</span>
            </label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                   class="form-control @error('tanggal_keluar') is-invalid @enderror"
                   value="{{ old('tanggal_keluar', $barangKeluar->tanggal_keluar->format('Y-m-d')) }}">
            @error('tanggal_keluar')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="deskripsi" class="form-label fw-semibold">Keterangan</label>
            <textarea name="deskripsi" id="deskripsi" rows="3"
                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $barangKeluar->deskripsi) }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">
              <i class="fas fa-save me-1"></i> Update
            </button>
            <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-light">Batal</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection