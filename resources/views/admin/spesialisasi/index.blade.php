@extends('layouts.app')

@section('title', 'Data Spesialisasi')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="card-title mb-0">Data Spesialisasi</h4>
          <a href="{{ route('admin.spesialisasi.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Spesialisasi
          </a>
        </div>
        
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Spesialisasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($spesialisasis as $key => $item)
              <tr>
                <td>{{ $spesialisasis->firstItem() + $key }}</td>
                <td>
                  <strong>{{ $item->name }}</strong>
                </td>
                <td>
                  <a href="{{ route('admin.spesialisasi.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.spesialisasi.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.spesialisasi.destroy', $item->id) }}" method="POST" class="d-inline" 
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
                <td colspan="4" class="text-center py-4">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted">Belum ada data spesialisasi</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-3">
          {{ $spesialisasis->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection