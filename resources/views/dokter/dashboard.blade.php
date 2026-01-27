@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Selamat Datang,  {{ Auth::user()->name }}</h3>
                <h6 class="font-weight-normal mb-0">
                    Hari ini adalah {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                </h6>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="mdi mdi-calendar"></i> Hari Ini
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                            <a class="dropdown-item" href="#">Januari</a>
                            <a class="dropdown-item" href="#">Februari</a>
                            <a class="dropdown-item" href="#">Maret</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Statistik Cards -->
<div class="row">
    <div class="col-md-6 col-xl-3 grid-margin stretch-card">
        <div class="card tale-bg">
            <div class="card-people mt-auto">
                <img src="{{ asset('assets/images/dashboard/people.svg') }}" alt="people">
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Total Pasien</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="icon-eye mr-2"></i>
                                <span>Lihat Detail</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{ $stats['total_pasien'] }}</h3>
                        <div class="d-flex align-items-baseline">
                            <p class="text-success">
                                <span>Pasien Aktif</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="patients-chart" class="mt-md-3 mt-xl-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Konsultasi Hari Ini</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('dokter.konsultasi.index') }}">
                                <i class="icon-eye mr-2"></i>
                                <span>Lihat Semua</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{ $stats['konsultasi_hari_ini'] }}</h3>
                        <div class="d-flex align-items-baseline">
                            <p class="text-info">
                                <span>Konsultasi</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="consultations-chart" class="mt-md-3 mt-xl-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Antrian Menunggu</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="icon-eye mr-2"></i>
                                <span>Lihat Antrian</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{ $stats['konsultasi_menunggu'] }}</h3>
                        <div class="d-flex align-items-baseline">
                            <p class="text-warning">
                                <span>Pasien</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="queue-chart" class="mt-md-3 mt-xl-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal Hari Ini & Konsultasi Terbaru -->
<div class="row">
    <!-- Jadwal Hari Ini -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Jadwal Praktik Hari Ini</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('dokter.jadwal.index') }}">
                                <i class="icon-calendar mr-2"></i>
                                <span>Lihat Semua Jadwal</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">Waktu</th>
                                <th class="pt-0">Pasien</th>
                                <th class="pt-0">Status</th>
                                <th class="pt-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwalHariIni as $jadwal)
                            <tr>
                                <td>{{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</td>
                                <td>{{ $jadwal->pasien->name }}</td>
                                <td>
                                    @if($jadwal->status == 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($jadwal->status == 'sedang_berjalan')
                                        <span class="badge badge-info">Sedang Berjalan</span>
                                    @else
                                        <span class="badge badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="icon-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="icon-calendar icon-lg mb-2"></i>
                                    <p>Tidak ada jadwal hari ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Konsultasi Terbaru -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Konsultasi Terbaru</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('dokter.konsultasi.index') }}">
                                <i class="icon-paper mr-2"></i>
                                <span>Lihat Semua</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex flex-column">
                    @forelse($konsultasiTerbaru as $konsultasi)
                    <a href="#" class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <img class="img-sm rounded-circle" src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile">
                        <div class="ml-3">
                            <h6 class="mb-1">{{ $konsultasi->pasien->name }}</h6>
                            <p class="mb-0 text-muted text-small">{{ $konsultasi->keluhan }}</p>
                            <small class="text-muted">{{ $konsultasi->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="ml-auto">
                            @if($konsultasi->status == 'selesai')
                                <span class="badge badge-success">Selesai</span>
                            @elseif($konsultasi->status == 'proses')
                                <span class="badge badge-info">Proses</span>
                            @else
                                <span class="badge badge-warning">Menunggu</span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="icon-paper icon-lg mb-2"></i>
                        <p>Belum ada konsultasi</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aktivitas Terbaru & Quick Actions -->
<div class="row">
    <!-- Aktivitas Terbaru -->
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Aktivitas Terbaru</h6>
                <div class="timeline">
                    @forelse($aktivitasTerbaru as $aktivitas)
                    <div class="timeline-item">
                        <div class="timeline-badge {{ $aktivitas->type == 'konsultasi' ? 'bg-info' : 'bg-success' }}">
                            <i class="icon-{{ $aktivitas->icon }}"></i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h6 class="timeline-title">{{ $aktivitas->judul }}</h6>
                                <p><small class="text-muted"><i class="icon-clock"></i> {{ $aktivitas->waktu->diffForHumans() }}</small></p>
                            </div>
                            <div class="timeline-body">
                                <p>{{ $aktivitas->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="icon-list icon-lg mb-2"></i>
                        <p>Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Aksi Cepat</h6>
                
                <div class="list-group">
                    <a href="{{ route('dokter.konsultasi.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="icon-wrapper bg-primary text-white rounded-circle mr-3 p-2">
                            <i class="icon-paper"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Lihat Antrian</h6>
                            <small class="text-muted">Kelola konsultasi pasien</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('dokter.rekam-medis.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="icon-wrapper bg-success text-white rounded-circle mr-3 p-2">
                            <i class="icon-book"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Buat Rekam Medis</h6>
                            <small class="text-muted">Catat rekam medis baru</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('dokter.chat.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="icon-wrapper bg-info text-white rounded-circle mr-3 p-2">
                            <i class="icon-speech"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Chat Pasien</h6>
                            <small class="text-muted">Balas pesan pasien</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('dokter.jadwal.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="icon-wrapper bg-warning text-white rounded-circle mr-3 p-2">
                            <i class="icon-calendar"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Atur Jadwal</h6>
                            <small class="text-muted">Kelola jadwal praktik</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('dokter.obat.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="icon-wrapper bg-danger text-white rounded-circle mr-3 p-2">
                            <i class="icon-doc"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Data Obat</h6>
                            <small class="text-muted">Lihat informasi obat</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@push('styles')
<style>
.icon-wrapper {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    left: 20px;
    height: 100%;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-left: 60px;
    margin-bottom: 30px;
}

.timeline-badge {
    position: absolute;
    left: 10px;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.timeline-panel {
    border-left: 3px solid #e9ecef;
    padding-left: 15px;
}
</style>
@endpush

@push('scripts')
<script>
// Chart untuk statistik (opsional)
// Tambahkan script chart.js jika diperlukan
</script>
@endpush