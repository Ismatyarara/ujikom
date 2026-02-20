@extends('layouts.app')

@section('content')
<style>
.wrap{
    background:#f4f7fb;
    padding:40px 20px;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.container-edit{
    max-width:1000px;
    margin:auto;
    display:grid;
    grid-template-columns:1.2fr 1fr;
    gap:20px;
}
.card{
    background:#fff;
    border-radius:14px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}
.card h3{
    font-size:16px;
    margin-bottom:20px;
    color:#1e3a8a;
}
.form-group{
    margin-bottom:15px;
}
label{
    font-size:13px;
    font-weight:600;
    display:block;
    margin-bottom:6px;
}
input, select, textarea{
    width:100%;
    padding:9px 12px;
    border:1px solid #dbeafe;
    border-radius:8px;
    font-size:14px;
}
input:focus, select:focus, textarea:focus{
    outline:none;
    border-color:#2563eb;
}
.btn-primary{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:10px 16px;
    border-radius:8px;
    cursor:pointer;
}
.btn-secondary{
    background:#f1f5f9;
    border:none;
    padding:10px 16px;
    border-radius:8px;
    text-decoration:none;
    color:#334155;
}
.time-box{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:8px 12px;
    background:#eff6ff;
    border-radius:8px;
    margin-bottom:8px;
    font-size:14px;
}
.time-box form{
    margin:0;
}
.btn-delete{
    background:none;
    border:none;
    color:#dc2626;
    cursor:pointer;
    font-size:13px;
}
@media(max-width:768px){
    .container-edit{
        grid-template-columns:1fr;
    }
}
</style>

<div class="wrap">
<div class="container-edit">

    <!-- LEFT -->
    <div class="card">
        <h3>Edit Jadwal Obat</h3>

        <form action="{{ route('dokter.jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Pasien</label>
                <select name="user_id" required>
                    @foreach($pasien as $p)
                    <option value="{{ $p->id }}"
                        {{ $jadwal->user_id == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Dokter</label>
                <select name="dokter_id" required>
                    @foreach($dokters as $d)
                    <option value="{{ $d->id }}"
                        {{ $jadwal->dokter_id == $d->id ? 'selected' : '' }}>
                        {{ $d->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Obat</label>
                <select name="nama_obat" required>
                    @foreach($obats as $o)
                    <option value="{{ $o->nama_obat }}"
                        {{ $jadwal->nama_obat == $o->nama_obat ? 'selected' : '' }}>
                        {{ $o->nama_obat }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai"
                       value="{{ $jadwal->tanggal_mulai }}" required>
            </div>

            <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai"
                       value="{{ $jadwal->tanggal_selesai }}" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3">{{ $jadwal->deskripsi }}</textarea>
            </div>

            <div style="display:flex;justify-content:space-between;margin-top:20px;">
                <a href="{{ route('dokter.jadwal.index') }}" class="btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- RIGHT -->
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
            <div class="form-group">
                <label>Tambah Waktu</label>
                <input type="time" name="waktu[]" required>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;">
                Simpan Waktu
            </button>
        </form>
    </div>

</div>
</div>
@endsection