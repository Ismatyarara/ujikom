@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Tambah Obat</h4>

        <form action="{{ route('admin.obat.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label>Nama Obat *</label>
            <input type="text" name="nama_obat" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Deskripsi *</label>
            <textarea name="deskripsi" class="form-control" rows="2" required></textarea>
          </div>

          <div class="form-group">
            <label>Aturan Pakai *</label>
            <textarea name="aturan_pakai" class="form-control" rows="2" required></textarea>
          </div>

          <div class="form-group">
            <label>Efek Samping *</label>
            <textarea name="efek_samping" class="form-control" rows="2" required></textarea>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Stok *</label>
                <input type="number" name="stok" class="form-control" min="0" required>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Harga *</label>
                <input type="number" name="harga" class="form-control" min="0" required>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Satuan *</label>
                <select name="satuan" class="form-control" required>
                  <option value="tablet">Tablet</option>
                  <option value="kapsul">Kapsul</option>
                  <option value="botol">Botol</option>
                  <option value="strip">Strip</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Status *</label>
                <select name="status" class="form-control" required>
                  <option value="1">Aktif</option>
                  <option value="0">Nonaktif</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="{{ route('admin.obat.index') }}" class="btn btn-light">Kembali</a>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
