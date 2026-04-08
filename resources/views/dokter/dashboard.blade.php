@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<style>
    .doctor-wrap {
        background:
            radial-gradient(circle at top right, rgba(13, 110, 253, 0.10), transparent 28%),
            linear-gradient(180deg, #f8fbff 0%, #f5f7fb 100%);
        min-height: 100vh;
        padding: 28px 0 48px;
    }
    .hero-card,
    .metric-card,
    .panel-card {
        background: #fff;
        border: 1px solid #edf1f7;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(17, 24, 39, 0.06);
    }
    .hero-card {
        padding: 24px;
        margin-bottom: 20px;
    }
    .hero-subtitle {
        color: #6b7280;
        margin-bottom: 0;
    }
    .doctor-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #eef4ff;
        color: #2563eb;
        border-radius: 999px;
        padding: 8px 14px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .metric-card {
        padding: 18px 20px;
        height: 100%;
    }
    .metric-label {
        color: #6b7280;
        font-size: 0.82rem;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .metric-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #111827;
        line-height: 1;
        margin-bottom: 8px;
    }
    .metric-note {
        color: #94a3b8;
        font-size: 0.75rem;
        margin-bottom: 0;
    }
    .panel-card {
        padding: 20px;
        height: 100%;
    }
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        gap: 12px;
    }
    .panel-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0;
    }
    .mini-link {
        font-size: 0.8rem;
        font-weight: 600;
        color: #2563eb;
        text-decoration: none;
    }
    .mini-link:hover {
        color: #1d4ed8;
    }
    .doctor-info-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
    }
    .doctor-info-row:last-child {
        border-bottom: none;
    }
    .doctor-info-label {
        color: #6b7280;
    }
    .doctor-info-value {
        color: #111827;
        font-weight: 600;
        text-align: right;
    }
    .list-item {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .list-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .list-title {
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }
    .list-meta {
        color: #6b7280;
        font-size: 0.82rem;
        margin-bottom: 0;
    }
    .empty-copy {
        color: #94a3b8;
        font-size: 0.88rem;
        margin-bottom: 0;
    }
</style>

<div class="doctor-wrap">
    <div class="container-fluid">
        <div class="hero-card">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-2">Dashboard Dokter</h1>
                    <p class="hero-subtitle">Pantau konsultasi, catatan medis, dan jadwal obat dalam satu tempat.</p>
                </div>
                <div class="doctor-badge">
                    <i class="fas fa-user-md"></i>
                    dr. {{ $dokterUser->name }}
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-label">Total Pasien</div>
                    <div class="metric-value">{{ $totalPasien }}</div>
                    <p class="metric-note">Pasien unik yang pernah konsultasi</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-label">Konsultasi Bulan Ini</div>
                    <div class="metric-value">{{ $konsultasiBulanIni }}</div>
                    <p class="metric-note">Jumlah pesan konsultasi selama bulan berjalan</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-label">Konsultasi Hari Ini</div>
                    <div class="metric-value">{{ $konsultasiHariIni }}</div>
                    <p class="metric-note">Aktivitas konsultasi pada hari ini</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-label">Jadwal Aktif</div>
                    <div class="metric-value">{{ $jadwalAktif }}</div>
                    <p class="metric-note">Jadwal obat yang masih berjalan</p>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xl-4">
                <div class="panel-card">
                    <div class="panel-header">
                        <h5 class="panel-title">Profil Dokter</h5>
                    </div>

                    <div class="doctor-info-row">
                        <span class="doctor-info-label">Nama</span>
                        <span class="doctor-info-value">dr. {{ $dokterUser->name }}</span>
                    </div>
                    <div class="doctor-info-row">
                        <span class="doctor-info-label">Email</span>
                        <span class="doctor-info-value">{{ $dokterUser->email }}</span>
                    </div>
                    <div class="doctor-info-row">
                        <span class="doctor-info-label">Spesialisasi</span>
                        <span class="doctor-info-value">{{ optional($dokter?->spesialisasi)->nama ?? '-' }}</span>
                    </div>
                    <div class="doctor-info-row">
                        <span class="doctor-info-label">Catatan Medis Dibuat</span>
                        <span class="doctor-info-value">{{ $catatanMedisDibuat }}</span>
                    </div>
                    <div class="doctor-info-row">
                        <span class="doctor-info-label">Terdaftar Sejak</span>
                        <span class="doctor-info-value">{{ $dokterUser->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="panel-card">
                    <div class="panel-header">
                        <h5 class="panel-title">Jadwal Hari Ini</h5>
                        <a href="{{ route('dokter.jadwal.index') }}" class="mini-link">Lihat semua</a>
                    </div>

                    @forelse($jadwalHariIni as $item)
                        <div class="list-item">
                            <div class="list-title">{{ $item->nama_obat }}</div>
                            <p class="list-meta">
                                Pasien: {{ $item->user->name ?? '-' }}<br>
                                Periode: {{ optional($item->tanggal_mulai)->format('d M Y') }} - {{ optional($item->tanggal_selesai)->format('d M Y') }}
                            </p>
                        </div>
                    @empty
                        <p class="empty-copy">Belum ada jadwal aktif untuk hari ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-xl-4">
                <div class="panel-card">
                    <div class="panel-header">
                        <h5 class="panel-title">Catatan Medis Terbaru</h5>
                        <a href="{{ route('dokter.catatan.index') }}" class="mini-link">Lihat semua</a>
                    </div>

                    @forelse($catatanTerbaru as $item)
                        <div class="list-item">
                            <div class="list-title">{{ $item->user->name ?? 'Pasien' }}</div>
                            <p class="list-meta">
                                {{ \Illuminate\Support\Str::limit($item->diagnosa ?? $item->keluhan, 70) }}<br>
                                {{ optional($item->tanggal_catatan)->format('d M Y H:i') }}
                            </p>
                        </div>
                    @empty
                        <p class="empty-copy">Belum ada catatan medis yang dibuat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
