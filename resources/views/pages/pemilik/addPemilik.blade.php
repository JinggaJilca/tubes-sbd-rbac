{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h3>Tambah Data Pemilik Hewan</h3>
    <hr>
    <div class="card-body">
        <form action="/pemilik" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="namaLengkap" value="{{old('namaLengkap')}}">
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
                        <input type="tel" class="form-control" name="nomorTelepon" value="{{old('nomorTelepon')}}">
                        @error('nomorTelepon')
                            <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email')}}">
                        @error('email')
                            <div class="form-text text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" name="alamat" style="height: 100px" value="{{old('alamat')}}"></textarea>
                        <label>Alamat Lengkap</label>
                    </div>
                    @error('alamat')
                            <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>


    
</div>
@endsection