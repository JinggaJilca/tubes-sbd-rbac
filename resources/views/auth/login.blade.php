{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')

<div class="container">

    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">
            
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header text-center py-4 rounded-top-4" style="background-color: #674636; color:white;">
                    <i class="fa-solid fa-paw fa-3x mb-2"></i>
                    <h4 class="mb-0 fw-bold">Login Petcare</h4>
                    <small class="opacity-75">Silakan masuk untuk melanjutkan</small>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- INPUT EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="nama@email.com"
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus
                                >
                                {{-- Pesan Error Email --}}
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- INPUT PASSWORD --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Masukkan password"
                                    required
                                >
                                {{-- Pesan Error Password --}}
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- TOMBOL LOGIN --}}
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm" >
                            <i class="fa-solid fa-right-to-bracket me-2"></i>
                            Masuk Sekarang
                        </button>

                    </form>
                </div>

                <div class="card-footer text-center bg-white border-0 py-3 text-muted small">
                    &copy; {{ date('Y') }} <strong>Petcare Clinic</strong>. All rights reserved.
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection