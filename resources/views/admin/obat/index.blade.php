@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Data Obat</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Foto</th>
                                <th>Nama Obat</th>
                                <th>Harga</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Ditambahkan</th>
                                <th>Diubah</th>
                                <th>Oleh</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obat as $key => $item)
                                <tr>
                                    <td>{{ $obat->firstItem() + $key }}</td>
                                    <td>{{ $item->kode_obat }}</td>
                                    <td>
                                        <img src="{{ $item->foto_url }}"
                                             class="img-thumbnail"
                                             width="50"
                                             height="50"
                                             style="object-fit: cover"
                                             alt="{{ $item->nama_obat }}">
                                    </td>
                                    <td>{{ $item->nama_obat }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->satuan ?? '-' }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $item->is_aktif ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $item->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.obat.show', $item->id) }}"
                                           class="btn btn-info btn-sm"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center text-muted py-5">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada data obat
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $obat->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection