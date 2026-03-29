@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-0">Tambah Barang Keluar</h4>
            <small class="text-muted">Catat pengeluaran stok obat secara manual</small>
          </div>
          <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('staff.barang-keluar.store') }}" method="POST">
          @csrf

          {{-- Pilih Obat --}}
          <div class="mb-3">
            <label for="id_obat" class="form-label fw-semibold">
              Obat <span class="text-danger">*</span>
            </label>
            <select name="id_obat" id="id_obat"
                    class="form-select @error('id_obat') is-invalid @enderror"
                    onchange="updateStokInfo(this)">
              <option value="">-- Pilih Obat --</option>
              @foreach($obat as $item)
                <option value="{{ $item->id }}"
                  data-stok="{{ $item->stok }}"
                  data-satuan="{{ $item->satuan }}"
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
            {{-- Info stok --}}
            <div id="stok-info" class="form-text d-none">
              Stok tersedia: <strong id="stok-value"></strong> <span id="stok-satuan"></span>
            </div>
          </div>

          {{-- Jumlah --}}
          <div class="mb-3">
            <label for="jumlah" class="form-label fw-semibold">
              Jumlah <span class="text-danger">*</span>
            </label>
            <input type="number" name="jumlah" id="jumlah" min="1"
                   class="form-control @error('jumlah') is-invalid @enderror"
                   value="{{ old('jumlah') }}" placeholder="Masukkan jumlah barang keluar">
            @error('jumlah')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Stok obat akan berkurang sesuai jumlah yang dimasukkan.</div>
          </div>

          {{-- Tanggal Keluar --}}
          <div class="mb-3">
            <label for="tanggal_keluar" class="form-label fw-semibold">
              Tanggal Keluar <span class="text-danger">*</span>
            </label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                   class="form-control @error('tanggal_keluar') is-invalid @enderror"
                   value="{{ old('tanggal_keluar', date('Y-m-d')) }}">
            @error('tanggal_keluar')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Deskripsi --}}
          <div class="mb-4">
            <label for="deskripsi" class="form-label fw-semibold">Keterangan</label>
            <textarea name="deskripsi" id="deskripsi" rows="3"
                      class="form-control @error('deskripsi') is-invalid @enderror"
                      placeholder="Contoh: Rusak, expired, digunakan untuk keperluan...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Info Box --}}
          <div class="alert alert-warning d-flex align-items-center mb-4">
            <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
            <div>Setelah disimpan, stok obat yang dipilih akan <strong>berkurang</strong> secara otomatis.</div>
          </div>

          {{-- Tombol --}}
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-save me-1"></i> Simpan
            </button>
            <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-light">
              Batal
            </a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
function updateStokInfo(select) {
  const option = select.options[select.selectedIndex];
  const stokInfo = document.getElementById('stok-info');
  const stokValue = document.getElementById('stok-value');
  const stokSatuan = document.getElementById('stok-satuan');

  if (option.value) {
    stokValue.textContent = option.dataset.stok;
    stokSatuan.textContent = option.dataset.satuan;
    stokInfo.classList.remove('d-none');

    // Warning jika stok rendah
    stokInfo.className = 'form-text ' + (parseInt(option.dataset.stok) <= 10 ? 'text-danger' : 'text-success');
  } else {
    stokInfo.classList.add('d-none');
  }
}
</script>
@endsection