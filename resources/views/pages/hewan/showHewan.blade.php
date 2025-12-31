@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    {{-- ... Bagian Atas (Judul dan Tombol) Tetap Sama ... --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3>Daftar Hewan/Pasien</h3>
    </div>
    <hr>
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'editor')
        <div class="d-flex flex-wrap gap-2 mb-3">
            <a href="/hewan/create" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Tambah Data
            </a>
            <a href="{{ url('/hewan') }}?mode=all" class="btn btn-danger">
                <i class="fa-solid fa-layer-group me-1"></i> Tampilkan Semua Data
            </a>
        </div>
    @endif
    
    {{-- Alert Success Tetap Sama --}}
    @if(session('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        {{-- Card Header Tetap Sama --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            Tabel Data Hewan 
            (Total: {{ $is_paginated ? $hewan->total() : $hewan->count() }} Data)
            <form action="/hewan" method="GET" class="d-flex gap-2" style="width: 450px">
                <input type="text" name="keyword" class="form-control" 
                    placeholder="Cari sesuatu..." 
                    value="{{ request('keyword') }}"> 
                    <button type="submit" style="width: 130px" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Cari
                </button>
                
                @if(request('keyword'))
                    <a href="/hewan" style="width: 130px" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            {{-- FUNCTION HELPER SORTING TETAP SAMA --}}
                            @php
                                function sortUrl($column, $label) {
                                    $currentSort = request('sort_by', 'id_hewan');
                                    $currentDir  = request('direction', 'asc');
                                    $nextDir = ($currentSort == $column && $currentDir == 'asc') ? 'desc' : 'asc';
                                    $url = request()->fullUrlWithQuery(['sort_by' => $column, 'direction' => $nextDir]);
                                    $icon = '<i class="fa-solid fa-sort text-muted ms-1"></i>';
                                    if ($currentSort == $column) {
                                        if ($currentDir == 'asc') {
                                            $icon = '<i class="fa-solid fa-sort-up text-white ms-1"></i>';
                                        } else {
                                            $icon = '<i class="fa-solid fa-sort-down text-white ms-1"></i>';
                                        }
                                    }
                                    return "<a href='$url' class='text-white text-decoration-none d-flex justify-content-between align-items-center'>$label $icon</a>";
                                }
                            @endphp

                            {{-- KOLOM DENGAN SORTING --}}
                            <th scope="col">{!! sortUrl('nama_hewan', 'Nama Hewan') !!}</th>
                            
                            {{-- === TAMBAHAN KOLOM PEMILIK === --}}
                            <th scope="col">Nama Pemilik</th>
                            <th scope="col">{!! sortUrl('jenis_kelamin', 'Jenis Kelamin') !!}</th>
                            <th scope="col">{!! sortUrl('tahun_kelahiran', 'Lahir') !!}</th>
                            <th scope="col">{!! sortUrl('ras_hewan', 'Ras') !!}</th>
                            <th scope="col">{!! sortUrl('berat_hewan', 'Berat') !!}</th>

                            @if(auth()->user()->role !== 'viewer')
                                <th scope="col" style="width: 15%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hewan as $key => $item)
                        <tr>
                            <th scope="row">
                                {{ $is_paginated ? $hewan->firstItem() + $key : $key + 1 }}
                            </th>
                            
                            <td class="fw-bold">{{ $item->nama_hewan }}</td>

                            {{-- === MENAMPILKAN NAMA PEMILIK === --}}
                            <td>
                                {{ $item->pemilik->nama_lengkap ?? '-' }}
                            </td>
                            {{-- ================================= --}}

                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->tahun_kelahiran }}</td>
                            <td>{{ $item->ras_hewan }}</td>
                            <td>{{ $item->berat_hewan }}</td>
                            
                            <td>
                                {{-- Tombol Aksi Tetap Sama --}}
                                <div class="d-flex gap-1">
                                    @if(auth()->user()->role !== 'viewer')
                                        <a href="/hewan/{{$item->id_hewan}}/edit" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit
                                        </a>
                                    @endif
                                    
                                    @if(auth()->user()->role == 'admin')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus{{ $item->id_hewan }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            {{-- Perbaikan colspan karena jumlah kolom bertambah --}}
                            <td colspan="8" class="text-center text-muted">
                                Data Hewan Tidak Ada
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Tetap Sama --}}
            @if($is_paginated)
                <div class="mt-3">
                    {{ $hewan->links('vendor.pagination.custom-pagination') }}
                </div>
            @else
                <div class="mt-3 alert alert-info">
                    <i class="fa-solid fa-check-circle me-1"></i> Menampilkan seluruh data.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

{{-- MODAL --}}
@foreach ($hewan as $item)
<div class="modal fade" id="hapus{{ $item->id_hewan }}" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data hewan:
                {{-- 
                    BUG FIX: Di kode asli Anda tertulis $item->nama_lengkap. 
                    Padahal $item adalah object Hewan, yang tidak punya nama_lengkap.
                    Seharusnya nama hewan yang ditampilkan.
                --}}
                <strong>{{ $item->nama_hewan }}</strong>?
                <br>
                {{-- Menampilkan nama pemilik di modal konfirmasi juga (opsional) --}}
                <small class="text-muted">Pemilik: {{ $item->pemilik->nama_lengkap ?? '-' }}</small>
                <br>
                <small class="text-danger">Data yang dihapus tidak dapat dikembalikan.</small>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                
                <form action="/hewan/{{ $item->id_hewan }}" method="POST">
                    @csrf
                    @method('DELETE') 
                    
                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach