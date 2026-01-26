@extends('layouts.app')

@section('title', 'Tambah Penjualan Obat')

@section('content')
<div class="row">
  <div class="col-lg-10 col-xl-8 mx-auto grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-1">Tambah Penjualan Obat</h4>
            <p class="text-muted mb-0">Input data penjualan obat baru</p>
          </div>
          <a href="{{ route('staff.penjualan.index') }}" class="btn btn-light btn-sm">
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

        <form action="{{ route('staff.penjualan.store') }}" method="POST" id="formPenjualan">
          @csrf
          
          <!-- Info Box -->
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="mdi mdi-information"></i>
            <strong>Informasi:</strong> Pastikan data yang diinput sudah benar sebelum menyimpan. Stok obat akan otomatis berkurang setelah penjualan disimpan.
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
              <option value="">-- Pilih Obat yang Akan Dijual --</option>
              @foreach($obat as $item)
                <option value="{{ $item->id }}" 
                        data-stok="{{ $item->stok }}"
                        data-harga="{{ $item->harga }}"
                        data-nama="{{ $item->nama_obat }}"
                        {{ old('id_obat') == $item->id ? 'selected' : '' }}
                        {{ $item->stok == 0 ? 'disabled' : '' }}>
                  {{ $item->nama_obat }} - Stok: {{ $item->stok }} - Rp {{ number_format($item->harga, 0, ',', '.') }}
                </option>
              @endforeach
            </select>
            @error('id_obat')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
              <i class="mdi mdi-information-outline"></i> Pilih obat dari daftar yang tersedia
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
                  <p class="mb-2"><strong>Nama Obat:</strong> <span id="detailNama">-</span></p>
                  <p class="mb-2"><strong>Harga Satuan:</strong> <span class="text-success" id="detailHarga">-</span></p>
                </div>
                <div class="col-md-6">
                  <p class="mb-2"><strong>Stok Tersedia:</strong> <span id="detailStok" class="badge badge-info">-</span></p>
                  <p class="mb-0"><strong>Total Harga:</strong> <span class="text-primary font-weight-bold" id="detailTotal">Rp 0</span></p>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Jumlah -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="jumlah">
                  <i class="mdi mdi-counter text-warning"></i> Jumlah 
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
                <small class="form-text" id="stok-info">
                  <i class="mdi mdi-package-variant"></i> Stok tersedia: <strong class="text-muted">Pilih obat terlebih dahulu</strong>
                </small>
              </div>
            </div>

            <!-- Tanggal Penjualan -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="tanggal_keluar">
                  <i class="mdi mdi-calendar text-success"></i> Tanggal Penjualan 
                  <span class="text-danger">*</span>
                </label>
                <input type="date" 
                       class="form-control form-control-lg @error('tanggal_keluar') is-invalid @enderror" 
                       id="tanggal_keluar" 
                       name="tanggal_keluar" 
                       value="{{ old('tanggal_keluar', date('Y-m-d')) }}" 
                       max="{{ date('Y-m-d') }}"
                       required>
                @error('tanggal_keluar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                  <i class="mdi mdi-information-outline"></i> Tanggal transaksi penjualan
                </small>
              </div>
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="form-group">
            <label for="deskripsi">
              <i class="mdi mdi-text text-info"></i> Deskripsi / Keterangan
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
              <i class="mdi mdi-information-outline"></i> Opsional - Catatan tambahan untuk penjualan ini
            </small>
          </div>

          <!-- Action Buttons -->
          <div class="mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit">
              <i class="mdi mdi-content-save"></i> Simpan Penjualan
            </button>
            <a href="{{ route('staff.penjualan.index') }}" class="btn btn-light btn-lg">
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
  const stokInfo = document.getElementById('stok-info');
  const obatDetail = document.getElementById('obatDetail');
  const btnSubmit = document.getElementById('btnSubmit');
  
  // Detail elements
  const detailNama = document.getElementById('detailNama');
  const detailHarga = document.getElementById('detailHarga');
  const detailStok = document.getElementById('detailStok');
  const detailTotal = document.getElementById('detailTotal');

  let currentStok = 0;
  let currentHarga = 0;

  // Handle obat selection
  selectObat.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (this.value) {
      currentStok = parseInt(selectedOption.dataset.stok) || 0;
      currentHarga = parseInt(selectedOption.dataset.harga) || 0;
      const namaObat = selectedOption.dataset.nama;

      // Update detail card
      detailNama.textContent = namaObat;
      detailHarga.textContent = 'Rp ' + currentHarga.toLocaleString('id-ID');
      
      // Update stock info
      if (currentStok > 0) {
        detailStok.className = currentStok > 10 ? 'badge badge-success' : 'badge badge-warning';
        detailStok.textContent = currentStok + ' unit';
        stokInfo.innerHTML = `<i class="mdi mdi-package-variant"></i> Stok tersedia: <strong class="text-success">${currentStok} unit</strong>`;
        
        inputJumlah.max = currentStok;
        inputJumlah.disabled = false;
        inputJumlah.value = '';
        btnSubmit.disabled = false;
      } else {
        detailStok.className = 'badge badge-danger';
        detailStok.textContent = 'Habis';
        stokInfo.innerHTML = `<i class="mdi mdi-alert"></i> Stok tersedia: <strong class="text-danger">Habis</strong>`;
        
        inputJumlah.disabled = true;
        inputJumlah.value = '';
        btnSubmit.disabled = true;
      }

      // Show detail card
      obatDetail.classList.remove('d-none');
      updateTotal();
    } else {
      // Hide detail card
      obatDetail.classList.add('d-none');
      stokInfo.innerHTML = `<i class="mdi mdi-package-variant"></i> Stok tersedia: <strong class="text-muted">Pilih obat terlebih dahulu</strong>`;
      inputJumlah.disabled = true;
      inputJumlah.value = '';
      btnSubmit.disabled = false;
    }
  });

  // Handle jumlah input
  inputJumlah.addEventListener('input', function() {
    const jumlah = parseInt(this.value) || 0;
    
    // Validate stock
    if (jumlah > currentStok) {
      this.value = currentStok;
      alert(`Jumlah tidak boleh melebihi stok yang tersedia (${currentStok} unit)`);
    }
    
    if (jumlah < 1 && this.value !== '') {
      this.value = 1;
    }

    updateTotal();
  });

  // Update total calculation
  function updateTotal() {
    const jumlah = parseInt(inputJumlah.value) || 0;
    const total = jumlah * currentHarga;
    detailTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
  }

  // Form validation
  document.getElementById('formPenjualan').addEventListener('submit', function(e) {
    const jumlah = parseInt(inputJumlah.value) || 0;
    
    if (jumlah > currentStok) {
      e.preventDefault();
      alert(`Jumlah tidak boleh melebihi stok yang tersedia (${currentStok} unit)`);
      return false;
    }

    if (jumlah < 1) {
      e.preventDefault();
      alert('Jumlah minimal adalah 1');
      return false;
    }

    // Confirm before submit
    const namaObat = selectObat.options[selectObat.selectedIndex].dataset.nama;
    const total = jumlah * currentHarga;
    
    if (!confirm(`Konfirmasi penjualan:\n\nObat: ${namaObat}\nJumlah: ${jumlah} unit\nTotal: Rp ${total.toLocaleString('id-ID')}\n\nLanjutkan?`)) {
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