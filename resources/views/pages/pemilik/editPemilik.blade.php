@extends('layout.sidebar')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4">Edit Data Pemilik Hewan</h5>
            
            <form action="/pemilik/{{$data->id_pemilik}}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="namaLengkap" value="{{$data->nama_lengkap}}">
                        @error('namaLengkap')
                            <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" name="nomorTelepon" value="{{$data->nomor_telepon}}">
                        @error('nomorTelepon')
                            <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{$data->email}}">
                        @error('email')
                            <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" name="alamat" style="height: 100px">{{$data->alamat}}</textarea>
                        <label>Alamat Lengkap</label>
                    </div>
                    @error('alamat')
                            <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            {{-- Tombol Aksi --}}
                <div class="d-flex gap-2 justify-content-end">
                    {{-- Tombol Batal Opsional --}}
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fa-solid fa-save me-2"></i>Update Data
                    </button>
                </div>
        </form>
        </div>
    </div>
</div>
@endsection
{{-- ====================================== --}}

