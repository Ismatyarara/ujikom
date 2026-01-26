@extends('layouts.app')

@section('title', 'Data Dokter')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="card-title mb-0">Data Dokter</h4>
          <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Dokter
          </a>
        </div>
        
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Spesialisasi</th>
                <th>Email</th>
                <th>Jadwal Praktik</th>
                <th>Tempat Praktik</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($dokters as $key => $item)
              <tr>
                <td>{{ $dokters->firstItem() + $key }}</td>
                <td>
                  <img src="{{ $item->foto_url }}" alt="Foto" class="rounded-circle" width="40" height="40">
                </td>
                <td>
                  <div>
                    <strong>{{ $item->nama }}</strong>
                    <br>
                    <small class="text-muted">{{ $item->pengguna->name ?? '-' }}</small>
                  </div>
                </td>
                <td>
                  <span class="badge badge-info">{{ $item->spesialisasi->name ?? '-' }}</span>
                </td>
                <td>{{ $item->pengguna->email ?? '-' }}</td>
                <td>
                  <small>
                    <i class="fas fa-calendar"></i> {{ $item->jadwal_praktik_hari }}<br>
                    <i class="fas fa-clock"></i> {{ $item->jadwal_praktik_waktu }}
                  </small>
                </td>
                <td>{{ Str::limit($item->tempat_praktik, 25) }}</td>
                <td>
                  <a href="{{ route('admin.dokter.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.dokter.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.dokter.destroy', $item->id) }}" method="POST" class="d-inline" 
                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                <td colspan="8" class="text-center py-4">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted">Belum ada data dokter</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-3">
          {{ $dokters->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection