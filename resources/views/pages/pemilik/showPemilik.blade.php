{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3>Daftar Pemilik Hewan</h3>

        <div class="d-flex align-items-center gap-3">
            {{-- 1. Bagian Teks & Badge --}}
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted">
                    Halo, <strong class="text-dark">{{ auth()->user()->name }}</strong>
                </span>
                <span class="badge bg-primary text-uppercase">{{ auth()->user()->role }}</span>
            </div>

            <div class="vr" style="height: 25px;"></div>

            {{-- Tombol Logout --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2" 
                        onclick="return confirm('Yakin ingin keluar?')">
                    <i class="fa-solid fa-right-from-bracket"></i> 
                    <span>Keluar</span>
                </button>
            </form>

        </div>
    </div>
    <hr>
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'editor')
        <div class="d-flex flex-wrap gap-2 mb-3">
            
            <a href="/pemilik/create" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Tambah Data
            </a>

            <a href="{{ url('/pemilik') }}?mode=all" class="btn btn-danger">
                <i class="fa-solid fa-layer-group me-1"></i> Tampilkan Semua Data
            </a>

        </div>
    @endif
    {{-- Notifikasi Create --}}
    @if(session('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            Tabel Data Pemilik 
            (Total: {{ $is_paginated ? $pemilik->total() : $pemilik->count() }} Data)
            <form action="/pemilik" method="GET" class="d-flex gap-2" style="width: 450px">
                <input type="text" name="keyword" class="form-control" 
                    placeholder="Cari sesuatu..." 
                    value="{{ request('keyword') }}"> 
                    <button type="submit" style="width: 130px" class="btn btn-warning">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Cari
                </button>
                
                @if(request('keyword'))
                    <a href="/pemilik" style="width: 130px" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            {{-- FUNCTION HELPER SEDERHANA UNTUK SORTING --}}
                            @php
                                // Fungsi untuk menentukan link & ikon sorting
                                function sortUrl($column, $label) {
                                    // Ambil parameter
                                    $currentSort = request('sort_by', 'id_pemilik');
                                    $currentDir  = request('direction', 'asc');
                                    
                                    // Tentukan arah selanjutnya (Jika sedang ASC, jadi DESC. Jika beda kolom, reset ke ASC)
                                    $nextDir = ($currentSort == $column && $currentDir == 'asc') ? 'desc' : 'asc';
                                    
                                    // Buat URL baru (Gabungkan dengan keyword pencarian jika ada)
                                    $url = request()->fullUrlWithQuery(['sort_by' => $column, 'direction' => $nextDir]);

                                    // Tentukan Ikon
                                    $icon = '<i class="fa-solid fa-sort text-muted ms-1"></i>'; // Default (netral)
                                    if ($currentSort == $column) {
                                        if ($currentDir == 'asc') {
                                            $icon = '<i class="fa-solid fa-sort-up text-white ms-1"></i>';
                                        } else {
                                            $icon = '<i class="fa-solid fa-sort-down text-white ms-1"></i>';
                                        }
                                    }

                                    // Return Link HTML
                                    return "<a href='$url' class='text-white text-decoration-none d-flex justify-content-between align-items-center'>$label $icon</a>";
                                }
                            @endphp

                            {{-- KOLOM DENGAN SORTING --}}
                            <th scope="col">{!! sortUrl('nama_lengkap', 'Nama Lengkap') !!}</th>
                            <th scope="col">{!! sortUrl('alamat', 'Alamat') !!}</th>
                            <th scope="col">{!! sortUrl('nomor_telepon', 'No. Telepon') !!}</th>
                            <th scope="col">{!! sortUrl('email', 'Email') !!}</th>

                            @if(auth()->user()->role !== 'viewer')
                                <th scope="col" style="width: 15%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemilik as $key => $item)
                        <tr>
                            <th scope="row">{{ $pemilik->firstItem() + $key }}</th>
                            
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->nomor_telepon }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if(auth()->user()->role !== 'viewer')
                                        <a href="/pemilik/{{$item->id_pemilik}}/edit" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit
                                        </a>
                                    @endif
                                    <!-- Button trigger modal -->
                                    @if(auth()->user()->role == 'admin')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus{{ $item->id_pemilik }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Data Pemilik Tidak Ada
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($is_paginated)
                <div class="mt-3">
                    {{ $pemilik->links('vendor.pagination.custom-pagination') }}
                </div>
            @else
                <div class="mt-3 alert alert-warning">
                    Menampilkan seluruh data (Tanpa Pagination).
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
{{-- MODAL --}}
@foreach ($pemilik as $item)
<div class="modal fade" id="hapus{{ $item->id_pemilik }}" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data pemilik:
                <strong>{{ $item->nama_lengkap }}</strong>?
                <br>
                <small class="text-danger">Data yang dihapus tidak dapat dikembalikan.</small>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                
                <form action="/pemilik/{{ $item->id_pemilik }}" method="POST">
                    @csrf
                    @method('DELETE') 
                    
                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach