@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-0">Tambah Barang Keluar</h4>
            <small class="text-muted">Catat pengeluaran stok obat secara manual</small>
          </div>
          <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        <form action="{{ route('staff.barang-keluar.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="id_obat" class="form-label fw-semibold">
              Obat <span class="text-danger">*</span>
            </label>
            <input type="text" id="obat_search" class="form-control mb-2"
                   placeholder="Cari nama obat atau kode obat">
            <select name="id_obat" id="id_obat"
                    class="form-select @error('id_obat') is-invalid @enderror"
                    onchange="updateSelectedObatInfo(this)">
              <option value="">-- Pilih Obat --</option>
              @foreach($obat as $item)
                <option value="{{ $item->id }}"
                  data-stok="{{ $item->stok }}"
                  data-satuan="{{ $item->satuan }}"
                  data-kode="{{ $item->kode_obat }}"
                  data-nama="{{ $item->nama_obat }}"
                  {{ old('id_obat') == $item->id ? 'selected' : '' }}>
                  {{ $item->nama_obat }} ({{ $item->kode_obat }}) - Stok: {{ $item->stok }} {{ $item->satuan }}
                </option>
              @endforeach
            </select>
            @error('id_obat')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Ketik beberapa huruf untuk mempercepat pencarian obat.</div>

            <div id="selected-obat-info" class="alert alert-light border mt-3 d-none">
              <div class="row">
                <div class="col-md-5 mb-2 mb-md-0">
                  <small class="text-muted d-block">Nama Obat</small>
                  <strong id="selected-obat-nama">-</strong>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                  <small class="text-muted d-block">Kode</small>
                  <strong id="selected-obat-kode">-</strong>
                </div>
                <div class="col-md-4">
                  <small class="text-muted d-block">Stok Tersedia</small>
                  <strong id="stok-value">-</strong> <span id="stok-satuan"></span>
                </div>
              </div>
            </div>
          </div>

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

          <div class="mb-4">
            <label for="deskripsi" class="form-label fw-semibold">Keterangan</label>
            <textarea name="deskripsi" id="deskripsi" rows="3"
                      class="form-control @error('deskripsi') is-invalid @enderror"
                      placeholder="Contoh: Rusak, expired, digunakan untuk keperluan...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="alert alert-warning d-flex align-items-center mb-4">
            <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
            <div>Setelah disimpan, stok obat yang dipilih akan <strong>berkurang</strong> secara otomatis.</div>
          </div>

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
@endsection

@push('scripts')
<script>
function updateSelectedObatInfo(select) {
  const option = select.options[select.selectedIndex];
  const infoBox = document.getElementById('selected-obat-info');
  const stokValue = document.getElementById('stok-value');
  const stokSatuan = document.getElementById('stok-satuan');
  const obatNama = document.getElementById('selected-obat-nama');
  const obatKode = document.getElementById('selected-obat-kode');

  if (option && option.value) {
    stokValue.textContent = option.dataset.stok;
    stokSatuan.textContent = option.dataset.satuan;
    obatNama.textContent = option.dataset.nama;
    obatKode.textContent = option.dataset.kode;
    infoBox.classList.remove('d-none');
    infoBox.className = 'alert border mt-3 ' + (parseInt(option.dataset.stok, 10) <= 10 ? 'alert-warning' : 'alert-light');
  } else {
    infoBox.classList.add('d-none');
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('obat_search');
  const select = document.getElementById('id_obat');
  const originalOptions = Array.from(select.options).map((option) => ({
    value: option.value,
    text: option.textContent,
    dataset: { ...option.dataset },
  }));

  function renderOptions(keyword) {
    const normalizedKeyword = keyword.trim().toLowerCase();
    const currentValue = select.value;

    select.innerHTML = '';

    originalOptions.forEach((item, index) => {
      const haystack = `${item.text} ${item.dataset.nama || ''} ${item.dataset.kode || ''}`.toLowerCase();
      if (index !== 0 && normalizedKeyword && !haystack.includes(normalizedKeyword)) {
        return;
      }

      const option = document.createElement('option');
      option.value = item.value;
      option.textContent = item.text;

      Object.entries(item.dataset).forEach(([key, value]) => {
        option.dataset[key] = value;
      });

      if (item.value === currentValue) {
        option.selected = true;
      }

      select.appendChild(option);
    });

    if (!select.querySelector(`option[value="${currentValue}"]`)) {
      select.selectedIndex = 0;
    }

    updateSelectedObatInfo(select);
  }

  searchInput.addEventListener('input', function () {
    renderOptions(this.value);
  });

  renderOptions(searchInput.value);
  updateSelectedObatInfo(select);
});
</script>
@endpush
