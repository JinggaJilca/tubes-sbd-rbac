{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center col-md-8">
        
        {{-- IKON BESAR (Tema Tersesat) --}}
        <div class="mb-4">
            <span class="fa-stack fa-4x">
                <i class="fa-solid fa-circle fa-stack-2x text-light"></i>
                {{-- Ikon Peta/Lokasi --}}
                <i class="fa-solid fa-map-location-dot fa-stack-1x" style="color: #674636;"></i>
            </span>
        </div>

        {{-- JUDUL ERROR --}}
        <h1 class="fw-bold display-4 mb-2">Halaman Tidak Ditemukan (404)</h1>
        
        {{-- PESAN PENJELASAN --}}
        <p class="lead text-muted mb-5">
            Ups! Sepertinya Anda tersesat. <br>
            Halaman yang Anda cari tidak ada atau URL-nya salah ketik.
        </p>

        {{-- TOMBOL AKSI --}}
        <div class="d-flex justify-content-center gap-3">
            {{-- Tombol Utama --}}
            <a href="{{ url('/home') }}" class="btn btn-lg text-white px-4" style="background-color: #674636;">
                <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
            </a>
            
            {{-- Tombol Back Browser (Opsional) --}}
            <button onclick="history.back()" class="btn btn-outline-secondary btn-lg px-4">
                Kembali
            </button>
        </div>

    </div>
</div>
@endsection