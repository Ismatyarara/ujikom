@extends('layouts.app')

@section('title', 'Detail Barang Keluar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Barang Keluar</h1>
        <a href="{{ route('staff.barang-keluar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Barang Keluar</h6>
                    <div>
                        <a href="{{ route('staff.barang-keluar.edit', $barangKeluar->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('staff.barang-keluar.destroy', $barangKeluar->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data ini? Stok obat akan dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="font-weight-bold">Kode Transaksi</td>
                            <td width="5%">:</td>
                            <td>
                                <span class="badge badge-primary badge-lg">{{ $barangKeluar->kode }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Nama Obat</td>
                            <td>:</td>
                            <td>{{ $barangKeluar->obat->nama_obat }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Jumlah Keluar</td>
                            <td>:</td>
                            <td>
                                <strong class="text-danger">{{ $barangKeluar->jumlah }} {{ $barangKeluar->obat->satuan }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Keluar</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($barangKeluar->tanggal_keluar)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Deskripsi</td>
                            <td>:</td>
                            <td>{{ $barangKeluar->deskripsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Dibuat</td>
                            <td>:</td>
                            <td>{{ $barangKeluar->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Terakhir Diupdate</td>
                            <td>:</td>
                            <td>{{ $barangKeluar->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Obat</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td class="font-weight-bold">Kode Obat</td>
                            <td>:</td>
                            <td>{{ $barangKeluar->obat->kode_obat }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Stok Saat Ini</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-{{ $barangKeluar->obat->stok > 10 ? 'success' : ($barangKeluar->obat->stok > 0 ? 'warning' : 'danger') }}">
                                    {{ $barangKeluar->obat->stok }} {{ $barangKeluar->obat->satuan }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Harga</td>
                            <td>:</td>
                            <td>Rp {{ number_format($barangKeluar->obat->harga, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    <hr>

                    <div class="alert alert-info mb-0">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            <strong>Catatan:</strong><br>
                            Stok obat telah dikurangi sebanyak {{ $barangKeluar->jumlah }} {{ $barangKeluar->obat->satuan }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection