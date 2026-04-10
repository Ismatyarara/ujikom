@extends('layouts.app')

@section('title', 'Dashboard Staff')

@section('content')
<style>
  .staff-hero {
    margin-bottom: 20px;
  }
  .staff-hero-title {
    font-weight: 800;
    color: #111827;
    margin-bottom: 6px;
  }
  .staff-card {
    border: 1px solid #edf1f7;
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
  }
  .quick-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
  }
  .quick-link {
    display: block;
    padding: 16px 18px;
    border: 1px solid #dbe7f5;
    border-radius: 16px;
    text-decoration: none;
    background: #f8fbff;
    transition: 0.2s ease;
  }
  .quick-link:hover {
    text-decoration: none;
    transform: translateY(-2px);
    border-color: #93c5fd;
  }
  .quick-link strong {
    display: block;
    color: #111827;
    margin-bottom: 4px;
  }
  .quick-link span {
    color: #6b7280;
    font-size: 0.84rem;
  }
</style>

<div class="row">
  <div class="col-12 staff-hero">
    <h3 class="staff-hero-title">Selamat Datang, {{ auth()->user()->name }}!</h3>
    <p class="text-muted">Pantau stok obat, transaksi, dan pesanan user dari satu dashboard.</p>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row">
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="card-title text-md-left text-xl-left">Total Obat</p>
            <h2 class="mb-0">{{ $totalObat }}</h2>
          </div>
          <div class="text-primary">
            <i class="fas fa-pills fa-3x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="card-title text-md-left text-xl-left">Stok Rendah</p>
            <h2 class="mb-0 text-warning">{{ $obatStokRendah }}</h2>
          </div>
          <div class="text-warning">
            <i class="fas fa-exclamation-triangle fa-3x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="card-title text-md-left text-xl-left">Barang Masuk</p>
            <h2 class="mb-0 text-success">{{ $barangMasukBulanIni }}</h2>
            <small class="text-muted">Bulan ini</small>
          </div>
          <div class="text-success">
            <i class="fas fa-truck-loading fa-3x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="card-title text-md-left text-xl-left">Barang Keluar</p>
            <h2 class="mb-0 text-danger">{{ $barangKeluarBulanIni }}</h2>
            <small class="text-muted">Bulan ini</small>
          </div>
          <div class="text-danger">
            <i class="fas fa-box-open fa-3x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="card-title text-md-left text-xl-left">Total Pesanan</p>
            <h2 class="mb-0 text-primary">{{ $totalPesananUser }}</h2>
          </div>
          <div class="text-primary">
            <i class="fas fa-receipt fa-3x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="card-title text-md-left text-xl-left">Pesanan Pending</p>
            <h2 class="mb-0 text-warning">{{ $pesananPending }}</h2>
          </div>
          <div class="text-warning">
            <i class="fas fa-hourglass-half fa-3x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="card-title text-md-left text-xl-left">Pesanan Dibayar</p>
            <h2 class="mb-0 text-success">{{ $pesananDibayar }}</h2>
          </div>
          <div class="text-success">
            <i class="fas fa-check-circle fa-3x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart & Top Products -->
<div class="row">
  <!-- Chart -->
  <div class="col-md-8 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <h4 class="card-title">Barang Masuk vs Keluar (6 Bulan Terakhir)</h4>
        <canvas id="barangChart"></canvas>
      </div>
    </div>
  </div>
  
  <!-- Obat Terlaris -->
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <h4 class="card-title">Obat Terlaris</h4>
        <div class="list-group list-group-flush">
          @forelse($obatTerlaris as $item)
          <div class="list-group-item d-flex justify-content-between align-items-center px-0">
            <div>
              <strong>{{ $item->obat->nama_obat }}</strong>
              <br>
              <small class="text-muted">{{ $item->obat->kode }}</small>
            </div>
            <span class="badge badge-primary badge-pill">{{ $item->total_terjual }}</span>
          </div>
          @empty
          <p class="text-muted text-center py-3">Belum ada data</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="card-title mb-0">Pesanan User Terbaru</h4>
          <a href="{{ route('staff.pembelian.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Kode</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pesananTerbaru as $item)
              <tr>
                <td><span class="badge badge-primary">{{ $item->kode_transaksi }}</span></td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td><span class="badge badge-info text-capitalize">{{ $item->status }}</span></td>
                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted">Belum ada pesanan user</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <h4 class="card-title">Aksi Cepat</h4>
        <div class="quick-grid">
          <a href="{{ route('staff.obat.index') }}" class="quick-link">
            <strong>Data Obat</strong>
            <span>Lihat stok dan status obat.</span>
          </a>
          <a href="{{ route('staff.barang-masuk.index') }}" class="quick-link">
            <strong>Barang Masuk</strong>
            <span>Kelola obat yang baru datang.</span>
          </a>
          <a href="{{ route('staff.barang-keluar.index') }}" class="quick-link">
            <strong>Barang Keluar</strong>
            <span>Lihat obat yang sudah keluar.</span>
          </a>
          <a href="{{ route('staff.pembelian.index') }}" class="quick-link">
            <strong>Pesanan User</strong>
            <span>Periksa status pesanan pembelian.</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Transaksi Terakhir -->
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card staff-card">
      <div class="card-body">
        <h4 class="card-title">Transaksi Terakhir</h4>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Kode</th>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transaksiTerakhir as $item)
              <tr>
                <td><span class="badge badge-info">{{ $item->kode }}</span></td>
                <td>{{ $item->obat->nama_obat }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}</td>
                <td>
                  <a href="{{ route('staff.barang-keluar.show', $item->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted">Belum ada transaksi</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('barangChart').getContext('2d');
const chartData = @json($chartData);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.map(item => item.month),
        datasets: [
            {
                label: 'Barang Masuk',
                data: chartData.map(item => item.masuk),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
            },
            {
                label: 'Barang Keluar',
                data: chartData.map(item => item.keluar),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush
@endsection
