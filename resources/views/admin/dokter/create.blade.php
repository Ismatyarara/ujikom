@extends('layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Data Dokter</h4>
                        <p class="card-subtitle">Lengkapi form di bawah ini</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.dokter.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama --}}
                            <div class="form-group mb-3">
                                <label for="nama">Nama Dokter <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}"
                                    placeholder="Masukkan nama dokter" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group mb-3">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tempat Praktik --}}
                            <div class="form-group mb-3">
                                <label for="tempat_praktik">Tempat Praktik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tempat_praktik') is-invalid @enderror"
                                    id="tempat_praktik" name="tempat_praktik" value="{{ old('tempat_praktik') }}"
                                    placeholder="Masukkan tempat praktik" required>
                                @error('tempat_praktik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Spesialisasi --}}
                            <div class="form-group mb-3">
                                <label for="id_spesialisasi">Spesialisasi <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_spesialisasi') is-invalid @enderror"
                                    id="id_spesialisasi" name="id_spesialisasi" required>
                                    <option value="">-- Pilih Spesialisasi --</option>
                                    @foreach ($spesialisasi as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('id_spesialisasi') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_spesialisasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <td>
                                @if ($dokter->foto)
                                    <img src="{{ Storage::url($dokter->foto) }}" alt="{{ $dokter->nama }}"
                                        class="img-thumbnail" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 80px;">
                                        <i class="fas fa-user fa-2x"></i>
                                    </div>
                                @endif
                            </td>

                            {{-- Jadwal Praktik Hari --}}
                            <div class="form-group mb-3">
                                <label for="jadwal_praktik_hari">Jadwal Praktik (Hari) <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error('jadwal_praktik_hari') is-invalid @enderror"
                                    id="jadwal_praktik_hari" name="jadwal_praktik_hari"
                                    value="{{ old('jadwal_praktik_hari') }}" placeholder="Contoh: Senin - Jumat" required>
                                @error('jadwal_praktik_hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jadwal Praktik Waktu - TEXT INPUT --}}
                            <div class="form-group mb-3">
                                <label for="jadwal_praktik_waktu">Jadwal Praktik (Waktu) <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error('jadwal_praktik_waktu') is-invalid @enderror"
                                    id="jadwal_praktik_waktu" name="jadwal_praktik_waktu"
                                    value="{{ old('jadwal_praktik_waktu') }}" placeholder="Contoh: 08:00 - 16:00" required>
                                <small class="form-text text-muted">Format: HH:MM - HH:MM (Contoh: 08:00 - 16:00)</small>
                                @error('jadwal_praktik_waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
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
