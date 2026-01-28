@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tambah Barang Masuk</h4>
            <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-light btn-sm">
                Kembali
            </a>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('staff.barang-masuk.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label>Obat</label>
                    <select name="id_obat" class="form-control" required>
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($obat as $item)
                            <option value="{{ $item->id }}"
                                {{ old('id_obat') == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_obat }} - {{ $item->nama_obat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Jumlah Masuk</label>
                    <input type="number" name="jumlah" class="form-control"
                           value="{{ old('jumlah') }}" min="1" required>
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control"
                           value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal Kadaluwarsa</label>
                    <input type="date" name="tanggal_kadaluwarsa" class="form-control"
                           value="{{ old('tanggal_kadaluwarsa') }}" required>
                </div>

                <div class="form-group mb-4">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">
{{ old('deskripsi') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
