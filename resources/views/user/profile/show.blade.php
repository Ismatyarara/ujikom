@extends('layouts.app')
@section('title', 'Profile Saya')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profile Saya</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        {{-- Foto Profile --}}
                        <div class="col-md-4 text-center mb-3">
                            @if($profile->foto)
                                <img src="{{ asset('storage/'.$profile->foto) }}" 
                                     class="img-thumbnail rounded" 
                                     style="max-width: 200px; width: 100%;" 
                                     alt="Foto Profile">
                            @else
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" 
                                     style="width: 200px; height: 200px; margin: 0 auto;">
                                    <i class="icon-user" style="font-size: 5rem;"></i>
                                </div>
                                <small class="text-muted mt-2 d-block">Belum ada foto</small>
                            @endif
                        </div>

                        {{-- Data Profile --}}
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td style="width: 180px;" class="fw-bold">Nama Lengkap</td>
                                        <td>: {{ $profile->nama_panjang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Tanggal Lahir</td>
                                        <td>: {{ \Carbon\Carbon::parse($profile->tanggal_lahir)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Umur</td>
                                        <td>: {{ \Carbon\Carbon::parse($profile->tanggal_lahir)->age }} tahun</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jenis Kelamin</td>
                                        <td>: {{ $profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Golongan Darah</td>
                                        <td>: {{ $profile->golongan_darah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">No HP</td>
                                        <td>: {{ $profile->no_hp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold align-top">Alamat</td>
                                        <td>: {{ $profile->alamat ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <form action="{{ route('user.profile.destroy') }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus profile ini? Anda tidak akan bisa mengakses fitur lain setelah menghapus profile.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="icon-trash"></i> Hapus Profile
                                    </button>
                                </form>
                                
                                <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">
                                    <i class="icon-pencil"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection