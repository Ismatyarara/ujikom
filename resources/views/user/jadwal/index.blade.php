@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.wrap {
    background: #f4f7ff;
    padding: 40px 20px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.top {
    margin-bottom: 25px;
}
.top h2 {
    font-size: 20px;
    color: #1e3a8a;
    font-weight: 700;
}
.top p {
    font-size: 13px;
    color: #64748b;
    margin-top: 4px;
}
.account-note {
    margin-top: 10px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #eff6ff;
    color: #1d4ed8;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
}
.card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,.05);
    border-left: 4px solid #2563eb;
    transition: transform .2s;
}
.card:hover { transform: translateY(-2px); }
.card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}
.nama-obat {
    font-size: 16px;
    font-weight: 700;
    color: #1e3a8a;
}
.status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.aktif { background: #dcfce7; color: #166534; }
.nonaktif { background: #fee2e2; color: #991b1b; }
.dokter {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 10px;
}
.periode {
    font-size: 12px;
    background: #eff6ff;
    color: #2563eb;
    padding: 6px 10px;
    border-radius: 6px;
    margin-bottom: 12px;
}
.jam-title {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
}
.jam-list {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 15px;
}
.jam-badge {
    background: #e0e7ff;
    color: #3730a3;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.btn-detail {
    display: block;
    text-align: center;
    padding: 8px;
    background: #2563eb;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}
.btn-detail:hover { background: #1d4ed8; color: #fff; }
.empty {
    text-align: center;
    padding: 60px 20px;
    color: #64748b;
    background: #fff;
    border-radius: 14px;
}
.empty i { font-size: 40px; color: #dbeafe; margin-bottom: 10px; display: block; }
.empty small {
    display: block;
    margin-top: 8px;
    color: #94a3b8;
}
</style>

<div class="wrap">
    <div class="top">
        <h2>Jadwal Obat Saya</h2>
        <p>Daftar jadwal konsumsi obat yang diberikan dokter</p>
        <div class="account-note">
            <i class="fa-solid fa-user"></i>
            Akun aktif: {{ $currentUser->name }} ({{ $currentUser->email }})
        </div>
    </div>

    @if($jadwals->count())
    <div class="grid">
        @foreach($jadwals as $jadwal)
        <div class="card">
            <div class="card-top">
                <div class="nama-obat">{{ $jadwal->nama_obat }}</div>
                <span class="status {{ $jadwal->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                    {{ ucfirst($jadwal->status) }}
                </span>
            </div>

            <div class="dokter">
                <i class="fa-solid fa-user-doctor"></i>
                dr. {{ $jadwal->dokter->nama }}
            </div>

            <div class="periode">
                <i class="fa-solid fa-calendar-days"></i>
                {{ $jadwal->tanggal_mulai->format('d M Y') }}
                —
                {{ $jadwal->tanggal_selesai->format('d M Y') }}
            </div>

            @if($jadwal->waktuObat->count())
            <div class="jam-title"><i class="fa-solid fa-clock"></i> Jadwal Minum</div>
            <div class="jam-list">
                @foreach($jadwal->waktuObat as $w)
                <span class="jam-badge">
                    {{ \Carbon\Carbon::parse($w->waktu)->format('H:i') }}
                </span>
                @endforeach
            </div>
            @endif

            <a href="{{ route('user.jadwal.show', $jadwal->id) }}" class="btn-detail">
                Lihat Detail
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty">
        <i class="fa-solid fa-pills"></i>
        <p>Belum ada jadwal obat dari dokter.</p>
        <small>Pastikan jadwal dibuat untuk akun yang sedang login ini.</small>
    </div>
    @endif
</div>
@endsection
