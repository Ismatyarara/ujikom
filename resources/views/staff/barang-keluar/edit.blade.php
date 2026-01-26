@extends('layouts.app')

@section('title', 'Edit Barang Keluar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Barang Keluar</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Barang Keluar</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Perhatian!</strong> Mengubah data barang keluar akan mengembalikan stok obat lama dan mengurangi stok obat baru.
            </div>

            <form action="{{ route('staff.barang-keluar.update', $barangKeluar->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Transaksi</label>
                            <input type="text" class="form-control" value="{{ $barangKeluar->kode }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Obat Sebelumnya</label>
                            <input type="text" 
                                   class="form-control bg-light" 
                                   value="{{ $barangKeluar->obat->nama_obat }} ({{ $barangKeluar->jumlah }} {{ $barangKeluar->obat->satuan }})" 
                                   readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_obat">Pilih Obat <span class="text-danger">*</span></label>
                    <select name="id_obat" id="id_obat" class="form-control @error('id_obat') is-invalid @enderror" required>
                        <option value="">-- Pilih Obat --</option>
                        @foreach($obat as $item)
                            @php
                                // Hitung stok tersedia (stok saat ini + jumlah lama jika obat yang sama)
                                $stokTersedia = $item->stok;
                                if($item->id == $barangKeluar->id_obat) {
                                    $stokTersedia += $barangKeluar->jumlah;
                                }
                            @endphp
                            <option value="{{ $item->id }}" 
                                    data-stok="{{ $stokTersedia }}"
                                    data-satuan="{{ $item->satuan }}"
                                    {{ old('id_obat', $barangKeluar->id_obat) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_obat }} (Stok: {{ $stokTersedia }} {{ $item->satuan }})
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
                           value="{{ old('jumlah', $barangKeluar->jumlah) }}"
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
                           value="{{ old('tanggal_keluar', $barangKeluar->tanggal_keluar) }}"
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
                              placeholder="Keterangan tambahan (opsional)">{{ old('deskripsi', $barangKeluar->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
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

        // Fungsi untuk update info stok
        function updateStokInfo() {
            const selectedOption = $('#id_obat').find('option:selected');
            const stok = selectedOption.data('stok');
            const satuan = selectedOption.data('satuan');
            
            if (stok !== undefined) {
                $('#stok-info').html(`<strong>Stok tersedia: ${stok} ${satuan}</strong>`);
                $('#jumlah').attr('max', stok);
            } else {
                $('#stok-info').html('');
                $('#jumlah').removeAttr('max');
            }
        }

        // Tampilkan info stok saat halaman load
        updateStokInfo();

        // Tampilkan info stok saat obat dipilih
        $('#id_obat').on('change', function() {
            updateStokInfo();
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