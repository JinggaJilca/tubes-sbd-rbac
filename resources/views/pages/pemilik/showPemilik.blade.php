{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h3>Daftar Pemilik Hewan</h3>
    <hr>
    <div class="d-flex flex-wrap gap-2 mb-3">
        
        <a href="/pemilik/create" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Tambah Data
        </a>

        <a href="{{ url('/pemilik') }}?mode=all" class="btn btn-danger">
            <i class="fa-solid fa-layer-group me-1"></i> Tampilkan Semua Data
        </a>

    </div>
    
    {{-- Notifikasi Create --}}
    @if(session('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header fw-bold">
            Tabel Data Pemilik (Total: {{ $pemilik->total() }} Data)
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No. Telepon</th>
                            <th scope="col">Email</th>
                            <th scope="col" style="width: 15%">Aksi</th>
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
                                    <a href="/pemilik/{{$item->id_pemilik}}/edit" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit
                                    </a>
        
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus{{ $item->id_pemilik }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data pemilik.
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