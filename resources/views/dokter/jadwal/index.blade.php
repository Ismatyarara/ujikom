@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --blue-50:  #eff6ff;
        --blue-100: #dbeafe;
        --blue-600: #2563eb;
        --blue-700: #1d4ed8;
        --blue-900: #1e3a8a;
        --green-50: #f0fdf4;
        --green-600:#16a34a;
        --red-50:   #fef2f2;
        --red-600:  #dc2626;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-700: #334155;
    }

    .page-wrap { background: #f4f7ff; min-height: 100vh; padding: 32px 28px; font-family: 'Plus Jakarta Sans', sans-serif; }

    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-header h2 { font-size: 22px; font-weight: 700; color: var(--blue-900); margin: 0; }

    .alert-ok { background: var(--green-50); border: 1px solid #bbf7d0; color: var(--green-600);
                padding: 12px 16px; border-radius: 10px; margin-bottom: 20px;
                display: flex; align-items: center; gap: 8px; font-size: 14px; }

    .table-card { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
    .table-card table { width: 100%; border-collapse: collapse; }
    .table-card thead th { background: var(--blue-50); color: var(--blue-900); font-size: 13px;
                            font-weight: 700; padding: 13px 14px; border-bottom: 2px solid var(--blue-100);
                            white-space: nowrap; }
    .table-card tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
    .table-card tbody tr:hover { background: #f8fbff; }
    .table-card tbody td { padding: 12px 14px; font-size: 13px; color: var(--gray-700); vertical-align: middle; }

    .patient-name { font-weight: 600; color: var(--blue-900); margin-bottom: 2px; }
    .patient-code { font-size: 12px; color: var(--gray-500); }

    .pill-badge { display: inline-flex; align-items: center; gap: 5px; background: var(--blue-50);
                  border: 1px solid var(--blue-100); color: var(--blue-700); border-radius: 20px;
                  padding: 3px 10px; font-size: 12px; font-weight: 600; }

    .waktu-tags { display: flex; flex-wrap: wrap; gap: 4px; }
    .waktu-tag { background: var(--green-50); border: 1px solid #bbf7d0; color: var(--green-600);
                 border-radius: 6px; padding: 2px 8px; font-size: 12px; font-weight: 600;
                 display: inline-flex; align-items: center; gap: 4px; }
    .waktu-empty { color: var(--gray-400); font-size: 12px; font-style: italic; }

    .period-text { font-size: 12px; color: var(--gray-500); line-height: 1.8; }

    .text-clamp { max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: help; }

    /* Action buttons */
    .actions { display: flex; align-items: center; gap: 5px; }
    .act-btn { display: inline-flex; align-items: center; justify-content: center;
               width: 30px; height: 30px; border-radius: 8px; border: none; cursor: pointer;
               font-size: 12px; text-decoration: none; transition: opacity .2s, transform .1s; flex-shrink: 0; }
    .act-btn:hover { opacity: .8; transform: scale(1.08); }
    .btn-show  { background: #e0f2fe; color: #0369a1; }
    .btn-waktu { background: #ede9fe; color: #7c3aed; }
    .btn-edit  { background: #fefce8; color: #ca8a04; }
    .btn-del   { background: var(--red-50); color: var(--red-600); }

    .paging { padding: 16px 20px; display: flex; justify-content: flex-end; border-top: 1px solid var(--gray-100); }

    .empty-state { text-align: center; padding: 50px 20px; color: var(--gray-500); }
    .empty-state i { font-size: 36px; opacity: .35; display: block; margin-bottom: 12px; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>

<div class="page-wrap">

    <div class="page-header">
        <h2><i class="fas fa-calendar-check me-2" style="color:#2563eb"></i> Jadwal Obat</h2>
    </div>

    @if(session('success'))
    <div class="alert-ok">
        <i class="fas fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th style="width:4%">#</th>
                    <th style="width:15%">Pasien</th>
                    <th style="width:12%">Dokter</th>
                    <th style="width:13%">Nama Obat</th>
                    <th style="width:16%">Periode</th>
                    <th style="width:18%">Waktu Minum</th>
                    <th style="width:14%">Instruksi</th>
                    <th style="width:8%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $item)
                <tr>
                    <td>{{ $jadwals->firstItem() + $loop->index }}</td>

                    <td>
                        <div class="patient-name">{{ $item->user->name }}</div>
                        <div class="patient-code">{{ $item->user->kode_pasien ?? '' }}</div>
                    </td>

                    <td>{{ $item->dokter->nama ?? '-' }}</td>

                    <td>
                        <span class="pill-badge">
                            <i class="fas fa-pills"></i> {{ $item->nama_obat }}
                        </span>
                    </td>

                    <td>
                        <div class="period-text">
                            <i class="fas fa-calendar-day" style="color:var(--blue-600)"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                        </div>
                        <div class="period-text">
                            <i class="fas fa-arrow-right" style="font-size:10px;color:var(--gray-400)"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                        </div>
                    </td>

                    <td>
                        @if($item->waktuObat && $item->waktuObat->count())
                            <div class="waktu-tags">
                                @foreach($item->waktuObat as $w)
                                    <span class="waktu-tag">
                                        <i class="fas fa-clock" style="font-size:10px"></i>
                                        {{ \Carbon\Carbon::parse($w->waktu)->format('H:i') }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="waktu-empty">
                                <i class="fas fa-clock-rotate-left"></i> Belum diatur
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="text-clamp" title="{{ $item->deskripsi }}">
                            {{ $item->deskripsi ? Str::limit($item->deskripsi, 45) : '-' }}
                        </div>
                    </td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('dokter.jadwal.show', $item->id) }}"
                               class="act-btn btn-show" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('dokter.jadwal.waktu.create', $item->id) }}"
                               class="act-btn btn-waktu" title="Atur Waktu">
                                <i class="fas fa-clock"></i>
                            </a>
                            <a href="{{ route('dokter.jadwal.edit', $item->id) }}"
                               class="act-btn btn-edit" title="Edit Jadwal">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('dokter.jadwal.destroy', $item->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="act-btn btn-del" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-calendar-xmark"></i>
                            <p>Belum ada jadwal obat yang dibuat.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($jadwals->hasPages())
        <div class="paging">
            {{ $jadwals->links() }}
        </div>
        @endif
    </div>

</div>
@endsection