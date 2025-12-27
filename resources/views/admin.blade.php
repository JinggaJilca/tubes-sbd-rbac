{{-- TEMPLATE ENGINE --}}
@extends('layout.master')

@section('content')
  <h1>Daftar Pemilik Hewan</h1>
  <hr>
  <a href="/product/tambah" type="button" class="btn btn-primary mb-3" a>
    <i class="fa-solid fa-plus me-2"></i>Tambah Data</a>
  <div class="card-body">
    <div class="card-header">Tabel Pemilik</div>
    
    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Produk</th>
        <th scope="col">Stok</th>
        <th scope="col">Harga</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Laptop ROG</td>
        <td>25</td>
        <td>2000000</td>
        <td>
          <button type="button" class="btn btn-warning">
            <i class="fa-solid fa-pen-to-square me-2"></i>Edit
          </button>

          <button type="button" class="btn btn-danger">
            <i class="fa-solid fa-trash-can me-2"></i>Hapus
          </button>
        </td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Laptop ROG</td>
        <td>25</td>
        <td>2000000</td>
        <td>
          <button type="button" class="btn btn-warning">
            <i class="fa-solid fa-pen-to-square me-2"></i>Edit
          </button>

          <button type="button" class="btn btn-danger">
            <i class="fa-solid fa-trash-can me-2"></i>Hapus
          </button>
        </td>
      </tr>

    </tbody>
  </table>

  </div>
@endsection

