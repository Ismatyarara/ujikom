@extends('layouts.app')

@section('title', 'Data Dokter')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Data Dokter</h4>
          <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Dokter
          </a>
        </div>

        <div class="card-body">

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Foto</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Spesialisasi</th>
                  <th>Tempat Praktik</th>
                  <th>Jadwal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($dokters as $i => $dokter)
                  <tr>
                    <td>{{ $dokters->firstItem() + $i }}</td>
                    <td>
                      <img src="{{ $dokter->foto ? asset('storage/'.$dokter->foto) : asset('images/default-avatar.png') }}"
                           class="img-thumbnail"
                           style="max-width:70px">
                    </td>
                    <td>{{ $dokter->nama }}</td>
                    <td>{{ $dokter->pengguna->email ?? '-' }}</td>
                    <td>{{ $dokter->spesialisasi->name ?? '-' }}</td>
                    <td>{{ $dokter->tempat_praktik }}</td>
                    <td>
                      <small>
                        {{ $dokter->jadwal_praktik_hari }} <br>
                        {{ $dokter->jadwal_praktik_waktu }}
                      </small>
                    </td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-info">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-warning">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger"
                          onclick="confirmDelete({{ $dokter->id }})">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>

                      <form id="delete-form-{{ $dokter->id }}"
                            action="{{ route('admin.dokter.destroy', $dokter->id) }}"
                            method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center">Tidak ada data dokter</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{ $dokters->links() }}

        </div>
      </div>
    </div>
  </div>
</div>

<script>
function confirmDelete(id) {
  if (confirm('Yakin hapus data ini?')) {
    document.getElementById('delete-form-' + id).submit();
  }
}
</script>
@endsection
