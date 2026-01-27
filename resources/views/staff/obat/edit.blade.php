@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Data Obat</h4>
        <p class="card-description">Perbarui data obat</p>

        <form action="{{ route('staff.obat.update', $obat->id) }}" 
              method="POST" 
              enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- Nama --}}
          <div class="form-group">
            <label>Nama Obat *</label>
            <input type="text" name="nama_obat"
              class="form-control @error('nama_obat') is-invalid @enderror"
              value="{{ old('nama_obat', $obat->nama_obat) }}" required>
            @error('nama_obat') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Deskripsi --}}
          <div class="form-group">
            <label>Deskripsi *</label>
            <textarea name="deskripsi" rows="3"
              class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $obat->deskripsi) }}</textarea>
            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Aturan Pakai --}}
          <div class="form-group">
            <label>Aturan Pakai *</label>
            <textarea name="aturan_pakai" rows="3"
              class="form-control @error('aturan_pakai') is-invalid @enderror" required>{{ old('aturan_pakai', $obat->aturan_pakai) }}</textarea>
            @error('aturan_pakai') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Efek Samping --}}
          <div class="form-group">
            <label>Efek Samping *</label>
            <textarea name="efek_samping" rows="3"
              class="form-control @error('efek_samping') is-invalid @enderror" required>{{ old('efek_samping', $obat->efek_samping) }}</textarea>
            @error('efek_samping') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row">
            {{-- Stok --}}
            <div class="col-md-4">
              <div class="form-group">
                <label>Stok *</label>
                <input type="number" name="stok" min="0"
                  class="form-control @error('stok') is-invalid @enderror"
                  value="{{ old('stok', $obat->stok) }}" required>
                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Harga --}}
            <div class="col-md-4">
              <div class="form-group">
                <label>Harga *</label>
                <input type="number" name="harga" min="0"
                  class="form-control @error('harga') is-invalid @enderror"
                  value="{{ old('harga', $obat->harga) }}" required>
                @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Satuan --}}
            <div class="col-md-4">
              <div class="form-group">
                <label>Satuan *</label>
                <select name="satuan"
                  class="form-control @error('satuan') is-invalid @enderror" required>
                  <option value="">-- Pilih --</option>
                  @foreach(['Tablet','Kapsul','Sirup','Botol','Strip'] as $item)
                    <option value="{{ $item }}"
                      {{ old('satuan', $obat->satuan) == $item ? 'selected' : '' }}>
                      {{ $item }}
                    </option>
                  @endforeach
                </select>
                @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>

          {{-- Status --}}
          <div class="form-group">
            <label>Status *</label>
            <select name="status"
              class="form-control @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', $obat->status) == 1 ? 'selected' : '' }}>Aktif</option>
              <option value="0" {{ old('status', $obat->status) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Foto --}}
          <div class="form-group">
            <label>Foto Obat</label>

            @if($obat->foto)
              <div class="mb-2">
                <img src="{{ asset('storage/'.$obat->foto) }}" 
                     class="img-thumbnail" width="150">
              </div>
            @endif

            <input type="file" name="foto"
              class="form-control @error('foto') is-invalid @enderror"
              accept="image/*">
            <small class="text-muted">
              Kosongkan jika tidak ingin mengganti foto
            </small>
            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Button --}}
          <button class="btn btn-primary">
            <i class="fas fa-save"></i> Update
          </button>
          <a href="{{ route('staff.obat.index') }}" class="btn btn-light">
            Kembali
          </a>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection