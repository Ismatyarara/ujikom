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
        --gray-200: #e2e8f0;
        --gray-500: #64748b;
        --gray-700: #334155;
    }

    .page-wrap { background: #f4f7ff; min-height: 100vh; padding: 32px 28px; font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Header ── */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-header h2 { font-size: 22px; font-weight: 700; color: var(--blue-900); margin: 0; }
    .btn-add { background: var(--blue-600); color: #fff; padding: 9px 18px; border-radius: 10px;
               text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex;
               align-items: center; gap: 7px; transition: background .2s; }
    .btn-add:hover { background: var(--blue-700); color: #fff; }

    /* ── Alert ── */
    .alert-ok { background: var(--green-50); border: 1px solid #bbf7d0; color: var(--green-600);
                padding: 12px 16px; border-radius: 10px; margin-bottom: 20px;
                display: flex; align-items: center; gap: 8px; font-size: 14px; }

    /* ── Search card ── */
    .search-card { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(0,0,0,.06);
                   padding: 20px 24px; margin-bottom: 20px; }
    .search-label { font-size: 13px; font-weight: 600; color: var(--blue-900); margin-bottom: 10px; display: block; }
    .search-row { display: flex; gap: 8px; max-width: 480px; }
    .search-row input { flex: 1; border: 1.5px solid var(--gray-200); border-radius: 9px;
                        padding: 9px 14px; font-size: 14px; outline: none; transition: border .2s; }
    .search-row input:focus { border-color: var(--blue-600); }
    .btn-search { background: var(--blue-600); color: #fff; border: none; border-radius: 9px;
                  padding: 9px 16px; font-size: 14px; cursor: pointer; display: inline-flex;
                  align-items: center; gap: 6px; transition: background .2s; }
    .btn-search:hover { background: var(--blue-700); }
    .btn-reset { background: var(--gray-200); color: var(--gray-700); border: none; border-radius: 9px;
                 padding: 9px 14px; font-size: 14px; cursor: pointer; text-decoration: none;
                 display: inline-flex; align-items: center; gap: 6px; }
    .info-pasien { margin-top: 12px; padding: 10px 14px; border-radius: 9px; font-size: 13px;
                   display: flex; align-items: center; gap: 8px; }
    .info-ok  { background: var(--green-50); border: 1px solid #bbf7d0; color: var(--green-600); }
    .info-err { background: var(--red-50);   border: 1px solid #fecaca;  color: var(--red-600); }
    .badge-code { background: #dbeafe; color: var(--blue-700); padding: 2px 8px; border-radius: 20px;
                  font-size: 12px; font-weight: 600; }

    /* ── Table card ── */
    .table-card { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
    .table-responsive { overflow-x: auto; }
    .table-card table { width: 100%; border-collapse: collapse; }
    .table-card thead th { background: var(--blue-50); color: var(--blue-900); font-size: 13px;
                            font-weight: 700; padding: 13px 14px; border-bottom: 2px solid var(--blue-100); }
    .table-card tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
    .table-card tbody tr:hover { background: #f8fbff; }
    .table-card tbody td { padding: 12px 14px; font-size: 13px; color: var(--gray-700); vertical-align: middle; }
    .patient-name { font-weight: 600; color: var(--blue-900); margin-bottom: 2px; }
    .patient-code { font-size: 12px; color: var(--gray-500); }
    .text-clamp { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: help; }

    /* ── Action buttons ── */
    .actions { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
    .act-btn { display: inline-flex; align-items: center; justify-content: center;
               width: 30px; height: 30px; border-radius: 8px; border: none; cursor: pointer;
               font-size: 13px; text-decoration: none; transition: opacity .2s, transform .1s; }
    .act-btn:hover { opacity: .82; transform: scale(1.07); }
    .btn-jadwal { background: #e0f2fe; color: #0369a1; }
    .btn-show   { background: #ede9fe; color: #7c3aed; }
    .btn-plus   { background: #dcfce7; color: var(--green-600); }
    .btn-edit   { background: #fefce8; color: #ca8a04; }
    .btn-del    { background: var(--red-50); color: var(--red-600); }
</style>

<div class="page-wrap">

    {{-- Header --}}
    <div class="page-header">
        <h2><i class="fa-solid fa-notes-medical me-2" style="color:#2563eb"></i> Catatan Medis</h2>
        <a href="{{ route('dokter.catatan.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Catatan
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert-ok">
        <i class="fas fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Search --}}
    <div class="search-card">
        <span class="search-label"><i class="fas fa-search me-1"></i> Cari Berdasarkan Kode Pasien</span>
        <form method="GET" action="{{ route('dokter.catatan.index') }}">
            <div class="search-row">
                <input type="text" name="kode_pasien"
                       placeholder="Contoh: BTK-2025-0001"
                       value="{{ request('kode_pasien') }}" autofocus>
                <button type="submit" class="btn-search"><i class="fas fa-search"></i> Cari</button>
                @if(request('kode_pasien'))
                <a href="{{ route('dokter.catatan.index') }}" class="btn-reset">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </div>
        </form>

        @if(request()->filled('kode_pasien'))
            @if($pasienDicari)
            <div class="info-pasien info-ok">
                <i class="fas fa-user-check"></i>
                Menampilkan catatan milik <strong class="ms-1">{{ $pasienDicari->name }}</strong>
                <span class="badge-code ms-1">{{ $pasienDicari->kode_pasien }}</span>
            </div>
            @else
            <div class="info-pasien info-err">
                <i class="fas fa-user-times"></i>
                Kode pasien <strong>"{{ request('kode_pasien') }}"</strong> tidak ditemukan.
            </div>
            @endif
        @endif
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width:4%">#</th>
                    <th style="width:16%">Pasien</th>
                    <th style="width:13%">Dokter</th>
                    <th style="width:11%">Diagnosa</th>
                    <th style="width:13%">Tanggal</th>
                    <th style="width:17%">Keluhan</th>
                    <th style="width:15%">Deskripsi</th>
                    <th style="width:11%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($catatan as $item)
                <tr>
                    <td>{{ ($catatan->currentPage() - 1) * $catatan->perPage() + $loop->iteration }}</td>
                    <td>
                        <div class="patient-name">{{ $item->user->name }}</div>
                        <div class="patient-code">{{ $item->user->kode_pasien }}</div>
                    </td>
                    <td>{{ $item->dokter->nama ?? '-' }}</td>
                    <td>{{ $item->diagnosa }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_catatan)->format('d/m/Y H:i') }}</td>
                    <td><div class="text-clamp" title="{{ $item->keluhan }}">{{ Str::limit($item->keluhan, 55) }}</div></td>
                    <td><div class="text-clamp" title="{{ $item->deskripsi }}">{{ Str::limit($item->deskripsi, 55) }}</div></td>
                    <td>
                        <div class="actions">
                            {{-- Buat Jadwal --}}
                            <a href="{{ route('dokter.jadwal.create', ['catatan_id' => $item->id]) }}"
                               class="act-btn btn-jadwal" title="Buat Jadwal Obat">
                                <i class="fas fa-calendar-plus"></i>
                            </a>
                            {{-- Lihat Jadwal --}}
                            <a href="{{ route('dokter.jadwal.index', ['user_id' => $item->user->id]) }}"
                               class="act-btn btn-show" title="Lihat Jadwal Obat">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- Tambah Catatan Baru --}}
                            <a href="{{ route('dokter.catatan.create', ['user_id' => $item->user->id]) }}"
                               class="act-btn btn-plus" title="Tambah Catatan Baru">
                                <i class="fas fa-plus"></i>
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('dokter.catatan.edit', $item->id) }}"
                               class="act-btn btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            {{-- Hapus --}}
                            <form action="{{ route('dokter.catatan.destroy', $item->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
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
                    @if(request('kode_pasien') && $pasienDicari)
                    <td>1</td>
                    <td>
                        <div class="patient-name">{{ $pasienDicari->name }}</div>
                        <div class="patient-code">{{ $pasienDicari->kode_pasien }}</div>
                    </td>
                    <td colspan="5" style="color:var(--gray-500);font-style:italic">Belum ada catatan medis</td>
                    <td>
                        <a href="{{ route('dokter.catatan.create', ['user_id' => $pasienDicari->id]) }}"
                           class="act-btn btn-plus" title="Tambah Catatan">
                            <i class="fas fa-plus"></i>
                        </a>
                    </td>
                    @else
                    <td colspan="8">
                        <div style="text-align:center;padding:40px;color:var(--gray-500)">
                            <i class="fas fa-folder-open" style="font-size:28px;opacity:.4;margin-bottom:10px;display:block"></i>
                            Belum ada catatan medis.
                        </div>
                    </td>
                    @endif
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $catatan->links() }}
    </div>

</div>

@push('scripts')
<script>
    document.querySelectorAll('[title]').forEach(el => {
        if (typeof bootstrap !== 'undefined') {
            new bootstrap.Tooltip(el, { trigger: 'hover' });
        }
    });
</script>
@endpush
@endsection
