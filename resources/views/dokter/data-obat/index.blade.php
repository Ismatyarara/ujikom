@extends('layouts.app')

@section('content')
<style>
    .drug-wrap {
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 28%),
            linear-gradient(180deg, #f8fbff 0%, #f5f7fb 100%);
        min-height: 100vh;
        padding: 28px 0 48px;
    }
    .hero-card,
    .drug-card,
    .search-card {
        background: #fff;
        border: 1px solid #edf1f7;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(17, 24, 39, 0.06);
    }
    .hero-card {
        padding: 24px;
        margin-bottom: 18px;
    }
    .hero-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 8px;
    }
    .hero-copy {
        color: #6b7280;
        margin-bottom: 0;
    }
    .search-card {
        padding: 12px;
        margin-bottom: 18px;
    }
    .search-form {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    .search-input {
        flex: 1;
        min-width: 220px;
        border: none;
        outline: none;
        padding: 10px 12px;
        background: transparent;
        color: #111827;
    }
    .search-btn,
    .search-reset {
        border: none;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
    }
    .search-btn {
        background: #2563eb;
        color: #fff;
    }
    .search-reset {
        background: #eff6ff;
        color: #2563eb;
    }
    .result-copy {
        color: #64748b;
        font-size: 0.82rem;
        margin-bottom: 16px;
    }
    .drug-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
    }
    .drug-card {
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .drug-card:hover {
        transform: translateY(-3px);
        transition: 0.2s ease;
    }
    .drug-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: start;
    }
    .drug-name {
        font-size: 1rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 4px;
    }
    .drug-code {
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .stock-badge {
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .stock-good {
        background: #ecfdf5;
        color: #16a34a;
    }
    .stock-low {
        background: #fff7ed;
        color: #ea580c;
    }
    .drug-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .meta-box {
        background: #f8fafc;
        border-radius: 14px;
        padding: 10px 12px;
    }
    .meta-label {
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .meta-value {
        font-size: 0.92rem;
        color: #111827;
        font-weight: 700;
    }
    .drug-section {
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
    }
    .drug-section-title {
        font-size: 0.74rem;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .drug-section-copy {
        color: #334155;
        font-size: 0.84rem;
        line-height: 1.55;
        margin-bottom: 0;
    }
    .drug-price {
        color: #2563eb;
        font-weight: 800;
        font-size: 1rem;
    }
    .drug-actions {
        margin-top: auto;
    }
    .empty-card {
        text-align: center;
        padding: 48px 20px;
    }
</style>

<div class="drug-wrap">
    <div class="container">
        <div class="hero-card">
            <div class="hero-title">Data Obat</div>
            <p class="hero-copy">Referensi cepat obat untuk dokter, lengkap dengan stok, aturan pakai, dan efek samping.</p>
        </div>

        <div class="search-card">
            <form action="{{ route('dokter.data-obat.index') }}" method="GET" class="search-form">
                <i class="fas fa-search text-muted ps-2"></i>
                <input type="text"
                       name="search"
                       value="{{ $search ?? '' }}"
                       class="search-input"
                       placeholder="Cari nama obat, kode obat, aturan pakai, atau efek samping...">
                <button type="submit" class="search-btn">Cari</button>
                @if(!empty($search))
                    <a href="{{ route('dokter.data-obat.index') }}" class="search-reset">Reset</a>
                @endif
            </form>
        </div>

        @if(!empty($search))
            <div class="result-copy">
                Menampilkan hasil pencarian untuk: <strong>{{ $search }}</strong>
            </div>
        @endif

        <div class="drug-grid">
            @forelse($obat as $item)
                <div class="drug-card">
                    <div class="drug-top">
                        <div>
                            <div class="drug-name">{{ $item->nama_obat }}</div>
                            <div class="drug-code">{{ $item->kode_obat ?: 'Tanpa kode obat' }}</div>
                        </div>
                        <span class="stock-badge {{ $item->stok <= 10 ? 'stock-low' : 'stock-good' }}">
                            {{ $item->stok <= 10 ? 'Stok rendah' : 'Tersedia' }}
                        </span>
                    </div>

                    <div class="drug-meta">
                        <div class="meta-box">
                            <div class="meta-label">Stok</div>
                            <div class="meta-value">{{ $item->stok }} {{ $item->satuan }}</div>
                        </div>
                        <div class="meta-box">
                            <div class="meta-label">Harga</div>
                            <div class="meta-value drug-price">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="drug-section">
                        <div class="drug-section-title">Aturan Pakai</div>
                        <p class="drug-section-copy">{{ \Illuminate\Support\Str::limit($item->aturan_pakai ?: 'Belum ada aturan pakai.', 90) }}</p>
                    </div>

                    <div class="drug-section">
                        <div class="drug-section-title">Efek Samping</div>
                        <p class="drug-section-copy">{{ \Illuminate\Support\Str::limit($item->efek_samping ?: 'Belum ada informasi efek samping.', 90) }}</p>
                    </div>

                    <div class="drug-actions">
                        <a href="{{ route('dokter.data-obat.show', $item->id) }}" class="btn btn-outline-primary w-100">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="hero-card empty-card" style="grid-column: 1 / -1;">
                    <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                    <h5 class="text-dark">Data obat tidak ditemukan</h5>
                    <p class="text-muted mb-0">
                        {{ !empty($search) ? 'Coba gunakan kata kunci lain untuk pencarian obat.' : 'Belum ada data obat yang tersedia.' }}
                    </p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $obat->links() }}
        </div>
    </div>
</div>
@endsection
