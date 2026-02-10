@extends('layouts.app')

@section('title', 'Detail Dokter')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Detail Dokter</h4>
                <small>Informasi lengkap dokter</small>
            </div>

            <div class="card-body">
                <div class="row">

                    {{-- FOTO --}}
                    <div class="col-md-3 text-center mb-4">
                        @if ($dokter->foto)
                            <img src="{{ asset('storage/' . $dokter->foto) }}" class="img-fluid rounded"
                                alt="{{ $dokter->nama }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                style="height:260px">
                                <i class="fas fa-user-md fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tr>
                                <th width="180">Nama</th>
                                <td>: {{ $dokter->nama }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: {{ $dokter->pengguna->email }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Spesialisasi</td>
                                <td><span class="badge badge-info">{{ $dokter->spesialisasi->name ?? '-' }}</span></td>
                            </tr>
                            <tr>
                                <th>Tempat Praktik</th>
                                <td>: {{ $dokter->tempat_praktik }}</td>
                            </tr>
                            <tr>
                                <th>Pengalaman</th>
                                <td>: {{ $dokter->pengalaman ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Hari Praktik</th>
                                <td>: <span class="badge badge-primary">{{ $dokter->jadwal_praktik_hari }}</span></td>
                            </tr>
                            <tr>
                                <th>Waktu Praktik</th>
                                <td>: <span class="badge badge-success">{{ $dokter->jadwal_praktik_waktu }}</span></td>
                            </tr>
                            <tr>
                                <th>Status Akun</th>
                                <td>:
                                    @if ($dokter->pengguna->email_verified_at)
                                        <span class="badge badge-success">Terverifikasi</span>
                                    @else
                                        <span class="badge badge-warning">Belum Verifikasi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Terdaftar</th>
                                <td>: {{ $dokter->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Update Terakhir</th>
                                <td>: {{ $dokter->updated_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- BUTTON --}}
                <hr>
                <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-warning">
                    Edit
                </a>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button class="btn btn-danger float-right" onclick="hapus({{ $dokter->id }})">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <form id="delete-{{ $dokter->id }}" action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" hidden>
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        function hapus(id) {
            if (confirm('Yakin hapus dokter ini?')) {
                document.getElementById('delete-' + id).submit();
            }
        }
    </script>
@endpush
