@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="card-title mb-0">Data User</h4>
          <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah User
          </a>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $key => $item)
              <tr>
                <td>{{ $users->firstItem() + $key }}</td>
                <td>
                  <strong>{{ $item->name }}</strong>
                </td>
                <td>{{ $item->email }}</td>
                <td>
                  @if($item->status == 'aktif')
                    <span class="badge badge-success">Aktif</span>
                  @else
                    <span class="badge badge-secondary">Nonaktif</span>
                  @endif
                </td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                  <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="d-inline" 
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
                <td colspan="6" class="text-center py-4">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted">Belum ada data user</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <div class="mt-3">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection