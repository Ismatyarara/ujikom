@extends('layouts.app')
@section('title', 'Konsultasi Pasien')

@section('content')
    <style>
        .consultation-page {
            background: linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
            min-height: 100vh;
        }

        .consultation-card {
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            background: #ffffff;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .consultation-card-inner {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            gap: 18px;
            align-items: start;
        }

        .consultation-card:hover {
            transform: translateY(-2px);
            border-color: #c7d2fe;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
        }

        .consultation-avatar {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            object-fit: cover;
            border: 3px solid #e2e8f0;
            background: #f8fafc;
        }

        .consultation-avatar.unread {
            border-color: #22c55e;
        }

        .consultation-name-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .consultation-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            line-height: 1.3;
        }

        .consultation-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 0.72rem;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
        }

        .consultation-badge.new {
            background: #dcfce7;
            color: #15803d;
        }

        .consultation-badge.code {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .consultation-copy-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            background: #f8fbff;
            color: #2563eb;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }

        .consultation-copy-btn:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            transform: translateY(-1px);
        }

        .consultation-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.82rem;
            color: #64748b;
            margin-bottom: 12px;
        }

        .consultation-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .consultation-message {
            font-size: 0.94rem;
            line-height: 1.6;
            color: #334155;
            margin-bottom: 14px;
            word-break: break-word;
            min-height: 48px;
        }

        .consultation-footer {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            flex-wrap: wrap;
        }

        .consultation-time {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .consultation-actions {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
            gap: 14px;
            min-height: 100%;
        }

        .consultation-reply {
            min-width: 112px;
            border-radius: 14px;
            padding: 10px 18px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
            border: none;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.18);
        }

        .consultation-reply:hover {
            color: #fff;
        }

        @media (max-width: 768px) {
            .consultation-card-inner {
                grid-template-columns: 1fr;
            }

            .consultation-avatar-wrap {
                display: flex;
                justify-content: center;
            }

            .consultation-actions {
                align-items: stretch;
            }

            .consultation-reply {
                width: 100%;
            }
        }
    </style>

    <div class="consultation-page">
        <div class="container py-5">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <h3 class="fw-bold mb-1">Manajemen Konsultasi</h3>
                    <p class="text-muted mb-0">Kelola percakapan dengan pasien Anda.</p>
                </div>
                <a href="{{ route('Chat', ['id' => Auth::id()]) }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-comments me-2"></i> Buka Chat
                </a>
            </div>

            @if (isset($unreadCount) && $unreadCount > 0)
                <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
                    <i class="fas fa-bell fs-4 me-3"></i>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $unreadCount }} Pesan Belum Dibaca</h6>
                        <small>Segera balas pesan pasien untuk menjaga kualitas pelayanan</small>
                    </div>
                </div>
            @endif

            <div class="row g-3">
                @forelse($recentMessages ?? [] as $msg)
                    <div class="col-12">
                        <div
                            class="consultation-card p-3 p-md-4 {{ $msg->seen == 0 ? 'border-start border-4 border-success' : '' }}"
                            style="cursor: pointer;"
                            onclick="window.location='{{ route('user', ['id' => $msg->from_id]) }}'"
                        >
                            <div class="consultation-card-inner">
                                <div class="consultation-avatar-wrap">
                                    <img
                                        src="{{ $msg->from_user->profile?->foto ? asset('storage/' . $msg->from_user->profile->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($msg->from_user->name) . '&background=random' }}"
                                        class="consultation-avatar {{ $msg->seen == 0 ? 'unread' : '' }}"
                                        alt="{{ $msg->from_user->name }}"
                                    >
                                </div>

                                <div style="min-width: 0;">
                                    <div class="consultation-name-row">
                                        <h6 class="consultation-name">
                                            {{ $msg->from_user->profile->nama_panjang ?? $msg->from_user->name }}
                                        </h6>

                                        @if ($msg->from_user->kode_pasien)
                                            <span class="consultation-badge code">
                                                #{{ $msg->from_user->kode_pasien }}
                                            </span>
                                            <button
                                                type="button"
                                                class="consultation-copy-btn"
                                                title="Salin kode pasien"
                                                onclick="copyPatientCode('{{ $msg->from_user->kode_pasien }}', event)"
                                            >
                                                <i class="fas fa-copy" style="font-size: 0.78rem;"></i>
                                            </button>
                                        @endif

                                        @if ($msg->seen == 0)
                                            <span class="consultation-badge new">Baru</span>
                                        @endif
                                    </div>

                                    @if ($msg->from_user->profile)
                                        <div class="consultation-meta">
                                            <span>
                                                <i class="fas fa-user"></i>
                                                {{ $msg->from_user->profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </span>

                                            @if ($msg->from_user->profile->tanggal_lahir)
                                                <span>
                                                    <i class="fas fa-birthday-cake"></i>
                                                    {{ \Carbon\Carbon::parse($msg->from_user->profile->tanggal_lahir)->age }} tahun
                                                </span>
                                            @endif

                                            @if ($msg->from_user->profile->golongan_darah && $msg->from_user->profile->golongan_darah != '-')
                                                <span>
                                                    <i class="fas fa-tint"></i>
                                                    {{ $msg->from_user->profile->golongan_darah }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <small class="text-warning d-block mb-2" style="font-size: 0.78rem;">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Profil pasien belum lengkap
                                        </small>
                                    @endif

                                    <p class="consultation-message {{ $msg->seen == 0 ? 'fw-semibold' : '' }}">
                                        {{ Str::limit($msg->body, 140) }}
                                    </p>

                                    <div class="consultation-footer">
                                        <small class="consultation-time">
                                            <i class="far fa-clock me-1"></i>{{ $msg->created_at->diffForHumans() }}
                                        </small>

                                        @if ($msg->seen == 0)
                                            <span class="consultation-badge new">Belum dibaca</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="consultation-actions">
                                    <a
                                        href="{{ route('user', ['id' => $msg->from_id]) }}"
                                        class="consultation-reply"
                                        onclick="event.stopPropagation();"
                                    >
                                        Balas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/active-search.png" style="width: 150px;"
                                    class="mb-3 opacity-50" alt="Kosong">
                                <h5 class="text-muted">Belum Ada Pesan Konsultasi</h5>
                                <p class="text-muted small mb-0">Pesan dari pasien akan muncul di sini</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="alert alert-info border-0 shadow-sm rounded-4 d-flex align-items-center mt-4">
                <i class="fas fa-info-circle fs-4 me-3"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Tips Konsultasi</h6>
                    <small>Klik pada kartu untuk membuka chat lengkap dengan pasien.</small>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyPatientCode(code, event) {
            event.stopPropagation();

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(code).then(function () {
                    alert('Kode pasien berhasil disalin: ' + code);
                });
                return;
            }

            const tempInput = document.createElement('input');
            tempInput.value = code;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Kode pasien berhasil disalin: ' + code);
        }

        (function () {
            const refreshIntervalMs = 15000;
            let refreshTimer = null;

            function refreshPage() {
                if (document.visibilityState === 'visible') {
                    window.location.reload();
                }
            }

            function startAutoRefresh() {
                stopAutoRefresh();
                refreshTimer = window.setInterval(refreshPage, refreshIntervalMs);
            }

            function stopAutoRefresh() {
                if (refreshTimer) {
                    window.clearInterval(refreshTimer);
                    refreshTimer = null;
                }
            }

            document.addEventListener('visibilitychange', function () {
                if (document.visibilityState === 'visible') {
                    refreshPage();
                    startAutoRefresh();
                } else {
                    stopAutoRefresh();
                }
            });

            window.addEventListener('focus', refreshPage);
            startAutoRefresh();
        })();
    </script>
@endsection
