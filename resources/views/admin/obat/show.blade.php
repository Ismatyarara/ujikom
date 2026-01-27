@extends('layouts.app')

@section('title', 'Detail Obat')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Obat</h4>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">

                <div class="text-center mb-4">
                    <img src="{{ $obat->foto_url }}" alt="{{ $obat->nama_obat }}" class="img-fluid rounded" style="max-width: 200px; object-fit:cover;">
                </div>

                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Kode Obat</th>
                            <td>{{ $obat->kode_obat }}</td>
                        </tr>
                        <tr>
                            <th>Nama Obat</th>
                            <td>{{ $obat->nama_obat }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Satuan</th>
                            <td>{{ $obat->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>{{ $obat->stok }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($obat->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Update</th>
                            <td>{{ $obat->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td style="white-space: pre-wrap; word-wrap: break-word;">{{ $obat->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th>Aturan Pakai</th>
                            <td style="white-space: pre-wrap; word-wrap: break-word;">{{ $obat->aturan_pakai }}</td>
                        </tr>
                        <tr>
                            <th>Efek Samping</th>
                            <td style="white-space: pre-wrap; word-wrap: break-word;">{{ $obat->efek_samping }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
