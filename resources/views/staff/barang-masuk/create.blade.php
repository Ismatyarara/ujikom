@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="row">
  <div class="col-lg-10 col-xl-8 mx-auto grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-1">Tambah Barang Masuk</h4>
            <p class="text-muted mb-0">Input data barang masuk obat baru</p>
          </div>
          <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-light btn-sm">
            <i class="mdi mdi-arrow-left"></i> Kembali
          </a>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong><i class="mdi mdi-alert"></i> Terdapat kesalahan!</strong>
          <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif

        <form action="{{ route('staff.barang-masuk.store') }}" method="POST" id="formBarangMasuk">
          @csrf
          
          <!-- Info Box -->
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="mdi mdi-information"></i>
            <strong>Informasi:</strong> Stok obat akan otomatis bertambah sesuai jumlah yang diinput setelah data disimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!-- Pilih Obat -->
          <div class="form-group">
            <label for="id_obat">
              <i class="mdi mdi-pill text-primary"></i> Pilih Obat 
              <span class="text-danger">*</span>
            </label>
            <select class="form-control form-control-lg @error('id_obat') is-invalid @enderror" 
                    id="id_obat" 
                    name="id_obat" 
                    required>
              <option value="">-- Pilih Obat --</option>
              @foreach($obat as $item)
                <option value="{{ $item->id }}" 
                        data-stok="{{ $item->stok }}"
                        data-nama="{{ $item->nama_obat }}"
                        data-kode="{{ $item->kode }}"
                        {{ old('id_obat') == $item->id ? 'selected' : '' }}>
                  {{ $item->kode }} - {{ $item->nama_obat }} (Stok: {{ $item->stok }})
                </option>
              @endforeach
            </select>
            @error('id_obat')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
              <i class="mdi mdi-information-outline"></i> Pilih obat yang akan ditambahkan stoknya
            </small>
          </div>

          <!-- Detail Obat Card -->
          <div class="card bg-light mb-3 d-none" id="obatDetail">
            <div class="card-body">
              <h6 class="card-title mb-3">
                <i class="mdi mdi-information-variant"></i> Detail Obat Terpilih
              </h6>
              <div class="row">
                <div class="col-md-6">
                  <p class="mb-2"><strong>Kode Obat:</strong> <span id="detailKode" class="badge badge-secondary">-</span></p>
                  <p class="mb-0"><strong>Nama Obat:</strong> <span id="detailNama">-</span></p>
                </div>
                <div class="col-md-6">
                  <p class="mb-2"><strong>Stok Saat Ini:</strong> <span id="detailStok" class="badge badge-info">-</span></p>
                  <p class="mb-0"><strong>Stok Setelah Input:</strong> <span id="detailStokBaru" class="badge badge-success">-</span></p>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Jumlah -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="jumlah">
                  <i class="mdi mdi-counter text-success"></i> Jumlah 
                  <span class="text-danger">*</span>
                </label>
                <input type="number" 
                       class="form-control form-control-lg @error('jumlah') is-invalid @enderror" 
                       id="jumlah" 
                       name="jumlah" 
                       value="{{ old('jumlah') }}" 
                       min="1" 
                       placeholder="Masukkan jumlah"
                       required>
                @error('jumlah')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                  <i class="mdi mdi-information-outline"></i> Jumlah barang yang masuk
                </small>
              </div>
            </div>

            <!-- Tanggal Masuk -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="tanggal_masuk">
                  <i class="mdi mdi-calendar text-info"></i> Tanggal Masuk 
                  <span class="text-danger">*</span>
                </label>
                <input type="date" 
                       class="form-control form-control-lg @error('tanggal_masuk') is-invalid @enderror" 
                       id="tanggal_masuk" 
                       name="tanggal_masuk" 
                       value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                       max="{{ date('Y-m-d') }}"
                       required>
                @error('tanggal_masuk')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                  <i class="mdi mdi-information-outline"></i> Tanggal barang masuk
                </small>
              </div>
            </div>
          </div>

          <!-- Tanggal Kadaluwarsa -->
          <div class="form-group">
            <label for="tanggal_kadaluwarsa">
              <i class="mdi mdi-calendar-alert text-warning"></i> Tanggal Kadaluwarsa 
              <span class="text-danger">*</span>
            </label>
            <input type="date" 
                   class="form-control form-control-lg @error('tanggal_kadaluwarsa') is-invalid @enderror" 
                   id="tanggal_kadaluwarsa" 
                   name="tanggal_kadaluwarsa" 
                   value="{{ old('tanggal_kadaluwarsa') }}" 
                   required>
            @error('tanggal_kadaluwarsa')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text" id="expiry-info">
              <i class="mdi mdi-information-outline"></i> Tanggal kadaluwarsa obat
            </small>
          </div>

          <!-- Deskripsi -->
          <div class="form-group">
            <label for="deskripsi">
              <i class="mdi mdi-text text-secondary"></i> Deskripsi / Keterangan
            </label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="deskripsi" 
                      name="deskripsi" 
                      rows="4"
                      placeholder="Masukkan catatan atau keterangan tambahan (opsional)">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
              <i class="mdi mdi-information-outline"></i> Opsional - Catatan tambahan seperti supplier, batch number, dll
            </small>
          </div>

          <!-- Action Buttons -->
          <div class="mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="mdi mdi-content-save"></i> Simpan Barang Masuk
            </button>
            <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-light btn-lg">
              <i class="mdi mdi-close"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
.form-control-lg {
  font-size: 1rem;
}

.card-title i {
  font-size: 1.1rem;
}

label i {
  font-size: 1rem;
}

#obatDetail {
  transition: all 0.3s ease;
}

.btn-lg {
  padding: 0.75rem 1.5rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const selectObat = document.getElementById('id_obat');
  const inputJumlah = document.getElementById('jumlah');
  const inputTanggalMasuk = document.getElementById('tanggal_masuk');
  const inputTanggalKadaluwarsa = document.getElementById('tanggal_kadaluwarsa');
  const obatDetail = document.getElementById('obatDetail');
  const expiryInfo = document.getElementById('expiry-info');
  
  // Detail elements
  const detailKode = document.getElementById('detailKode');
  const detailNama = document.getElementById('detailNama');
  const detailStok = document.getElementById('detailStok');
  const detailStokBaru = document.getElementById('detailStokBaru');

  let currentStok = 0;

  // Handle obat selection
  selectObat.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (this.value) {
      currentStok = parseInt(selectedOption.dataset.stok) || 0;
      const namaObat = selectedOption.dataset.nama;
      const kodeObat = selectedOption.dataset.kode;

      // Update detail card
      detailKode.textContent = kodeObat;
      detailNama.textContent = namaObat;
      detailStok.textContent = currentStok + ' unit';

      // Show detail card
      obatDetail.classList.remove('d-none');
      updateStokBaru();
    } else {
      // Hide detail card
      obatDetail.classList.add('d-none');
    }
  });

  // Handle jumlah input
  inputJumlah.addEventListener('input', function() {
    updateStokBaru();
  });

  // Update new stock calculation
  function updateStokBaru() {
    const jumlah = parseInt(inputJumlah.value) || 0;
    const stokBaru = currentStok + jumlah;
    detailStokBaru.textContent = stokBaru + ' unit';
  }

  // Validate tanggal kadaluwarsa
  inputTanggalKadaluwarsa.addEventListener('change', function() {
    const tanggalMasuk = new Date(inputTanggalMasuk.value);
    const tanggalKadaluwarsa = new Date(this.value);
    
    if (tanggalKadaluwarsa <= tanggalMasuk) {
      alert('Tanggal kadaluwarsa harus lebih besar dari tanggal masuk!');
      this.value = '';
      expiryInfo.innerHTML = '<i class="mdi mdi-information-outline"></i> Tanggal kadaluwarsa obat';
      expiryInfo.className = 'form-text text-muted';
      return;
    }

    // Calculate months until expiry
    const diffTime = Math.abs(tanggalKadaluwarsa - new Date());
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    const diffMonths = Math.floor(diffDays / 30);

    if (diffMonths < 6) {
      expiryInfo.innerHTML = '<i class="mdi mdi-alert"></i> Peringatan: Obat akan kadaluwarsa dalam ' + diffMonths + ' bulan';
      expiryInfo.className = 'form-text text-warning';
    } else {
      expiryInfo.innerHTML = '<i class="mdi mdi-check-circle"></i> Masa kadaluwarsa: ' + diffMonths + ' bulan lagi';
      expiryInfo.className = 'form-text text-success';
    }
  });

  // Update min date for kadaluwarsa when tanggal masuk changes
  inputTanggalMasuk.addEventListener('change', function() {
    const tomorrow = new Date(this.value);
    tomorrow.setDate(tomorrow.getDate() + 1);
    inputTanggalKadaluwarsa.min = tomorrow.toISOString().split('T')[0];
  });

  // Form validation
  document.getElementById('formBarangMasuk').addEventListener('submit', function(e) {
    const jumlah = parseInt(inputJumlah.value) || 0;
    
    if (jumlah < 1) {
      e.preventDefault();
      alert('Jumlah minimal adalah 1');
      return false;
    }

    // Confirm before submit
    const namaObat = selectObat.options[selectObat.selectedIndex].dataset.nama;
    const stokBaru = currentStok + jumlah;
    
    if (!confirm(`Konfirmasi penambahan stok:\n\nObat: ${namaObat}\nJumlah: ${jumlah} unit\nStok Lama: ${currentStok}\nStok Baru: ${stokBaru}\n\nLanjutkan?`)) {
      e.preventDefault();
      return false;
    }
  });

  // Trigger change event if there's old value
  if (selectObat.value) {
    selectObat.dispatchEvent(new Event('change'));
  }
});
</script>
@endpush
@endsection