@extends('layouts.app')

@section('title', 'Data Barang Masuk')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h4 class="card-title mb-0">Data Barang Masuk</h4>
            <small class="text-muted">Riwayat penambahan stok obat</small>
          </div>
          <a href="{{ route('staff.barang-masuk.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Barang Masuk
          </a>
        </div>

        {{-- Alert --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        {{-- Table --}}
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Tanggal Masuk</th>
                <th>Kadaluwarsa</th>
                <th>Keterangan</th>
                <th>Dicatat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($barangMasuk as $key => $item)
              <tr>
                <td>{{ $barangMasuk->firstItem() + $key }}</td>

                <td>
                  <span class="badge bg-primary">{{ $item->kode }}</span>
                </td>

                <td>
                  <div class="fw-semibold">{{ $item->obat->nama_obat ?? '-' }}</div>
                  <small class="text-muted">{{ $item->obat->kode_obat ?? '' }}</small>
                </td>

                <td>
                  <span class="badge bg-success fs-6">
                    +{{ $item->jumlah }} {{ $item->obat->satuan ?? '' }}
                  </span>
                </td>

                <td>{{ $item->tanggal_masuk->format('d M Y') }}</td>

                <td>
                  @php
                    $selisih = now()->diffInDays($item->tanggal_kadaluwarsa, false);
                  @endphp
                  @if($selisih < 0)
                    <span class="badge bg-danger">
                      <i class="fas fa-exclamation-triangle me-1"></i>
                      Kadaluwarsa
                    </span>
                  @elseif($selisih <= 30)
                    <span class="badge bg-warning text-dark">
                      <i class="fas fa-clock me-1"></i>
                      {{ $item->tanggal_kadaluwarsa->format('d M Y') }}
                    </span>
                  @else
                    <span class="text-muted">{{ $item->tanggal_kadaluwarsa->format('d M Y') }}</span>
                  @endif
                </td>

                <td>
                  <span class="text-muted small">
                    {{ $item->deskripsi ? Str::limit($item->deskripsi, 30) : '-' }}
                  </span>
                </td>

                <td>
                  <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                </td>

                <td>
                  <a href="{{ route('staff.barang-masuk.show', $item->id) }}"
                     class="btn btn-info btn-sm" title="Detail">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('staff.barang-masuk.edit', $item->id) }}"
                     class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('staff.barang-masuk.destroy', $item->id) }}"
                        method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin hapus? Stok obat akan dikurangi kembali.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" class="text-center text-muted py-5">
                  <i class="fas fa-boxes fa-3x mb-3 d-block opacity-25"></i>
                  Belum ada data barang masuk
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3 d-flex justify-content-end">
          {{ $barangMasuk->links() }}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection