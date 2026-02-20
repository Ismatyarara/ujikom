@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.wrap {
    background: #f4f7ff;
    padding: 40px 20px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    max-width: 600px;
    margin: auto;
}
.back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #2563eb;
    text-decoration: none;
    margin-bottom: 20px;
}
.card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,.05);
    overflow: hidden;
    margin-bottom: 14px;
}
.card-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 22px 25px;
    color: #fff;
}
.card-header h2 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 6px;
}
.status-badge {
    display: inline-block;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.aktif { background: #dcfce7; color: #166534; }
.nonaktif { background: #fee2e2; color: #991b1b; }
.card-body { padding: 20px 25px; }
.info-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
}
.info-row:last-child { border-bottom: none; }
.info-row i {
    color: #2563eb;
    width: 16px;
    text-align: center;
}
.info-row .label { color: #64748b; flex: 1; }
.info-row .value { font-weight: 600; color: #1e293b; }
.catatan-box {
    background: #fefce8;
    border-left: 4px solid #facc15;
    border-radius: 8px;
    padding: 14px;
    font-size: 13px;
    color: #713f12;
    line-height: 1.6;
}
.jam-title {
    font-size: 14px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.jam-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.jam-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 1.5px solid #bfdbfe;
    color: #1e40af;
    padding: 7px 14px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
}
.jam-badge i { font-size: 12px; color: #2563eb; }
.empty-jam {
    text-align: center;
    padding: 20px;
    color: #94a3b8;
    font-size: 13px;
}
</style>

<div class="wrap">
    <a href="{{ route('user.jadwal.index') }}" class="back">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Jadwal
    </a>

    {{-- Header --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fa-solid fa-pills"></i> {{ $jadwal->nama_obat }}</h2>
            <span class="status-badge {{ $jadwal->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                {{ ucfirst($jadwal->status) }}
            </span>
        </div>
        <div class="card-body">
            <div class="info-row">
                <i class="fa-solid fa-user-doctor"></i>
                <span class="label">Dokter</span>
                <span class="value">dr. {{ $jadwal->dokter->nama }}</span>
            </div>
            <div class="info-row">
                <i class="fa-solid fa-calendar-day"></i>
                <span class="label">Tanggal Mulai</span>
                <span class="value">{{ $jadwal->tanggal_mulai->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <i class="fa-solid fa-calendar-check"></i>
                <span class="label">Tanggal Selesai</span>
                <span class="value">{{ $jadwal->tanggal_selesai->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Catatan --}}
    @if($jadwal->deskripsi)
    <div class="card">
        <div class="card-body">
            <div class="catatan-box">
                <strong><i class="fa-solid fa-note-sticky"></i> Catatan Dokter:</strong><br>
                {{ $jadwal->deskripsi }}
            </div>
        </div>
    </div>
    @endif

    {{-- Jam Minum --}}
    <div class="card">
        <div class="card-body">
            <div class="jam-title">
                <i class="fa-solid fa-clock"></i> Jadwal Minum Obat
            </div>

            @if($jadwal->waktuObat->count())
            <div class="jam-list">
                @foreach($jadwal->waktuObat->sortBy('waktu') as $w)
                <span class="jam-badge">
                    <i class="fa-solid fa-bell"></i>
                    {{ \Carbon\Carbon::parse($w->waktu)->format('H:i') }}
                </span>
                @endforeach
            </div>
            @else
            <div class="empty-jam">
                <i class="fa-solid fa-clock"></i>
                <p>Belum ada jadwal waktu minum.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection