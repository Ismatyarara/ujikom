@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang Keluar</h1>
        <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Barang Keluar</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('staff.barang-keluar.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="id_obat">Pilih Obat <span class="text-danger">*</span></label>
                    <select name="id_obat" id="id_obat" class="form-control @error('id_obat') is-invalid @enderror" required>
                        <option value="">-- Pilih Obat --</option>
                        @foreach($obat as $item)
                            <option value="{{ $item->id }}" 
                                    data-stok="{{ $item->stok }}"
                                    data-satuan="{{ $item->satuan }}"
                                    {{ old('id_obat') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_obat }} (Stok: {{ $item->stok }} {{ $item->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_obat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="stok-info" class="form-text text-muted"></small>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" 
                           name="jumlah" 
                           id="jumlah" 
                           class="form-control @error('jumlah') is-invalid @enderror" 
                           value="{{ old('jumlah') }}"
                           min="1"
                           placeholder="Masukkan jumlah"
                           required>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_keluar">Tanggal Keluar <span class="text-danger">*</span></label>
                    <input type="date" 
                           name="tanggal_keluar" 
                           id="tanggal_keluar" 
                           class="form-control @error('tanggal_keluar') is-invalid @enderror" 
                           value="{{ old('tanggal_keluar', date('Y-m-d')) }}"
                           required>
                    @error('tanggal_keluar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="3"
                              placeholder="Keterangan tambahan (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Select2 untuk dropdown obat
        $('#id_obat').select2({
            placeholder: '-- Pilih Obat --',
            allowClear: true
        });

        // Tampilkan info stok saat obat dipilih
        $('#id_obat').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const stok = selectedOption.data('stok');
            const satuan = selectedOption.data('satuan');
            
            if (stok !== undefined) {
                $('#stok-info').html(`<strong>Stok tersedia: ${stok} ${satuan}</strong>`);
                $('#jumlah').attr('max', stok);
            } else {
                $('#stok-info').html('');
                $('#jumlah').removeAttr('max');
            }
        });

        // Validasi jumlah tidak melebihi stok
        $('#jumlah').on('input', function() {
            const max = parseInt($(this).attr('max'));
            const value = parseInt($(this).val());
            
            if (max && value > max) {
                $(this).addClass('is-invalid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after(`<div class="invalid-feedback">Jumlah tidak boleh melebihi stok yang tersedia (${max})</div>`);
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });
    });
</script>
@endpush