@extends('layouts.app')

@section('content')
<style>
.page-wrap {
    padding: 30px 40px;
}

.step {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.step span {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    background: #dbeafe;
    color: #1e3a8a;
}

.step .active span {
    background: #2563eb;
    color: #fff;
}

.card-custom {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    overflow: hidden;
}

.card-header-blue {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    padding: 25px;
}
.section-title {
    font-weight: 600;
    color: #2563eb;
    margin: 25px 0 10px;
}
</style>

<div class="page-wrap">

    <div class="step">
        <div class="active">
            <span>1</span>
            <div>Info Jadwal</div>
        </div>
        <div>
            <span>2</span>
            <div>Atur Waktu</div>
        </div>
    </div>

    <div class="card-custom">

        <div class="card-header-blue">
            <h5 class="mb-1">Tambah Jadwal Obat</h5>
            <small>Lengkapi informasi jadwal konsumsi pasien</small>
        </div>

        <div class="p-4">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dokter.jadwal.store') }}" method="POST">
                @csrf

                <div class="section-title">Pihak Terkait</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pasien *</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Pilih pasien</option>
                            @foreach($pasien as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dokter *</label>
                        <select name="dokter_id" class="form-select" required>
                            <option value="">Pilih dokter</option>
                            @foreach($dokters as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="section-title">Informasi Obat</div>
                <div class="mb-3">
                    <label class="form-label">Nama Obat *</label>
                    <select name="nama_obat" class="form-select" required>
                        <option value="">Pilih obat</option>
                        @foreach($obats as $o)
                            <option value="{{ $o->nama_obat }}">{{ $o->nama_obat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="section-title">Periode Konsumsi</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai *</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai *</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                <div class="section-title">Catatan</div>
                <div class="mb-3">
                    <textarea name="deskripsi" rows="3" class="form-control"
                        placeholder="Contoh: diminum setelah makan"></textarea>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-outline-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Lanjut Atur Waktu
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection