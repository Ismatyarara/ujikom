@extends('layouts.app')

@section('title', 'Data Dokter')

@section('content')
<style>
  .doctor-page {
    background:
      radial-gradient(circle at top right, rgba(79, 110, 247, 0.08), transparent 28%),
      linear-gradient(180deg, #f8f9ff 0%, #f4f6fb 100%);
    min-height: 100vh;
    padding: 28px 0 48px;
  }
  .doctor-card {
    border: 1px solid #edf1f7;
    border-radius: 22px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    overflow: hidden;
  }
  .doctor-card .card-header {
    background: #fff;
    padding: 18px 24px;
    border-bottom: 1px solid #eef2f7;
  }
  .doctor-card .card-body {
    padding: 24px;
    background: #fff;
  }
  .doctor-table {
    margin-bottom: 0;
    min-width: 1080px;
  }
  .doctor-table thead th {
    background: #f8fafc;
    color: #0f172a;
    font-weight: 700;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
    vertical-align: middle;
    padding: 14px 16px;
  }
  .doctor-table tbody td {
    vertical-align: middle;
    padding: 16px;
    border-color: #eef2f7;
  }
  .doctor-row:hover {
    background: #fafcff;
  }
  .doctor-avatar {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #f1f5f9;
  }
  .doctor-avatar-placeholder {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #eff4ff;
    color: #4f46e5;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
  }
  .doctor-name {
    font-weight: 700;
    color: #111827;
    margin-bottom: 2px;
  }
  .doctor-email,
  .doctor-subtext {
    font-size: 0.82rem;
    color: #64748b;
  }
  .doctor-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 0.76rem;
    font-weight: 700;
    background: #eff6ff;
    color: #2563eb;
  }
  .doctor-badge.success {
    background: #ecfdf3;
    color: #15803d;
  }
  .doctor-badge.warning {
    background: #fff7ed;
    color: #c2410c;
  }
  .doctor-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: stretch;
    min-width: 142px;
  }
  .doctor-action-row {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
  }
  .doctor-verify-form {
    margin: 0;
    width: 100%;
  }
  .doctor-verify-btn {
    width: 100%;
    border-radius: 10px;
    font-weight: 600;
  }
  .doctor-action-btn {
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-decoration: none;
  }
  .doctor-action-btn.view { background: #3b82f6; }
  .doctor-action-btn.edit { background: #f59e0b; }
  .doctor-action-btn.delete { background: #ef4444; }
  .doctor-table td.action-cell,
  .doctor-table th.action-cell {
    text-align: center;
  }
  .doctor-empty {
    text-align: center;
    padding: 40px 20px;
    color: #64748b;
  }
</style>

<div class="doctor-page">
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card doctor-card">

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
            <table class="table doctor-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Foto</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Spesialisasi</th>
                  <th>Pengalaman</th>
                  <th>Tempat Praktik</th>
                  <th>Jadwal</th>
                  <th>Verifikasi</th>
                  <th class="action-cell">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($dokters as $i => $dokter)
                  <tr class="doctor-row">
                    <td class="fw-semibold">{{ $dokters->firstItem() + $i }}</td>
                    <td>
                      @if($dokter->foto)
                        <img src="{{ asset('storage/'.$dokter->foto) }}"
                             class="doctor-avatar"
                             alt="{{ $dokter->nama }}">
                      @else
                        <span class="doctor-avatar-placeholder">
                          <i class="fas fa-user-md"></i>
                        </span>
                      @endif
                    </td>
                    <td>
                      <div class="doctor-name">{{ $dokter->nama }}</div>
                      <div class="doctor-subtext">ID Dokter #{{ $dokter->id }}</div>
                    </td>
                    <td>
                      <div class="doctor-email">{{ $dokter->pengguna->email ?? '-' }}</div>
                    </td>
                    <td>
                      <span class="doctor-badge">{{ $dokter->spesialisasi->name ?? '-' }}</span>
                    </td>
                    <td>
                      <div class="doctor-subtext">
                        {{ Str::limit($dokter->pengalaman ?? '-', 50) }}
                      </div>
                    </td>
                    <td>
                      <div class="doctor-subtext">{{ $dokter->tempat_praktik }}</div>
                    </td>
                    <td>
                      <div class="doctor-subtext">
                        {{ $dokter->jadwal_praktik_hari }} <br>
                        {{ $dokter->jadwal_praktik_waktu }}
                      </div>
                    </td>
                    <td>
                      @if($dokter->is_verified)
                        <span class="doctor-badge success">Terverifikasi</span>
                      @else
                        <span class="doctor-badge warning">Belum Verifikasi</span>
                      @endif
                    </td>
                    <td class="action-cell">
                      <div class="doctor-actions">
                        <div class="doctor-action-row">
                          <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="doctor-action-btn view" title="Lihat">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="doctor-action-btn edit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>
                          <button class="doctor-action-btn delete"
                            onclick="confirmDelete({{ $dokter->id }})" title="Hapus">
                            <i class="fas fa-trash"></i>
                          </button>
                        </div>
                        @if($dokter->is_verified)
                          <form action="{{ route('admin.dokter.unverify', $dokter->id) }}" method="POST" class="doctor-verify-form">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-warning doctor-verify-btn">Batalkan Verifikasi</button>
                          </form>
                        @else
                          <form action="{{ route('admin.dokter.verify', $dokter->id) }}" method="POST" class="doctor-verify-form">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success doctor-verify-btn">Verifikasi</button>
                          </form>
                        @endif
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
                    <td colspan="10" class="doctor-empty">Tidak ada data dokter</td>
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
</div>

<script>
function confirmDelete(id) {
  if (confirm('Yakin hapus data ini?')) {
    document.getElementById('delete-form-' + id).submit();
  } 
}
</script>
@endsection
