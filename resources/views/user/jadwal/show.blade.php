@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.wrap {
    background: #f4f7ff;
    padding: 30px 35px;
    font-family: 'Plus Jakarta Sans', sans-serif;
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
    margin-bottom: 16px;
}
.card-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 25px;
    color: #fff;
}
.card-header h2 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 4px;
}
.card-header p {
    font-size: 13px;
    opacity: .8;
}
.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-top: 10px;
}
.aktif { background: #dcfce7; color: #166534; }
.nonaktif { background: #fee2e2; color: #991b1b; }
.card-body {
    padding: 25px;
}
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
}
.info-row:last-child { border-bottom: none; }
.info-row .label {
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-row .value {
    font-weight: 600;
    color: #1e293b;
    text-align: right;
}
.jam-section h3 {
    font-size: 15px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 15px;
}
.jam-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
}
.jam-card {
    background: #eff6ff;
    border: 2px solid #bfdbfe;
    border-radius: 10px;
    padding: 12px;
    text-align: center;
}
.jam-card i {
    color: #2563eb;
    font-size: 16px;
    margin-bottom: 6px;
    display: block;
}
.jam-card span {
    font-size: 16px;
    font-weight: 700;
    color: #1e3a8a;
}
.catatan-box {
    background: #fefce8;
    border-left: 4px solid #facc15;
    border-radius: 8px;
    padding: 14px;
    font-size: 13px;
    color: #713f12;
}
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

    {{-- Card Header --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fa-solid fa-pills"></i> {{ $jadwal->nama_obat }}</h2>
            <p>Diresepkan oleh dr. {{ $jadwal->dokter->nama }}</p>
            <span class="status-badge {{ $jadwal->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                {{ ucfirst($jadwal->status) }}
            </span>
        </div>

        <div class="card-body">
            <div class="info-row">
                <div class="label"><i class="fa-solid fa-calendar-day"></i> Tanggal Mulai</div>
                <div class="value">{{ $jadwal->tanggal_mulai->format('d M Y') }}</div>
            </div>
            <div class="info-row">
                <div class="label"><i class="fa-solid fa-calendar-check"></i> Tanggal Selesai</div>
                <div class="value">{{ $jadwal->tanggal_selesai->format('d M Y') }}</div>
            </div>
            <div class="info-row">
                <div class="label"><i class="fa-solid fa-user-doctor"></i> Dokter</div>
                <div class="value">dr. {{ $jadwal->dokter->nama }}</div>
            </div>
        </div>
    </div>

    {{-- Catatan --}}
    @if($jadwal->deskripsi)
    <div class="card">
        <div class="card-body">
            <div class="catatan-box">
                <i class="fa-solid fa-note-sticky"></i>
                <strong>Catatan Dokter:</strong><br>
                {{ $jadwal->deskripsi }}
            </div>
        </div>
    </div>
    @endif

    {{-- Jam Minum --}}
    <div class="card">
        <div class="card-body jam-section">
            <h3><i class="fa-solid fa-clock"></i> Jadwal Minum Obat</h3>

            @if($jadwal->waktuObat->count())
            <div class="jam-grid">
                @foreach($jadwal->waktuObat->sortBy('waktu') as $w)
                <div class="jam-card">
                    <i class="fa-solid fa-bell"></i>
                    <span>{{ \Carbon\Carbon::parse($w->waktu)->format('H:i') }}</span>
                </div>
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