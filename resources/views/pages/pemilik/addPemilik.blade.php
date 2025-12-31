{{-- TEMPLATE ENGINE --}}
@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4">Tambah Data Pemilik Hewan</h5>
            
            <form action="/pemilik" method="POST">
                @csrf
                
                {{-- BARIS 1: Nama Lengkap (Full Width) --}}
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="namaLengkap" class="form-label fw-medium">Nama Lengkap</label>
                        <input type="text" class="form-control @error('namaLengkap') is-invalid @enderror" id="namaLengkap" name="namaLengkap" value="{{old('namaLengkap')}}" placeholder="Masukkan nama lengkap pemilik">
                        @error('namaLengkap')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                {{-- BARIS 2: Kontak (Telepon & Email Bersebelahan) --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="nomorTelepon" class="form-label fw-medium">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('nomorTelepon') is-invalid @enderror" id="nomorTelepon" name="nomorTelepon" value="{{old('nomorTelepon')}}" placeholder="Contoh: 08123456789">
                        @error('nomorTelepon')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" placeholder="Contoh: email@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                {{-- BARIS 3: Alamat (Textarea Full Width) --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <label for="alamat" class="form-label fw-medium">Alamat Lengkap</label>
                        {{-- PERBAIKAN: Nilai old() pada textarea diletakkan di antara tag, BUKAN di atribut value --}}
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap pemilik">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2 justify-content-end">
                    {{-- Tombol Batal Opsional --}}
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fa-solid fa-save me-2"></i>Simpan Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection