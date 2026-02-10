@extends('layouts.app')

@section('title', 'Edit Dokter')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Dokter</h4>
                <small>Perbarui data dokter</small>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.dokter.update', $dokter->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Nama Dokter</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $dokter->nama) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $dokter->pengguna->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Kosongkan jika tidak diubah">
                    </div>

                    <div class="mb-3">
                        <label>Tempat Praktik</label>
                        <input type="text" name="tempat_praktik" class="form-control"
                            value="{{ old('tempat_praktik', $dokter->tempat_praktik) }}" required>
                    </div>

                    {{-- Spesialisasi --}}
                    <div class="form-group mb-3">
                        <label for="spesialisasi_id">Spesialisasi <span class="text-danger">*</span></label>
                        <select class="form-control @error('spesialisasi_id') is-invalid @enderror" id="spesialisasi_id"
                            name="spesialisasi_id" required>
                            <option value="">-- Pilih Spesialisasi --</option>
                            @foreach ($spesialisasi as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('spesialisasi_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('spesialisasi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Foto</label><br>
                        @if ($dokter->foto)
                            <img src="{{ asset('storage/' . $dokter->foto) }}" width="120" class="mb-2">
                        @endif
                        <input type="file" name="foto" class="form-control">
                    </div>

                    @php
                        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        [$h1, $h2] = explode(' - ', $dokter->jadwal_praktik_hari . ' - ');
                        [$w1, $w2] = explode(' - ', $dokter->jadwal_praktik_waktu . ' - ');
                    @endphp

                    <div class="mb-3">
                        <label>Hari Praktik</label>
                        <div class="row">
                            <div class="col">
                                <select id="hari_dari" class="form-control" required>
                                    <option value="">Dari</option>
                                    @foreach ($hari as $h)
                                        <option {{ $h == $h1 ? 'selected' : '' }}>{{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select id="hari_sampai" class="form-control" required>
                                    <option value="">Sampai</option>
                                    @foreach ($hari as $h)
                                        <option {{ $h == $h2 ? 'selected' : '' }}>{{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="jadwal_praktik_hari" id="jadwal_praktik_hari">
                    </div>

                    <div class="mb-3">
                        <label>Waktu Praktik</label>
                        <div class="row">
                            <div class="col">
                                <input type="time" id="waktu_dari" class="form-control" value="{{ $w1 }}"
                                    required>
                            </div>
                            <div class="col">
                                <input type="time" id="waktu_sampai" class="form-control" value="{{ $w2 }}"
                                    required>
                            </div>
                        </div>
                        <input type="hidden" name="jadwal_praktik_waktu" id="jadwal_praktik_waktu">
                    </div>

                    <div class="mb-3">
                        <label>Pengalaman</label>
                        <textarea name="pengalaman" class="form-control" rows="3">{{ old('pengalaman', $dokter->pengalaman) }}</textarea>
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
<script>
const setValue = () => {
    const h1 = hari_dari.value, h2 = hari_sampai.value;
    const w1 = waktu_dari.value, w2 = waktu_sampai.value;

    jadwal_praktik_hari.value  = h1 === h2 ? h1 : `${h1} - ${h2}`;
    jadwal_praktik_waktu.value = `${w1} - ${w2}`;
};

['hari_dari','hari_sampai','waktu_dari','waktu_sampai']
.forEach(id => document.getElementById(id).addEventListener('change', setValue));

setValue();
</script>
@endpush
@endsection
