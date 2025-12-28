@extends('layout.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0 rounded-4 p-3" style="max-width: 450px; width: 100%;">
        <div class="card-body text-center">

            <div class="mb-4">
                <div class="bg-light rounded-circle d-inline-flex p-3">
                    <i class="fa-solid fa-user-check fa-3x" style="color: #674636;"></i>
                </div>
            </div>

            <h4 class="fw-bold mb-2">Halo, {{ auth()->user()->name }}!</h4>
            <p class="text-muted mb-4">Anda berhasil login sebagai <strong>{{ auth()->user()->role }}</strong>.</p>

            <div class="d-grid gap-3">
                
                {{-- OPSI 1: MASUK KE DATA --}}
                <a href="{{ url('/pemilik') }}" class="btn btn-lg text-white fw-bold" style="background-color: #674636;">
                    <i class="fa-solid fa-list-ul me-2"></i> Lihat Data Pemilik
                </a>

                {{-- OPSI 2: LOGOUT --}}
                <form action="{{ route('logout') }}" method="POST" class="d-grid">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-lg" onclick="return confirm('Yakin ingin keluar?')">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar Aplikasi
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection