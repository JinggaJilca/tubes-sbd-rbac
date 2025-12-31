@extends('layout.sidebar')

@section('content')
<div class="container-fluid">
    
    {{-- Header Halaman --}}

    {{-- Kartu Ringkasan Statistik --}}
    <div class="row g-4">
        
        {{-- KARTU STATISTIK PEMILIK --}}
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-left: 5px solid #6d8664 !important;">
                <div class="card-body p-4 position-relative">
                    <i class="fa-solid fa-users fa-4x text-primary position-absolute" style="opacity: 0.1; right: 20px; bottom: 20px;"></i>
                    <h6 class="text-uppercase text-muted fw-bold mb-3">Total Pemilik</h6>
                    <div class="d-flex align-items-center">
                        {{-- BAGIAN INI YANG DIUBAH --}}
                        {{-- Menampilkan variabel $totalPemilik dengan format angka --}}
                        <h1 class="display-5 fw-bold mb-0 me-3 text-dark">
                            {{ number_format($totalPemilik ?? 0) }}
                        </h1>
                        {{-- ---------------------- --}}
                        {{-- <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                            <i class="fa-solid fa-user-check"></i> Terdaftar
                        </span> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- KARTU STATISTIK HEWAN --}}
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-left: 5px solid #4D7111 !important;">
                <div class="card-body p-4 position-relative">
                    <i class="fa-solid fa-paw fa-4x text-warning position-absolute" style="opacity: 0.1; right: 20px; bottom: 20px;"></i>
                    <h6 class="text-uppercase text-muted fw-bold mb-3">Total Hewan/Pasien</h6>
                    <div class="d-flex align-items-center">
                        {{-- BAGIAN INI YANG DIUBAH --}}
                        {{-- Menampilkan variabel $totalHewan dengan format angka --}}
                        <h1 class="display-5 fw-bold mb-0 me-3 text-dark">
                             {{ number_format($totalHewan ?? 0) }}
                        </h1>
                        {{-- ---------------------- --}}
                        <span class="badge bg-warning bg-opacity-10 text-warning p-2" style="background-color: #4d711138 !important; color: #30470b !important;">
                            <i class="fa-solid fa-dog"></i> Aktif
                        </span> 
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Role (Tidak perlu diubah) --}}
         <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-left: 5px solid #b00a1e !important;">
                <div class="card-body p-4 position-relative">
                    <i class="fa-solid fa-paw fa-4x text-warning position-absolute" style="opacity: 0.1; right: 20px; bottom: 20px;"></i>
                    <h6 class="text-uppercase text-muted fw-bold mb-3">Role Anda</h6>
                    <div class="d-flex align-items-center">
                        <h1 class="display-5 fw-bold mb-0 me-3 text-dark">
                             {{ strtoupper(auth()->user()->role) }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
