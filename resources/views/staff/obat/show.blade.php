@extends('layouts.app')

@section('title', 'Detail Obat')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Detail Obat</h4>
                    <a href="{{ route('staff.obat.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                {{-- Obat Detail --}}
                <div class="text-center mb-4">
                    <img src="{{ $obat->foto_url }}" alt="{{ $obat->nama_obat }}" 
                         class="img-fluid rounded" style="max-width:200px; object-fit:cover">
                </div>

                <table class="table table-borderless">
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
                            <td>
                                @if($obat->stok > 10)
                                    <span class="badge bg-success">{{ $obat->stok }}</span>
                                @elseif($obat->stok > 0)
                                    <span class="badge bg-warning text-dark">{{ $obat->stok }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
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
                            <th>Dibuat</th>
                            <td>{{ $obat->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $obat->updated_at->diffForHumans() }}</td>
                        </tr>
                    </tbody>
                </table>

                {{-- Aksi --}}
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('staff.obat.edit', $obat->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('staff.obat.destroy', $obat->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
