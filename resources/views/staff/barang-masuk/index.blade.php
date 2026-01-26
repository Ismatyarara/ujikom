@extends('layouts.app')

@section('title', 'Data Barang Masuk')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">Data Barang Masuk</h4>
                            <p class="text-muted mb-0">Kelola data barang masuk obat</p>
                        </div>
                        <a href="{{ route('staff.barang-masuk.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah Barang Masuk
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-alert-circle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Filter & Search -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('staff.barang-masuk.index') }}" method="GET" class="form-inline">
                                <div class="input-group" style="width: 100%;">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari kode atau nama obat..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="mdi mdi-magnify"></i>
                                        </button>
                                        @if (request('search'))
                                            <a href="{{ route('staff.barang-masuk.index') }}" class="btn btn-secondary">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                    data-toggle="dropdown">
                                    <i class="mdi mdi-filter-variant"></i> Filter Tanggal
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?filter=today">Hari Ini</a>
                                    <a class="dropdown-item" href="?filter=week">Minggu Ini</a>
                                    <a class="dropdown-item" href="?filter=month">Bulan Ini</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('staff.barang-masuk.index') }}">Semua Data</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Card -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card bg-gradient-primary text-white">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-white text-primary mr-3">
                                            <i class="mdi mdi-package-variant"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-white">Total Transaksi</h6>
                                            <h4 class="mb-0 text-white font-weight-bold">{{ $barangMasuk->total() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-gradient-success text-white">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-white text-success mr-3">
                                            <i class="mdi mdi-calendar-today"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-white">Bulan Ini</h6>
                                            <h4 class="mb-0 text-white font-weight-bold">
                                                {{ \App\Models\BarangMasuk::whereMonth('tanggal_masuk', date('m'))->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-gradient-info text-white">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-white text-info mr-3">
                                            <i class="mdi mdi-counter"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-white">Total Item Masuk</h6>
                                            <h4 class="mb-0 text-white font-weight-bold">
                                                {{ number_format($barangMasuk->sum('jumlah')) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Kode</th>
                                    <th width="25%">Nama Obat</th>
                                    <th width="10%" class="text-center">Jumlah</th>
                                    <th width="15%">Tanggal Masuk</th>
                                    <th width="15%">Kadaluwarsa</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangMasuk as $item)
                                    <tr>
                                        <td>{{ $barangMasuk->firstItem() + $loop->index }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $item->kode }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($item->obat->foto)
                                                    <img src="{{ $item->obat->foto_url }}"
                                                        alt="{{ $item->obat->nama_obat }}" class="rounded mr-2"
                                                        style="width: 35px; height: 35px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <span class="font-weight-bold">{{ $item->obat->nama_obat }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ $item->obat->kode }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-success badge-pill px-3 py-2">{{ number_format($item->jumlah) }}</span>
                                        </td>
                                        <td>
                                            <i class="mdi mdi-calendar text-muted"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}
                                        </td>
                                        <td>
                                            @php
                                                $kadaluwarsa = \Carbon\Carbon::parse($item->tanggal_kadaluwarsa);
                                                $selisihHari = $kadaluwarsa->diffInDays(now());
                                            @endphp

                                            @if ($kadaluwarsa->isPast())
                                                <span class="badge badge-danger">
                                                    <i class="mdi mdi-alert"></i> Kadaluwarsa
                                                </span>
                                            @elseif($selisihHari <= 30)
                                                <span class="badge badge-warning">
                                                    <i class="mdi mdi-clock-alert"></i>
                                                    {{ $kadaluwarsa->format('d M Y') }}
                                                </span>
                                            @else
                                                <span class="badge badge-info">
                                                    {{ $kadaluwarsa->format('d M Y') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('staff.barang-keluar.show', $item->id) }}"
                                                    class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('staff.barang-keluar.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('staff.barang-keluar.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus? Stok obat akan dikembalikan.')"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <img src="{{ asset('images/empty-state.svg') }}" alt="No Data"
                                                style="width: 150px; opacity: 0.5;">
                                            <p class="text-muted mt-3">Belum ada data barang masuk</p>
                                            <a href="{{ route('staff.barang-masuk.create') }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="mdi mdi-plus"></i> Tambah Barang Masuk
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $barangMasuk->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .icon-circle {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .bg-gradient-success {
                background: linear-gradient(135deg, #37b66e 0%, #2da35f 100%);
            }

            .bg-gradient-info {
                background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
            }

            .table td {
                vertical-align: middle;
            }

            .aksi-btn .btn {
                border-radius: 6px !important;
                margin: 0 2px;
            }

            .aksi-btn form {
                display: inline-block;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm('Apakah Anda yakin ingin menghapus data barang masuk ini? Stok obat akan dikurangi.')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }
        </script>
    @endpush
@endsection
