@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Tambah Jadwal Obat</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.jadwal.store') }}" method="POST">
        @csrf

        <!-- Pilih Pasien -->
        <div class="mb-3">
            <label class="form-label">Pasien *</label>
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

        <!-- Pilih Dokter -->
        <div class="mb-3">
            <label class="form-label">Dokter *</label>
            <select name="dokter_id" class="form-control @error('dokter_id') is-invalid @enderror" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                        {{ $dokter->nama }}
                    </option>
                @endforeach
            </select>
            @error('dokter_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pilih Obat -->
        <div class="mb-3">
            <label class="form-label">Nama Obat *</label>
            <select id="obatSelect" class="form-control @error('nama_obat') is-invalid @enderror" required>
                <option value="">-- Pilih Obat --</option>
                @foreach($obats as $obat)
                    <option 
                        value="{{ $obat->nama_obat }}"
                        data-efek="{{ $obat->efek_samping }}"
                        data-aturan="{{ $obat->aturan_pakai }}"
                        data-deskripsi="{{ $obat->deskripsi }}"
                        {{ old('nama_obat') == $obat->nama_obat ? 'selected' : '' }}>
                        {{ $obat->nama_obat }}
                    </option>
                @endforeach
            </select>

            <!-- Hidden input supaya tetap dikirim ke server -->
            <input type="hidden" name="nama_obat" id="nama_obat">
            @error('nama_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Aturan Pakai -->
        <div class="mb-3">
            <label class="form-label">Aturan Pakai *</label>
            <input type="text" name="aturan_pakai" id="aturan_pakai" class="form-control @error('aturan_pakai') is-invalid @enderror" 
                   value="{{ old('aturan_pakai') }}" required>
            @error('aturan_pakai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Efek Samping -->
        <div class="mb-3">
            <label class="form-label">Efek Samping</label>
            <input type="text" name="efek_samping" id="efek_samping" class="form-control @error('efek_samping') is-invalid @enderror" 
                   value="{{ old('efek_samping') }}">
            @error('efek_samping')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                      rows="3">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tanggal Mulai & Selesai -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tanggal Mulai *</label>
                    <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                           value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tanggal Selesai *</label>
                    <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                           value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan & Atur Jam</button>
            <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

    </form>
</div>

<!-- SCRIPT AUTO FILL -->
<script>
document.getElementById('obatSelect').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];

    document.getElementById('nama_obat').value = selected.value;
    document.getElementById('efek_samping').value = selected.dataset.efek || '';
    document.getElementById('aturan_pakai').value = selected.dataset.aturan || '';
    document.getElementById('deskripsi').value = selected.dataset.deskripsi || '';
});
</script>

@endsection
