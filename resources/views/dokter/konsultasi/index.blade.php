@extends('layouts.app')
@section('title', 'Konsultasi Pasien')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold">Manajemen Konsultasi</h3>
            <p class="text-muted mb-0">Kelola percakapan dengan pasien Anda.</p>
        </div>
        <a href="{{ url('chat') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-comments me-2"></i> Buka Chat
        </a>
    </div>

    {{-- Unread Alert --}}
    @if (isset($unreadCount) && $unreadCount > 0)
        <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
            <i class="fas fa-bell fs-4 me-3"></i>
            <div>
                <h6 class="mb-0 fw-bold">{{ $unreadCount }} Pesan Belum Dibaca</h6>
                <small>Segera balas pesan pasien untuk menjaga kualitas pelayanan</small>
            </div>
        </div>
    @endif

    {{-- Message List --}}
    <div class="row g-3">
        @forelse($recentMessages ?? [] as $msg)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 hover-card {{ $msg->seen == 0 ? 'border-start border-4 border-warning' : '' }}"
                    style="cursor: pointer;"
                    onclick="readMsg({{ $msg->id }}); window.location='{{ url('chat/' . $msg->from_id) }}'">
                    <div class="card-body d-flex align-items-start">

                        {{-- Avatar --}}
                        <div class="me-3 flex-shrink-0">
                            <img src="{{ $msg->from_user->profile?->foto ? asset('storage/' . $msg->from_user->profile->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($msg->from_user->name) . '&background=random' }}"
                                class="rounded-circle border border-3 {{ $msg->seen == 0 ? 'border-warning' : 'border-light' }}"
                                width="55" height="55" style="object-fit: cover;">
                        </div>

                        {{-- Info --}}
                        <div class="flex-grow-1" style="min-width: 0;">

                            {{-- Nama & Badge --}}
                            <div class="d-flex align-items-center gap-2 mb-1">
                                @if ($msg->seen == 0)
                                    <span class="badge bg-danger px-2 py-1" style="font-size: 0.7rem;">Baru</span>
                                @endif
                                <h6 class="mb-0 fw-bold text-truncate">
                                    {{ $msg->from_user->profile->nama_panjang ?? $msg->from_user->name }}
                                </h6>
                            </div>

                            {{-- Detail Pasien --}}
                            @if ($msg->from_user->profile)
                                <div class="d-flex flex-wrap gap-1 text-muted mb-2" style="font-size: 0.75rem;">
                                    <span>
                                        <i class="fas fa-{{ $msg->from_user->profile->jenis_kelamin == 'L' ? 'mars text-primary' : 'venus text-danger' }} me-1"></i>
                                        {{ $msg->from_user->profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                    @if ($msg->from_user->profile->tanggal_lahir)
                                        <span>•</span>
                                        <span><i class="fas fa-birthday-cake me-1"></i>{{ \Carbon\Carbon::parse($msg->from_user->profile->tanggal_lahir)->age }} tahun</span>
                                    @endif
                                    @if ($msg->from_user->profile->golongan_darah && $msg->from_user->profile->golongan_darah != '-')
                                        <span>•</span>
                                        <span class="badge bg-danger-subtle text-danger px-1 py-0" style="font-size: 0.7rem;">
                                            <i class="fas fa-tint me-1"></i>{{ $msg->from_user->profile->golongan_darah }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <small class="text-warning d-block mb-2" style="font-size: 0.75rem;">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Profile belum lengkap
                                </small>
                            @endif

                            {{-- Pesan --}}
                            <p class="mb-1 {{ $msg->seen == 0 ? 'fw-semibold text-dark' : 'text-muted' }}" style="font-size: 0.9rem;">
                                <i class="fas fa-comment-dots me-2 text-primary"></i>{{ Str::limit($msg->body, 120) }}
                            </p>

                            {{-- Waktu --}}
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="far fa-clock me-1"></i>{{ $msg->created_at->diffForHumans() }}
                            </small>

                        </div>

                        {{-- Badge & Balas --}}
                        @if ($msg->seen == 0)
                            <div class="ms-3 flex-shrink-0 text-end">
                                <span class="badge bg-warning text-dark px-3 py-2 mb-2 d-block" style="font-size: 0.75rem;">
                                    <i class="fas fa-envelope me-1"></i> Belum Dibaca
                                </span>
                                <a href="{{ route('user', $msg->from_id) }}"
                                    class="btn btn-sm btn-primary rounded-pill px-3 d-block"
                                    onclick="readMsg({{ $msg->id }}); event.stopPropagation();">
                                    <i class="fas fa-reply me-1"></i> Balas
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center py-5">
                        <img src="https://illustrations.popsy.co/gray/active-search.png" style="width: 150px;" class="mb-3 opacity-50">
                        <h5 class="text-muted">Belum Ada Pesan Konsultasi</h5>
                        <p class="text-muted small mb-0">Pesan dari pasien akan muncul di sini</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Tips --}}
    <div class="alert alert-info border-0 shadow-sm rounded-4 d-flex align-items-center mt-4">
        <i class="fas fa-info-circle fs-4 me-3"></i>
        <div>
            <h6 class="mb-0 fw-bold">Tips Konsultasi</h6>
            <small>Klik pada card untuk membuka chat lengkap dengan pasien.</small>
        </div>
    </div>

</div>

<style>
    .hover-card { transition: all 0.3s ease; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15) !important; }
</style>

<script>
    function readMsg(id) {
        fetch(`/read/${id}`, { method: 'POST' });
    }
</script>
@endsection