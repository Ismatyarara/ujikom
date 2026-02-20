@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.wrap{
    background:#f4f7ff;
    padding:40px 20px;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}
.top h2{
    font-size:20px;
    color:#1e3a8a;
}
.btn-add{
    background:#2563eb;
    color:#fff;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
}
.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}
table{
    width:100%;
    border-collapse:collapse;
}
th, td{
    padding:10px;
    text-align:left;
    font-size:14px;
}
th{
    background:#eff6ff;
    color:#1e3a8a;
}
tr:not(:last-child){
    border-bottom:1px solid #eee;
}
.status{
    padding:4px 8px;
    border-radius:6px;
    font-size:12px;
}
.active{
    background:#dcfce7;
    color:#166534;
}
.nonaktif{
    background:#fee2e2;
    color:#991b1b;
}
.action{
    display:flex;
    align-items:center;
    gap:6px;
}
.action a,
.action button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:32px;
    height:32px;
    border-radius:8px;
    border:none;
    cursor:pointer;
    font-size:14px;
    text-decoration:none;
    transition:opacity .2s;
}
.action a:hover,
.action button:hover{
    opacity:.8;
}
.btn-detail{
    background:#eff6ff;
    color:#2563eb;
}
.btn-edit{
    background:#fefce8;
    color:#ca8a04;
}
.btn-hapus{
    background:#fee2e2;
    color:#dc2626;
}
.empty{
    text-align:center;
    padding:20px;
    color:#64748b;
}
</style>

<div class="wrap">

    <div class="top">
        <h2>Jadwal Obat</h2>
        <a href="{{ route('dokter.jadwal.create') }}" class="btn-add">
            + Tambah Jadwal
        </a>
    </div>

    <div class="card">
        @if($jadwals->count())
        <table>
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Obat</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals as $jadwal)
                <tr>
                    <td>{{ $jadwal->user->name }}</td>
                    <td>{{ $jadwal->nama_obat }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}
                    </td>
                    <td>
                        @if($jadwal->status == 'aktif')
                            <span class="status active">Aktif</span>
                        @else
                            <span class="status nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td class="action">
                        <a href="{{ route('dokter.jadwal.show', $jadwal->id) }}" 
                           class="btn-detail" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('dokter.jadwal.edit', $jadwal->id) }}" 
                           class="btn-edit" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('dokter.jadwal.destroy', $jadwal->id) }}" 
                              method="POST" 
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-hapus" title="Hapus"
                                    onclick="return confirm('Yakin hapus jadwal ini?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty">
            Belum ada jadwal obat.
        </div>
        @endif
    </div>

</div>
@endsection