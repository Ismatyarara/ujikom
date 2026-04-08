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
        --green-100:#dcfce7;
        --green-600:#16a34a;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-700: #334155;
        --red-100:  #fee2e2;
        --red-600:  #dc2626;
    }

    .page-wrap { background: #f4f7ff; min-height: 100vh; padding: 32px 28px; font-family: 'Plus Jakarta Sans', sans-serif; }

    .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--gray-500);
                 font-size: 13px; text-decoration: none; margin-bottom: 20px; }
    .back-link:hover { color: var(--blue-600); }

    .steps { display: flex; align-items: center; gap: 0; margin-bottom: 24px; }
    .step-item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--gray-400); }
    .step-item.active { color: var(--blue-600); }
    .step-item.done   { color: var(--green-600); }
    .step-num { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center;
                justify-content: center; font-size: 12px; font-weight: 700; background: var(--gray-200);
                color: var(--gray-500); flex-shrink: 0; }
    .step-item.active .step-num { background: var(--blue-600); color: #fff; }
    .step-item.done   .step-num { background: var(--green-600); color: #fff; }
    .step-line { width: 40px; height: 2px; background: var(--gray-200); margin: 0 4px; }

    .form-card { background: #fff; border-radius: 16px; box-shadow: 0 6px 24px rgba(0,0,0,.07); overflow: hidden; }
    .card-head { background: linear-gradient(135deg, var(--blue-600), #1e40af); color: #fff; padding: 24px 28px; }
    .card-head h4 { margin: 0 0 4px; font-size: 18px; font-weight: 700; }
    .card-head p  { margin: 0; font-size: 13px; opacity: .85; }
    .card-body    { padding: 28px; }

    .catatan-banner { background: var(--blue-50); border: 1.5px solid var(--blue-100); border-radius: 12px;
                      padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
    .catatan-banner .icon { width: 38px; height: 38px; background: var(--blue-100); border-radius: 10px;
                             display: flex; align-items: center; justify-content: center; color: var(--blue-600);
                             font-size: 16px; flex-shrink: 0; }
    .catatan-banner .info { font-size: 13px; color: var(--blue-900); }
    .catatan-banner .info strong { display: block; font-size: 14px; margin-bottom: 2px; }

    .sec-title { font-size: 13px; font-weight: 700; color: var(--blue-900); text-transform: uppercase;
                 letter-spacing: .05em; margin: 24px 0 14px; display: flex; align-items: center; gap: 8px; }
    .sec-title::after { content: ''; flex: 1; height: 1px; background: var(--blue-100); }

    .form-label { font-size: 13px; font-weight: 600; color: var(--gray-700); margin-bottom: 6px; display: block; }
    .form-control, .form-select { border: 1.5px solid var(--gray-200); border-radius: 10px;
                                   padding: 10px 14px; font-size: 14px; width: 100%;
                                   transition: border .2s, box-shadow .2s; box-sizing: border-box; }
    .form-control:focus, .form-select:focus { border-color: var(--blue-600);
                                               box-shadow: 0 0 0 3px rgba(37,99,235,.12); outline: none; }
    textarea.form-control { resize: vertical; }

    /* Locked field */
    .locked-field { background: var(--gray-100); border: 1.5px solid var(--gray-200); border-radius: 10px;
                    padding: 10px 14px; font-size: 14px; color: var(--gray-700); display: flex;
                    align-items: center; gap: 8px; }
    .locked-field i.fa-user, .locked-field i.fa-user-doctor { color: var(--blue-600); }
    .locked-badge { margin-left: auto; background: var(--blue-100); color: var(--blue-700);
                    width: 24px; height: 24px; border-radius: 50%; display: inline-flex;
                    align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0; }

    /* Obat rows */
    .obat-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 10px; }
    .obat-row  { display: flex; align-items: center; gap: 8px; }
    .obat-row select { flex: 1; }
    .obat-row .qty-wrap { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
    .obat-row .qty-wrap input[type="number"] { width: 64px; border: 1.5px solid var(--gray-200);
                                               border-radius: 10px; padding: 10px 8px; font-size: 14px;
                                               text-align: center; outline: none; transition: border .2s;
                                               box-sizing: border-box; }
    .obat-row .qty-wrap input[type="number"]:focus { border-color: var(--blue-600);
                                                      box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
    .obat-row .qty-wrap select.satuan { width: 90px; border: 1.5px solid var(--gray-200);
                                        border-radius: 10px; padding: 10px 8px; font-size: 13px;
                                        outline: none; transition: border .2s; box-sizing: border-box;
                                        color: var(--gray-700); cursor: pointer; }
    .obat-row .qty-wrap select.satuan:focus { border-color: var(--blue-600);
                                              box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
    .btn-remove-obat { width: 34px; height: 34px; border-radius: 8px; background: var(--red-100);
                        color: var(--red-600); border: none; cursor: pointer; display: inline-flex;
                        align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;
                        transition: opacity .2s; }
    .btn-remove-obat:hover { opacity: .75; }
    .btn-add-obat { display: inline-flex; align-items: center; gap: 7px; background: var(--green-50);
                    border: 1.5px dashed var(--green-600); color: var(--green-600); padding: 8px 16px;
                    border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background .2s; }
    .btn-add-obat:hover { background: var(--green-100); }

    .form-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 30px;
                   padding-top: 20px; border-top: 1px solid var(--gray-200); }
    .btn-back { display: inline-flex; align-items: center; gap: 7px; background: var(--gray-100);
                color: var(--gray-700); padding: 10px 20px; border-radius: 10px; text-decoration: none;
                font-size: 14px; font-weight: 600; transition: background .2s; border: none; }
    .btn-back:hover { background: var(--gray-200); }
    .btn-submit { display: inline-flex; align-items: center; gap: 7px; background: var(--blue-600);
                  color: #fff; padding: 10px 22px; border-radius: 10px; border: none; font-size: 14px;
                  font-weight: 600; cursor: pointer; transition: background .2s; }
    .btn-submit:hover { background: var(--blue-700); }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media(max-width:640px) { .grid-2 { grid-template-columns: 1fr; } }

    .alert-err { background: #fef2f2; border: 1px solid #fecaca; color: var(--red-600);
                 border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; }
    .alert-err ul { margin: 6px 0 0 16px; padding: 0; }
</style>

<div class="page-wrap">

    <a href="{{ route('dokter.jadwal.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Kembali ke Jadwal Obat
    </a>

    <div class="steps">
        <div class="step-item active">
            <div class="step-num">1</div>
            Info Jadwal
        </div>
        <div class="step-line"></div>
        <div class="step-item">
            <div class="step-num">2</div>
            Atur Waktu
        </div>
    </div>

    <div class="form-card">
        <div class="card-head">
            <h4><i class="fas fa-calendar-plus me-2"></i> Tambah Jadwal Obat</h4>
            <p>Lengkapi informasi jadwal konsumsi obat untuk pasien</p>
        </div>

        <div class="card-body">

            @if($errors->any())
            <div class="alert-err">
                <strong><i class="fas fa-circle-exclamation me-1"></i> Terjadi kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif

            @if($catatan)
            <div class="catatan-banner">
                <div class="icon"><i class="fas fa-file-medical"></i></div>
                <div class="info">
                    <strong>Jadwal dibuat dari Catatan Medis</strong>
                    Pasien: <strong>{{ $catatan->user->name }}</strong>
                    &nbsp;·&nbsp; Diagnosa: <em>{{ $catatan->diagnosa }}</em>
                    &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($catatan->tanggal_catatan)->format('d M Y') }}
                </div>
            </div>
            @endif

            <form action="{{ route('dokter.jadwal.store') }}" method="POST" id="jadwalForm">
                @csrf

                {{-- Pihak Terkait --}}
                <div class="sec-title"><i class="fas fa-users"></i> Pihak Terkait</div>
                <div class="grid-2">
                    <div>
                        <label class="form-label">Pasien</label>
                        <input type="hidden" name="user_id" value="{{ $catatan ? $catatan->user_id : ($pasienSelected?->id ?? '') }}">
                        <div class="locked-field">
                            <i class="fas fa-user"></i>
                            {{ $catatan ? $catatan->user->name : ($pasienSelected?->name ?? '-') }}
                            <span class="locked-badge"><i class="fas fa-lock"></i></span>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Dokter</label>
                        <input type="hidden" name="dokter_id" value="{{ $dokter->id }}">
                        <div class="locked-field">
                            <i class="fas fa-user-doctor"></i>
                            {{ $dokter->nama }}
                            <span class="locked-badge"><i class="fas fa-lock"></i></span>
                        </div>
                    </div>
                </div>

                {{-- Daftar Obat --}}
                <div class="sec-title"><i class="fas fa-pills"></i> Obat yang Diresepkan</div>
                <div class="obat-list" id="obatList">
                    <div class="obat-row">
                        <select name="obats[]" class="form-select obat-select" required onchange="syncObatOptions()">
                            <option value="">Pilih obat…</option>
                            @foreach($obats as $o)
                                <option value="{{ $o->nama_obat }}">{{ $o->nama_obat }}</option>
                            @endforeach
                        </select>
                        <div class="qty-wrap">
                            <input type="number" name="jumlah[]" min="1" value="1" required>
                            <select name="satuan[]" class="satuan">
                                <option value="tablet">Tablet</option>
                                <option value="kapsul">Kapsul</option>
                                <option value="sirup">Sirup</option>
                                <option value="ml">ml</option>
                                <option value="tetes">Tetes</option>
                                <option value="sachet">Sachet</option>
                            </select>
                        </div>
                        <button type="button" class="btn-remove-obat" onclick="removeObat(this)" style="visibility:hidden">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn-add-obat" onclick="addObat()">
                    <i class="fas fa-plus"></i> Tambah Obat Lain
                </button>

                {{-- Periode --}}
                <div class="sec-title"><i class="fas fa-calendar-days"></i> Periode Konsumsi</div>
                <div class="grid-2">
                    <div>
                        <label class="form-label">Tanggal Mulai <span style="color:red">*</span></label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Tanggal Selesai <span style="color:red">*</span></label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}" required>
                    </div>
                </div>

                {{-- Instruksi --}}
                <div class="sec-title"><i class="fas fa-note-sticky"></i> Instruksi Minum Obat</div>
                <textarea name="deskripsi" rows="3" class="form-control"
                    placeholder="Contoh: diminum setelah makan, jangan dengan susu…">{{ old('deskripsi') }}</textarea>

                <div class="form-footer">
                    <a href="{{ route('dokter.jadwal.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        Lanjut Atur Waktu <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const allObats   = @json($obats->pluck('nama_obat'));
    const obatSatuan = @json($obats->pluck('satuan', 'nama_obat'));

    function getSelectedObats() {
        return [...document.querySelectorAll('.obat-select')]
            .map(s => s.value).filter(v => v !== '');
    }

    function syncObatOptions() {
        const selects = document.querySelectorAll('.obat-select');
        const selected = getSelectedObats();
        selects.forEach(select => {
            const currentVal = select.value;
            select.querySelectorAll('option').forEach(opt => {
                if (opt.value === '') return;
                opt.disabled = selected.includes(opt.value) && opt.value !== currentVal;
            });
        });
    }

    // ✅ Auto-set satuan berdasarkan obat yang dipilih
    function autoSetSatuan(selectEl) {
        const namaObat = selectEl.value;
        const row      = selectEl.closest('.obat-row');
        const satuan   = row.querySelector('select.satuan');
        if (!satuan || !namaObat) return;
        const unit = obatSatuan[namaObat];
        if (unit) satuan.value = unit;
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.obat-row');
        rows.forEach(row => {
            row.querySelector('.btn-remove-obat').style.visibility = rows.length > 1 ? 'visible' : 'hidden';
        });
    }

    function buildOptions(selectedVal = '') {
        const taken = getSelectedObats();
        let html = '<option value="">Pilih obat…</option>';
        allObats.forEach(nama => {
            const disabled = taken.includes(nama) && nama !== selectedVal ? 'disabled' : '';
            const sel = nama === selectedVal ? 'selected' : '';
            html += `<option value="${nama}" ${disabled} ${sel}>${nama}</option>`;
        });
        return html;
    }

    function addObat() {
        const row = document.createElement('div');
        row.className = 'obat-row';
        row.innerHTML = `
            <select name="obats[]" class="form-select obat-select" required
                    onchange="syncObatOptions(); autoSetSatuan(this)">
                ${buildOptions()}
            </select>
            <div class="qty-wrap">
                <input type="number" name="jumlah[]" min="1" value="1" required>
                <select name="satuan[]" class="satuan">
                    <option value="tablet">Tablet</option>
                    <option value="kapsul">Kapsul</option>
                    <option value="sirup">Sirup</option>
                    <option value="ml">ml</option>
                    <option value="tetes">Tetes</option>
                    <option value="sachet">Sachet</option>
                </select>
            </div>
            <button type="button" class="btn-remove-obat" onclick="removeObat(this)">
                <i class="fas fa-times"></i>
            </button>`;
        document.getElementById('obatList').appendChild(row);
        updateRemoveButtons();
        syncObatOptions();
    }

    function removeObat(btn) {
        if (document.querySelectorAll('.obat-row').length > 1) {
            btn.closest('.obat-row').remove();
            updateRemoveButtons();
            syncObatOptions();
        }
    }
</script>
@endpush
@endsection