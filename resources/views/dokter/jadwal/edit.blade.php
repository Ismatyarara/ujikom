@extends('layouts.app')

@section('content')
<style>
.wrap{background:#f4f7fb;padding:40px 20px;font-family:'Plus Jakarta Sans',sans-serif;}
.container-edit{max-width:1000px;margin:auto;display:grid;grid-template-columns:1.2fr 1fr;gap:20px;}
.card{background:#fff;border-radius:14px;padding:25px;box-shadow:0 5px 15px rgba(0,0,0,.05);}
.card h3{font-size:16px;margin-bottom:20px;color:#1e3a8a;}
.form-group{margin-bottom:15px;}
.static-field{width:100%;padding:10px 12px;border:1px solid #dbeafe;border-radius:8px;font-size:14px;background:#f8fbff;color:#334155;}
label{font-size:13px;font-weight:600;display:block;margin-bottom:6px;}
input, textarea{width:100%;padding:9px 12px;border:1px solid #dbeafe;border-radius:8px;font-size:14px;}
input:focus, textarea:focus{outline:none;border-color:#2563eb;}
.btn-primary{background:#2563eb;color:#fff;border:none;padding:10px 16px;border-radius:8px;cursor:pointer;}
.btn-secondary{background:#f1f5f9;border:none;padding:10px 16px;border-radius:8px;text-decoration:none;color:#334155;}
.time-box{display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:#eff6ff;border-radius:8px;margin-bottom:8px;font-size:14px;}
.time-box form{margin:0;}
.btn-delete{background:none;border:none;color:#dc2626;cursor:pointer;font-size:13px;}
@media(max-width:768px){.container-edit{grid-template-columns:1fr;}}
</style>

@php
    $selectedObat = $obats->firstWhere('nama_obat', $jadwal->nama_obat);
@endphp

<div class="wrap">
<div class="container-edit">
    <div class="card">
        <h3>Edit Jadwal Obat</h3>

        <form action="{{ route('dokter.jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Pasien</label>
                <div class="static-field">{{ $jadwal->user->name ?? '-' }}</div>
            </div>

            <div class="form-group">
                <label>Dokter</label>
                <div class="static-field">{{ $jadwal->dokter->nama ?? '-' }}</div>
            </div>

            <div class="form-group">
                <label>Cari Obat</label>
                <input type="text" list="obatOptions" id="obat_display" value="{{ $selectedObat ? $selectedObat->kode_obat . ' - ' . $selectedObat->nama_obat : $jadwal->nama_obat }}" onchange="syncEditObatCode()" required>
                <input type="hidden" name="obat_kode" id="obat_kode" value="{{ $selectedObat?->kode_obat }}">
                <datalist id="obatOptions">
                    @foreach($obats as $o)
                        <option value="{{ $o->kode_obat }} - {{ $o->nama_obat }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ optional($jadwal->tanggal_mulai)->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ optional($jadwal->tanggal_selesai)->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3">{{ $jadwal->deskripsi }}</textarea>
            </div>

            <div style="display:flex;justify-content:space-between;margin-top:20px;gap:10px;flex-wrap:wrap;">
                <a href="{{ route('dokter.jadwal.index') }}" class="btn-secondary">Kembali</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3>Waktu Minum Obat</h3>

        @if($jadwal->waktuObat->count())
            @foreach($jadwal->waktuObat as $w)
            <div class="time-box">
                <span>{{ \Carbon\Carbon::parse($w->waktu)->format('H:i') }}</span>
                <form action="{{ route('dokter.jadwal.waktu.destroy',$w->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete">Hapus</button>
                </form>
            </div>
            @endforeach
        @else
            <p style="font-size:13px;color:#64748b;">Belum ada waktu terdaftar</p>
        @endif

        <hr style="margin:15px 0;">

        <form action="{{ route('dokter.jadwal.waktu.store',$jadwal->id) }}" method="POST">
            @csrf
            <input type="hidden" name="from" value="edit">
            <div class="form-group">
                <label>Tambah Waktu</label>
                <input type="time" name="waktu[]" required>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;">Simpan Waktu</button>
        </form>
    </div>
</div>
</div>

<script>
function syncEditObatCode() {
    const value = document.getElementById('obat_display').value || '';
    document.getElementById('obat_kode').value = value.split(' - ')[0].trim();
}
</script>
@endsection
