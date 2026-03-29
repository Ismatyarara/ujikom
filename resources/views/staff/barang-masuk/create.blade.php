@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-0">Tambah Barang Masuk</h4>
            <small class="text-muted">Catat penambahan stok obat</small>
          </div>
          <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('staff.barang-masuk.store') }}" method="POST">
          @csrf

          {{-- Pilih Obat --}}
          <div class="mb-3">
            <label for="id_obat" class="form-label fw-semibold">
              Obat <span class="text-danger">*</span>
            </label>
            <select name="id_obat" id="id_obat"
                    class="form-select @error('id_obat') is-invalid @enderror">
              <option value="">-- Pilih Obat --</option>
              @foreach($obat as $item)
                <option value="{{ $item->id }}"
                  {{ old('id_obat') == $item->id ? 'selected' : '' }}>
                  {{ $item->nama_obat }}
                  ({{ $item->kode_obat }})
                  — Stok: {{ $item->stok }} {{ $item->satuan }}
                </option>
              @endforeach
            </select>
            @error('id_obat')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Jumlah --}}
          <div class="mb-3">
            <label for="jumlah" class="form-label fw-semibold">
              Jumlah <span class="text-danger">*</span>
            </label>
            <input type="number" name="jumlah" id="jumlah" min="1"
                   class="form-control @error('jumlah') is-invalid @enderror"
                   value="{{ old('jumlah') }}" placeholder="Masukkan jumlah barang masuk">
            @error('jumlah')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Stok obat akan bertambah sesuai jumlah yang dimasukkan.</div>
          </div>

          {{-- Tanggal Masuk & Kadaluwarsa --}}
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="tanggal_masuk" class="form-label fw-semibold">
                Tanggal Masuk <span class="text-danger">*</span>
              </label>
              <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                     class="form-control @error('tanggal_masuk') is-invalid @enderror"
                     value="{{ old('tanggal_masuk', date('Y-m-d')) }}">
              @error('tanggal_masuk')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="tanggal_kadaluwarsa" class="form-label fw-semibold">
                Tanggal Kadaluwarsa <span class="text-danger">*</span>
              </label>
              <input type="date" name="tanggal_kadaluwarsa" id="tanggal_kadaluwarsa"
                     class="form-control @error('tanggal_kadaluwarsa') is-invalid @enderror"
                     value="{{ old('tanggal_kadaluwarsa') }}">
              @error('tanggal_kadaluwarsa')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Deskripsi --}}
          <div class="mb-4">
            <label for="deskripsi" class="form-label fw-semibold">Keterangan</label>
            <textarea name="deskripsi" id="deskripsi" rows="3"
                      class="form-control @error('deskripsi') is-invalid @enderror"
                      placeholder="Contoh: Pembelian dari supplier ABC...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Info Box --}}
          <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="fas fa-info-circle me-2 fs-5"></i>
            <div>Setelah disimpan, stok obat yang dipilih akan <strong>bertambah</strong> secara otomatis.</div>
          </div>

          {{-- Tombol --}}
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-1"></i> Simpan
            </button>
            <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-light">
              Batal
            </a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection