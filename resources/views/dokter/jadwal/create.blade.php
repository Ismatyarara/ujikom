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
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-500: #64748b;
        --gray-700: #334155;
        --red-100: #fee2e2;
        --red-600: #dc2626;
        --green-50: #f0fdf4;
        --green-600: #16a34a;
    }

    .page-wrap { background: #f4f7ff; min-height: 100vh; padding: 32px 28px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--gray-500); font-size: 13px; text-decoration: none; margin-bottom: 20px; }
    .back-link:hover { color: var(--blue-600); }
    .form-card { background: #fff; border-radius: 16px; box-shadow: 0 6px 24px rgba(0,0,0,.07); overflow: hidden; }
    .card-head { background: linear-gradient(135deg, var(--blue-600), #1e40af); color: #fff; padding: 24px 28px; }
    .card-head h4 { margin: 0 0 4px; font-size: 18px; font-weight: 700; }
    .card-head p { margin: 0; font-size: 13px; opacity: .9; }
    .card-body { padding: 28px; }
    .catatan-banner { background: var(--blue-50); border: 1.5px solid var(--blue-100); border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; color: var(--blue-900); font-size: 13px; }
    .sec-title { font-size: 13px; font-weight: 700; color: var(--blue-900); text-transform: uppercase; letter-spacing: .05em; margin: 24px 0 14px; display: flex; align-items: center; gap: 8px; }
    .sec-title::after { content: ''; flex: 1; height: 1px; background: var(--blue-100); }
    .form-label { font-size: 13px; font-weight: 600; color: var(--gray-700); margin-bottom: 6px; display: block; }
    .form-control { border: 1.5px solid var(--gray-200); border-radius: 10px; padding: 10px 14px; font-size: 14px; width: 100%; box-sizing: border-box; }
    .form-control:focus { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(37,99,235,.12); outline: none; }
    .form-control.is-invalid { border-color: var(--red-600); box-shadow: 0 0 0 3px rgba(220,38,38,.08); }
    .locked-field { background: var(--gray-100); border: 1.5px solid var(--gray-200); border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--gray-700); }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .obat-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 10px; }
    .obat-row { display: flex; align-items: flex-start; gap: 8px; }
    .btn-remove-obat { width: 34px; height: 34px; border-radius: 8px; background: var(--red-100); color: var(--red-600); border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; margin-top: 2px; }
    .btn-add-obat { display: inline-flex; align-items: center; gap: 7px; background: var(--green-50); border: 1.5px dashed var(--green-600); color: var(--green-600); padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .form-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--gray-200); }
    .btn-back { display: inline-flex; align-items: center; gap: 7px; background: var(--gray-100); color: var(--gray-700); padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; }
    .btn-submit { display: inline-flex; align-items: center; gap: 7px; background: var(--blue-600); color: #fff; padding: 10px 22px; border-radius: 10px; border: none; font-size: 14px; font-weight: 600; cursor: pointer; }
    .alert-err { background: #fef2f2; border: 1px solid #fecaca; color: var(--red-600); border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; }
    .alert-err ul { margin: 6px 0 0 16px; padding: 0; }
    .obat-error { display: none; color: var(--red-600); font-size: 12px; margin-top: 6px; }
    .obat-error.show { display: block; }
    @media(max-width:640px) {
        .grid-2 { grid-template-columns: 1fr; }
        .form-footer { flex-direction: column; align-items: stretch; gap: 12px; }
    }
</style>

<div class="page-wrap">
    <a href="{{ route('dokter.jadwal.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Kembali ke Jadwal Obat
    </a>

    <div class="form-card">
        <div class="card-head">
            <h4><i class="fas fa-calendar-plus me-2"></i> Tambah Jadwal Obat</h4>
            <p>Cari obat dengan kode obat, lalu simpan jadwal tanpa langkah tambahan.</p>
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
                    <strong>Jadwal dibuat dari Catatan Medis</strong><br>
                    Pasien: <strong>{{ $catatan->user->name }}</strong>
                    | Diagnosa: <em>{{ $catatan->diagnosa }}</em>
                    | {{ \Carbon\Carbon::parse($catatan->tanggal_catatan)->format('d M Y') }}
                </div>
            @endif

            <form action="{{ route('dokter.jadwal.store') }}" method="POST" id="jadwalForm">
                @csrf
                <input type="hidden" name="catatan_id" value="{{ $catatan?->id }}">

                <div class="sec-title"><i class="fas fa-users"></i> Pihak Terkait</div>
                <div class="grid-2">
                    <div>
                        <label class="form-label">Pasien</label>
                        <input type="hidden" name="user_id" value="{{ $catatan ? $catatan->user_id : ($pasienSelected?->id ?? '') }}">
                        <div class="locked-field">{{ $catatan ? $catatan->user->name : ($pasienSelected?->name ?? '-') }}</div>
                    </div>
                    <div>
                        <label class="form-label">Dokter</label>
                        <div class="locked-field">{{ $dokter->nama }}</div>
                    </div>
                </div>

                <div class="sec-title"><i class="fas fa-pills"></i> Obat yang Diresepkan</div>
                <div class="obat-list" id="obatList">
                    <div class="obat-row">
                        <div style="flex:1">
                            <input type="text" class="form-control obat-input" list="obatOptions" placeholder="Ketik kode obat" onchange="syncObatCode(this)" autocomplete="off" required>
                            <input type="hidden" name="obats[]" value="">
                            <small style="color:#64748b" class="obat-help">Contoh: OBT001 - Paracetamol 500 mg</small>
                            <div class="obat-error">Obat yang sama sudah dipilih.</div>
                        </div>
                        <button type="button" class="btn-remove-obat" onclick="removeObat(this)" style="visibility:hidden">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <datalist id="obatOptions">
                    @foreach($obats as $o)
                        <option value="{{ $o->kode_obat }}" label="{{ $o->nama_obat }}"></option>
                    @endforeach
                </datalist>
                <button type="button" class="btn-add-obat" onclick="addObat()">
                    <i class="fas fa-plus"></i> Tambah Obat Lain
                </button>

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

                <div class="sec-title"><i class="fas fa-note-sticky"></i> Instruksi Minum Obat</div>
                <textarea name="deskripsi" rows="3" class="form-control" placeholder="Contoh: diminum setelah makan">{{ old('deskripsi') }}</textarea>

                <div class="form-footer">
                    <a href="{{ route('dokter.jadwal.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        Simpan Jadwal <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const obatMap = @json($obats->pluck('nama_obat', 'kode_obat'));

    function getSelectedObatCodes() {
        return Array.from(document.querySelectorAll('#obatList input[name="obats[]"]'))
            .map((input) => input.value.trim())
            .filter((value) => value !== '');
    }

    function validateDuplicateObat() {
        const rows = document.querySelectorAll('.obat-row');
        const usedCodes = [];

        rows.forEach((row) => {
            const textInput = row.querySelector('.obat-input');
            const hiddenInput = row.querySelector('input[name="obats[]"]');
            const errorText = row.querySelector('.obat-error');
            const code = hiddenInput.value.trim();

            textInput.setCustomValidity('');
            textInput.classList.remove('is-invalid');
            errorText.classList.remove('show');

            if (!code) {
                return;
            }

            if (usedCodes.includes(code)) {
                textInput.setCustomValidity('Obat yang sama tidak boleh dipilih dua kali.');
                textInput.classList.add('is-invalid');
                errorText.classList.add('show');
            } else {
                usedCodes.push(code);
            }
        });
    }

    function syncObatCode(input) {
        const row = input.closest('.obat-row');
        const hiddenInput = row.querySelector('input[name="obats[]"]');
        const helpText = row.querySelector('.obat-help');
        const code = (input.value || '').trim().toUpperCase();

        input.value = code;
        hiddenInput.value = '';
        helpText.textContent = 'Contoh: OBT001 - Paracetamol 500 mg';

        if (!code) {
            validateDuplicateObat();
            return;
        }

        if (!obatMap[code]) {
            input.setCustomValidity('Kode obat tidak ditemukan.');
            input.reportValidity();
            return;
        }

        input.setCustomValidity('');
        hiddenInput.value = code;
        helpText.textContent = code + ' - ' + obatMap[code];
        validateDuplicateObat();

        if (input.classList.contains('is-invalid')) {
            hiddenInput.value = '';
            input.value = '';
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
            row.querySelector('.obat-error').classList.remove('show');
            helpText.textContent = 'Contoh: OBT001 - Paracetamol 500 mg';
            alert('Obat yang sama tidak bisa dipilih dua kali.');
        }
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.obat-row');
        rows.forEach(row => {
            row.querySelector('.btn-remove-obat').style.visibility = rows.length > 1 ? 'visible' : 'hidden';
        });
    }

    function addObat() {
        const row = document.createElement('div');
        row.className = 'obat-row';
        row.innerHTML = `
            <div style="flex:1">
                <input type="text" class="form-control obat-input" list="obatOptions" placeholder="Ketik kode obat" onchange="syncObatCode(this)" autocomplete="off" required>
                <input type="hidden" name="obats[]" value="">
                <small style="color:#64748b" class="obat-help">Contoh: OBT001 - Paracetamol 500 mg</small>
                <div class="obat-error">Obat yang sama sudah dipilih.</div>
            </div>
            <button type="button" class="btn-remove-obat" onclick="removeObat(this)">
                <i class="fas fa-times"></i>
            </button>`;
        document.getElementById('obatList').appendChild(row);
        updateRemoveButtons();
        validateDuplicateObat();
    }

    function removeObat(btn) {
        if (document.querySelectorAll('.obat-row').length > 1) {
            btn.closest('.obat-row').remove();
            updateRemoveButtons();
            validateDuplicateObat();
        }
    }

    document.getElementById('jadwalForm').addEventListener('submit', function (event) {
        validateDuplicateObat();

        const duplicateField = document.querySelector('.obat-input:invalid');
        if (duplicateField) {
            event.preventDefault();
            duplicateField.reportValidity();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        updateRemoveButtons();
        validateDuplicateObat();
    });
</script>
@endpush
@endsection
