@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Tambah Catatan Medis</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokter.catatan.store') }}" method="POST">
                        @csrf

                        <!-- Pilih Pasien -->
                        <div class="mb-3">
                            <label class="form-label">Pasien <span class="text-danger">*</span></label>   
                            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pasien as $p)
                                    <option value="{{ $p->id }}" {{ old('user_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-3">
                            <label class="form-label">Keluhan <span class="text-danger">*</span></label>
                            <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3" required>{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Diagnosa -->
                        <div class="mb-3">
                            <label class="form-label">Diagnosa <span class="text-danger">*</span></label>
                            <select name="diagnosa" class="form-control @error('diagnosa') is-invalid @enderror" required>
                                <option value="">-- Pilih Diagnosa --</option>
                                <option value="Ringan" {{ old('diagnosa') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                                <option value="Sedang" {{ old('diagnosa') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Berat" {{ old('diagnosa') == 'Berat' ? 'selected' : '' }}>Berat</option>
                            </select>
                            @error('diagnosa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi / Catatan Tambahan</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Catatan <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="tanggal_catatan" class="form-control @error('tanggal_catatan') is-invalid @enderror" value="{{ old('tanggal_catatan', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('tanggal_catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('dokter.catatan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection