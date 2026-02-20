@extends('layouts.app')

@section('content')
<style>
.wrap{
    background:#f4f7ff;
    padding:40px 20px;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.breadcrumb{
    font-size:13px;
    margin-bottom:25px;
}
.breadcrumb a{
    color:#2563eb;
    text-decoration:none;
    font-weight:600;
}
.steps{
    display:flex;
    justify-content:center;
    gap:10px;
    margin-bottom:30px;
}
.step{
    width:35px;
    height:35px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:600;
    background:#e0e7ff;
    color:#2563eb;
}
.step.active{
    background:#2563eb;
    color:#fff;
}
.layout{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}
.card{
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}
.card h3{
    font-size:16px;
    margin-bottom:15px;
    color:#1e3a8a;
}
.info{
    margin-bottom:10px;
}
.info span{
    display:block;
    font-size:12px;
    color:#64748b;
}
.info b{
    font-size:14px;
}
.period{
    margin-top:15px;
    padding:8px 12px;
    background:#e0e7ff;
    color:#1e40af;
    border-radius:6px;
    font-size:13px;
}
.row-time{
    display:flex;
    gap:10px;
    margin-bottom:10px;
}
.row-time input{
    flex:1;
    padding:8px 10px;
    border:1px solid #dbeafe;
    border-radius:6px;
}
.btn-add{
    background:#eff6ff;
    border:1px dashed #2563eb;
    color:#2563eb;
    padding:6px 10px;
    border-radius:6px;
    font-size:13px;
    cursor:pointer;
}
.btn-save{
    width:100%;
    margin-top:15px;
    padding:10px;
    border:none;
    background:#2563eb;
    color:#fff;
    border-radius:8px;
    font-weight:600;
}
.btn-remove{
    background:#fee2e2;
    border:none;
    padding:6px 10px;
    border-radius:6px;
    cursor:pointer;
}
.skip{
    display:block;
    text-align:center;
    margin-top:15px;
    font-size:13px;
    color:#64748b;
    text-decoration:none;
}
@media(max-width:768px){
    .layout{grid-template-columns:1fr;}
}
</style>

<div class="wrap">

    <div class="breadcrumb">
        <a href="{{ route('dokter.dashboard') }}">Dashboard</a> ›
        <a href="{{ route('dokter.jadwal.index') }}">Jadwal</a> ›
        <b>Atur Waktu</b>
    </div>

    <div class="steps">
        <div class="step">1</div>
        <div class="step active">2</div>
    </div>

    <div class="layout">

        <!-- LEFT -->
        <div class="card">
            <h3>Ringkasan Jadwal</h3>

            <div class="info">
                <span>Pasien</span>
                <b>{{ $jadwal->user->name }}</b>
            </div>

            <div class="info">
                <span>Dokter</span>
                <b>{{ $jadwal->dokter->nama }}</b>
            </div>

            <div class="info">
                <span>Nama Obat</span>
                <b>{{ $jadwal->nama_obat }}</b>
            </div>

            @if($jadwal->deskripsi)
            <div class="info">
                <span>Catatan</span>
                <b>{{ $jadwal->deskripsi }}</b>
            </div>
            @endif

            <div class="period">
                {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}
            </div>
        </div>

        <!-- RIGHT -->
        <div class="card">
            <h3>Waktu Minum Obat</h3>

            <form action="{{ route('dokter.jadwal.waktu.store', $jadwal->id) }}" method="POST">
                @csrf

                <div id="time-container">
                    <div class="row-time">
                        <input type="time" name="waktu[]" required>
                        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">x</button>
                    </div>
                </div>

                <button type="button" id="add" class="btn-add">
                    + Tambah Waktu
                </button>

                <button type="submit" class="btn-save">
                    Simpan Waktu
                </button>
            </form>

            <a href="{{ route('dokter.jadwal.index') }}" class="skip">
                Lewati langkah ini
            </a>
        </div>

    </div>
</div>

<script>
document.getElementById('add').onclick = function(){
    const row = document.createElement('div');
    row.className = 'row-time';
    row.innerHTML = `
        <input type="time" name="waktu[]" required>
        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">x</button>
    `;
    document.getElementById('time-container').appendChild(row);
};
</script>
@endsection