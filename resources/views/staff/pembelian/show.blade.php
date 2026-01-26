@extends('layouts.app')

@section('title', 'Detail Pembelian Obat')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Detail Pembelian Obat</h4>
        <a href="{{ route('staff.pembelian.index') }}" class="btn btn-secondary btn-sm">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Obat</th>
                    <td>{{ $pembelian->obat->nama_obat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Masuk</th>
                    <td>{{ $pembelian->jumlah }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembelian</th>
                    <td>
                        {{ \Carbon\Carbon::parse($pembelian->created_at)->format('d F Y') }}
                    </td>
                </tr>
            </table>

        </div>
    </div>

</div>
@endsection
