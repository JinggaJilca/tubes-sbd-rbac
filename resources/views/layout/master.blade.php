<!doctype html>
<html lang="en">
  <head>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
        }
        /* Mengubah Background Primary (Navbar, dll) */
        .bg-primary {
            background-color: #C3E958 !important; /* Ganti kode warna sesuka hati */
        }

        /* Mengubah Tombol Primary */
        .btn-primary {
            background-color: #C3E958 !important;
            border-color: #C3E958 !important;
            color:#131313;
        }

        /* Mengubah Efek Saat Mouse di atas Tombol (Hover) */
        .btn-primary:hover {
            background-color: #4D7111 !important; /* Warna sedikit lebih gelap */
            border-color: #4D7111 !important;
        }

        .btn-warning{
            background-color: #4D7111 !important;
            border-color: #4D711158 !important;
            color:#ffffff;
        }

        .btn-warning:hover{
            background-color: #30470b !important;
            border-color: #30470b !important;
            color:#ffffff;
        }
        
        .btn-danger {
            background-color: #fd2b2b !important;
            border-color: #fd2b2b !important;
        }

        /* Mengubah Efek Saat Mouse di atas Tombol (Hover) */
        .btn-danger:hover {
            background-color: #c22424 !important; /* Warna sedikit lebih gelap */
            border-color: #c22424 !important;
        }
        
        /* Mengubah Warna Teks Link/Outline */
        .text-primary {
            color: #C3E958 !important;
        }
        .text-warning {
            color: #C3E958 !important;
        }

        .alert-primary {
            background-color: #91EAB2 !important;
            border-color: #91EAB2 !important;
            color: #131313 !important;
        }
    </style>
</head>
    <title>PetCare Clinic | RBAC</title>
  </head>
  <body>
    {{-- @include('layouts.navbar') --}}
    <div class="container mt-3">
        <!-- ISI KONTEN DISINI -->
         @yield('content')
    </div>
    {{-- @include('layout.footer') --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>