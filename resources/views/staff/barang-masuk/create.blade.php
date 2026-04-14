@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-0">Tambah Barang Masuk</h4>
            <small class="text-muted">Catat penambahan stok obat</small>
          </div>
          <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        <form action="{{ route('staff.barang-masuk.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="kode_obat_input" class="form-label fw-semibold">
              Kode Obat <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="kode_obat_input"
                   class="form-control @error('id_obat') is-invalid @enderror"
                   list="daftar_kode_obat"
                   placeholder="Ketik kode obat"
                   value="{{ old('kode_obat_input') }}"
                   autocomplete="off"
                   onchange="pilihObatBarangMasuk()">
            <input type="hidden" name="id_obat" id="id_obat" value="{{ old('id_obat') }}">
            <datalist id="daftar_kode_obat">
              @foreach($obat as $item)
                <option value="{{ $item->kode_obat }}">{{ $item->nama_obat }}</option>
              @endforeach
            </datalist>
            @error('id_obat')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text" id="infoObat">
              Pilih obat berdasarkan kode. Nama obat dan stok akan tampil otomatis.
            </div>
          </div>

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

          <div class="mb-4">
            <label for="deskripsi" class="form-label fw-semibold">Keterangan</label>
            <textarea name="deskripsi" id="deskripsi" rows="3"
                      class="form-control @error('deskripsi') is-invalid @enderror"
                      placeholder="Contoh: Pembelian dari supplier ABC...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="fas fa-info-circle me-2 fs-5"></i>
            <div>Setelah disimpan, stok obat yang dipilih akan <strong>bertambah</strong> secara otomatis.</div>
          </div>

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

@push('scripts')
@php
  $daftarObatBarangMasuk = $obat->map(function ($item) {
    return [
      'id' => $item->id,
      'kode' => $item->kode_obat,
      'nama' => $item->nama_obat,
      'stok' => $item->stok,
      'satuan' => $item->satuan,
    ];
  })->values();
@endphp
<script>
  const daftarObatBarangMasuk = @json($daftarObatBarangMasuk);

  function pilihObatBarangMasuk() {
    const inputKode = document.getElementById('kode_obat_input');
    const inputId = document.getElementById('id_obat');
    const infoObat = document.getElementById('infoObat');
    const kode = inputKode.value.trim().toUpperCase();

    inputKode.value = kode;
    inputId.value = '';
    infoObat.textContent = 'Pilih obat berdasarkan kode. Nama obat dan stok akan tampil otomatis.';

    if (kode === '') {
      inputKode.setCustomValidity('');
      return;
    }

    const obatDipilih = daftarObatBarangMasuk.find(function (item) {
      return item.kode === kode;
    });

    if (!obatDipilih) {
      inputKode.setCustomValidity('Kode obat tidak ditemukan.');
      inputKode.reportValidity();
      return;
    }

    inputKode.setCustomValidity('');
    inputId.value = obatDipilih.id;
    infoObat.textContent = obatDipilih.kode + ' - ' + obatDipilih.nama + ' | Stok: ' + obatDipilih.stok + ' ' + obatDipilih.satuan;
  }

  document.addEventListener('DOMContentLoaded', function () {
    pilihObatBarangMasuk();
  });
</script>
@endpush
