@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --blue-50: #eff6ff;
        --blue-100: #dbeafe;
        --blue-600: #2563eb;
        --blue-700: #1d4ed8;
        --blue-900: #1e3a8a;
        --green-50: #f0fdf4;
        --green-600: #16a34a;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-700: #334155;
        --red-100: #fee2e2;
        --red-600: #dc2626;
    }

    .page-wrap { background: #f4f7ff; min-height: 100vh; padding: 32px 28px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .breadcrumb { font-size: 13px; margin-bottom: 22px; display: flex; align-items: center; gap: 6px; color: var(--gray-400); }
    .breadcrumb a { color: var(--blue-600); text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }
    .steps { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 28px; }
    .step-item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--gray-400); }
    .step-item.done { color: var(--green-600); }
    .step-item.active { color: var(--blue-600); }
    .step-num { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; background: var(--gray-200); color: var(--gray-500); }
    .step-item.done .step-num { background: var(--green-600); color: #fff; }
    .step-item.active .step-num { background: var(--blue-600); color: #fff; }
    .step-line { width: 48px; height: 2px; background: var(--blue-100); margin: 0 6px; }
    .layout { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width: 768px) { .layout { grid-template-columns: 1fr; } }
    .card { background: #fff; border-radius: 14px; box-shadow: 0 4px 18px rgba(0,0,0,.06); padding: 24px; }
    .card-title { font-size: 15px; font-weight: 700; color: var(--blue-900); margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
    .info-row { margin-bottom: 13px; }
    .info-row .label { font-size: 12px; color: var(--gray-500); margin-bottom: 2px; }
    .info-row .value { font-size: 14px; font-weight: 600; color: var(--gray-700); }
    .period-badge { margin-top: 18px; background: var(--blue-50); border: 1px solid var(--blue-100); color: var(--blue-700); border-radius: 8px; padding: 10px 14px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
    .time-title { font-size: 15px; font-weight: 700; color: var(--blue-900); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .time-row { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
    .time-row input[type="time"] { flex: 1; border: 1.5px solid var(--gray-200); border-radius: 10px; padding: 10px 14px; font-size: 14px; outline: none; transition: border .2s; }
    .time-row input[type="time"]:focus { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
    .btn-remove { width: 34px; height: 34px; border-radius: 8px; background: var(--red-100); color: var(--red-600); border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
    .btn-add-time { display: inline-flex; align-items: center; gap: 7px; background: var(--blue-50); border: 1.5px dashed var(--blue-600); color: var(--blue-600); padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; margin-bottom: 16px; }
    .btn-save { width: 100%; padding: 12px; border: none; background: var(--blue-600); color: #fff; border-radius: 10px; font-weight: 700; font-size: 15px; cursor: pointer; }
    .alert-ok { background: var(--green-50); border: 1px solid #bbf7d0; color: var(--green-600); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-size: 14px; }
</style>

<div class="page-wrap">
    <div class="breadcrumb">
        <a href="{{ route('dokter.dashboard') }}"><i class="fas fa-house"></i> Dashboard</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <a href="{{ route('dokter.jadwal.index') }}">Jadwal</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <span>Atur Waktu</span>
    </div>

    @if(session('success'))
    <div class="alert-ok">
        <i class="fas fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <div class="steps">
        <div class="step-item done">
            <div class="step-num"><i class="fas fa-check" style="font-size:11px"></i></div>
            Info Jadwal
        </div>
        <div class="step-line"></div>
        <div class="step-item active">
            <div class="step-num">2</div>
            Atur Waktu
        </div>
    </div>

    <div class="layout">
        <div class="card">
            <div class="card-title"><i class="fas fa-clipboard-list" style="color:var(--blue-600)"></i> Ringkasan Jadwal</div>

            <div class="info-row">
                <div class="label">Pasien</div>
                <div class="value">{{ $jadwal->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="label">Dokter</div>
                <div class="value">{{ $jadwal->dokter->nama }}</div>
            </div>
            <div class="info-row">
                <div class="label">Nama Obat</div>
                <div class="value"><i class="fas fa-pills me-1" style="color:var(--blue-600)"></i> {{ $jadwal->nama_obat }}</div>
            </div>
            @if($jadwal->deskripsi)
            <div class="info-row">
                <div class="label">Instruksi</div>
                <div class="value">{{ $jadwal->deskripsi }}</div>
            </div>
            @endif

            <div class="period-badge">
                <i class="fas fa-calendar-range"></i>
                {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}
                &nbsp;&rarr;&nbsp;
                {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}
            </div>
        </div>

        <div class="card">
            <div class="time-title"><i class="fas fa-clock" style="color:var(--blue-600)"></i> Waktu Minum Obat</div>

            <form action="{{ route('dokter.jadwal.waktu.store', $jadwal->id) }}" method="POST">
                @csrf
                <div id="time-container">
                    <div class="time-row">
                        <input type="time" name="waktu[]" required>
                        <button type="button" class="btn-remove" onclick="removeRow(this)" style="visibility:hidden">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <button type="button" class="btn-add-time" onclick="addRow()">
                    <i class="fas fa-plus"></i> Tambah Waktu
                </button>

                <button type="submit" class="btn-save">
                    <i class="fas fa-floppy-disk me-1"></i> Simpan Waktu
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function updateRemove() {
        const rows = document.querySelectorAll('.time-row');
        rows.forEach(r => {
            r.querySelector('.btn-remove').style.visibility = rows.length > 1 ? 'visible' : 'hidden';
        });
    }

    function addRow() {
        const row = document.createElement('div');
        row.className = 'time-row';
        row.innerHTML = `
            <input type="time" name="waktu[]" required>
            <button type="button" class="btn-remove" onclick="removeRow(this)">
                <i class="fas fa-times"></i>
            </button>`;
        document.getElementById('time-container').appendChild(row);
        updateRemove();
    }

    function removeRow(btn) {
        const rows = document.querySelectorAll('.time-row');
        if (rows.length > 1) {
            btn.closest('.time-row').remove();
            updateRemove();
        }
    }
</script>
@endsection
