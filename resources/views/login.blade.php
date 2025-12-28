{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')
  {{-- TEMPLATE ENGINE --}}

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header text-center" style="background-color: #674636; color:white;">
                    <h4 class="mb-0 fw-bold">Login</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="/login">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="Masukkan email"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control" 
                                placeholder="Masukkan password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-right-to-bracket me-1"></i>
                            Masuk 
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center text-muted">
                    Petcare Clinic
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


