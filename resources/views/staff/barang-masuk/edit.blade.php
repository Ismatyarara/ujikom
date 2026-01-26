@extends('layouts.app')

@section('title', 'Edit Barang Masuk')

@section('content')
<div class="row">
  <div class="col-lg-10 col-xl-8 mx-auto grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="card-title mb-1">Edit Barang Masuk</h4>
            <p class="text-muted mb-0">Ubah data barang masuk obat</p>
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

        <form action="{{ route('staff.barang-masuk.update', $barangMasuk->id) }}" method="POST" id="formBarangMasuk">
          @csrf
          @method('PUT')
          
          <!-- Info Box -->
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert"></i>
            <strong>Perhatian:</strong> Perubahan data akan mempengaruhi stok obat. Pastikan data yang diinput sudah benar.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!-- Kode Transaksi (Read Only) -->
          <div class="form-group">
            <label for="kode">
              <i class="mdi mdi-barcode text-secondary"></i> Kode Transaksi
            </label>
            <input type="text" 
                   class="form-control form-control-lg bg-light" 
                   value="{{ $barangMasuk->kode }}" 
                   readonly>
            <small class="form-text text-muted">
              <i class="mdi mdi-information-outline"></i> Kode transaksi tidak dapat diubah
            </small>
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
                        {{ old('id_obat', $barangMasuk->id_obat) == $item->id ? 'selected' : '' }}>
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
          <div class="card bg-light mb-3" id="obatDetail">
            <div class="card-body">
              <h6 class="card-title mb-3">
                <i class="mdi mdi-information-variant"></i> Detail Obat Terpilih
              </h6>
              <div class="row">
                <div class="col-md-6">
                  <p class="mb-2"><strong>Kode Obat:</strong> <span id="detailKode" class="badge badge-secondary">-</span></p>
                  <p class="mb-2"><strong>Nama Obat:</strong> <span id="detailNama">-</span></p>
                  <p class="mb-0"><strong>Stok Saat Ini:</strong> <span id="detailStok" class="badge badge-info">-</span></p>
                </div>
                <div class="col-md-6">
                  <p class="mb-2"><strong>Jumlah Lama:</strong> <span class="badge badge-secondary">{{ $barangMasuk->jumlah }} unit</span></p>
                  <p class="mb-2"><strong>Jumlah Baru:</strong> <span id="detailJumlahBaru" class="badge badge-primary">-</span></p>
                  <p class="mb-0"><strong>Selisih Stok:</strong> <span id="detailSelisih" class="badge badge-warning">-</span></p>
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
                       value="{{ old('jumlah', $barangMasuk->jumlah) }}" 
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
                       value="{{ old('tanggal_masuk', $barangMasuk->tanggal_masuk) }}" 
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
                   value="{{ old('tanggal_kadaluwarsa', $barangMasuk->tanggal_kadaluwarsa) }}" 
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
                      placeholder="Masukkan catatan atau keterangan tambahan (opsional)">{{ old('deskripsi', $barangMasuk->deskripsi) }}</textarea>
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
              <i class="mdi mdi-content-save"></i> Update Barang Masuk
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
  const expiryInfo = document.getElementById('expiry-info');
  
  // Detail elements
  const detailKode = document.getElementById('detailKode');
  const detailNama = document.getElementById('detailNama');
  const detailStok = document.getElementById('detailStok');
  const detailJumlahBaru = document.getElementById('detailJumlahBaru');
  const detailSelisih = document.getElementById('detailSelisih');

  let currentStok = 0;
  const oldJumlah = {{ $barangMasuk->jumlah }};

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

      updateSelisih();
    }
  });

  // Handle jumlah input
  inputJumlah.addEventListener('input', function() {
    updateSelisih();
  });

  // Update selisih calculation
  function updateSelisih() {
    const jumlahBaru = parseInt(inputJumlah.value) || 0;
    const selisih = jumlahBaru - oldJumlah;
    
    detailJumlahBaru.textContent = jumlahBaru + ' unit';
    
    if (selisih > 0) {
      detailSelisih.className = 'badge badge-success';
      detailSelisih.textContent = '+' + selisih + ' unit';
    } else if (selisih < 0) {
      detailSelisih.className = 'badge badge-danger';
      detailSelisih.textContent = selisih + ' unit';
    } else {
      detailSelisih.className = 'badge badge-secondary';
      detailSelisih.textContent = 'Tidak ada perubahan';
    }
  }

  // Validate tanggal kadaluwarsa
  inputTanggalKadaluwarsa.addEventListener('change', function() {
    const tanggalMasuk = new Date(inputTanggalMasuk.value);
    const tanggalKadaluwarsa = new Date(this.value);
    
    if (tanggalKadaluwarsa <= tanggalMasuk) {
      alert('Tanggal kadaluwarsa harus lebih besar dari tanggal masuk!');
      this.value = '{{ $barangMasuk->tanggal_kadaluwarsa }}';
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
    const selisih = jumlah - oldJumlah;
    
    if (!confirm(`Konfirmasi perubahan:\n\nObat: ${namaObat}\nJumlah Lama: ${oldJumlah} unit\nJumlah Baru: ${jumlah} unit\nSelisih: ${selisih > 0 ? '+' : ''}${selisih} unit\n\nLanjutkan?`)) {
      e.preventDefault();
      return false;
    }
  });

  // Trigger change event on load
  selectObat.dispatchEvent(new Event('change'));
  inputTanggalKadaluwarsa.dispatchEvent(new Event('change'));
});
</script>
@endpush
@endsection