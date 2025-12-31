{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center col-md-8">
        
        {{-- IKON BESAR --}}
        <div class="mb-4">
            <span class="fa-stack fa-4x">
                <i class="fa-solid fa-circle fa-stack-2x text-light"></i>
                <i class="fa-solid fa-user-lock fa-stack-1x" style="color: #674636;"></i>
            </span>
        </div>

        {{-- JUDUL ERROR --}}
        <h1 class="fw-bold display-4 mb-2">Akses Ditolak (403)</h1>
        
        {{-- PESAN PENJELASAN --}}
        <p class="lead text-muted mb-5">
            Maaf, <strong>{{ auth()->user()->name }}</strong>. 
            Anda tidak memiliki izin (Role: <span class="badge bg-danger">{{ auth()->user()->role }}</span>) 
            untuk mengakses halaman ini.
        </p>

        {{-- TOMBOL AKSI --}}
        <div class="d-flex justify-content-center gap-3">
            {{-- Tombol Kembali --}}
            <a href="{{ url('/home') }}" class="btn btn-lg text-white px-4" style="background-color: #674636;">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Data
            </a>
            
            {{-- Tombol Logout (Opsional, jika dia ingin ganti akun) --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-lg px-4">
                    Ganti Akun
                </button>
            </form>
        </div>

    </div>
</div>
@endsection