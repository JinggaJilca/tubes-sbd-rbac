<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PetCare Clinic | RBAC</title>
    
    {{-- 1. CDN Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- 2. CDN Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- 3. Google Fonts (Inter & Poppins) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Select2 Bootstrap 5 Theme (Agar tampilannya cocok dengan Bootstrap) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        /* --- STYLE GLOBAL --- */
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f4f7f6;
            margin: 0; 
            padding: 0;
            overflow-x: hidden;
        }

        /* Style Warna Anda (Dipertahankan) */
        .bg-primary { background-color: #6d8664 !important; border-color: #6d8664 !important; color:#ffffff; }
        .btn-primary { background-color: #567f4d !important; border-color: #567f4d !important; color:#ffffff; }
        .btn-primary:hover { background-color: #4B5945 !important; border-color: #4B5945 !important; }
        .btn-warning{ background-color: #4D7111 !important; border-color: #4D711158 !important; color:#ffffff; }
        .btn-warning:hover{ background-color: #30470b !important; border-color: #30470b !important; color:#ffffff; }
        .btn-danger { background-color: #AE431E !important; border-color: #AE431E !important; color: #ffffff; }
        .btn-danger:hover { background-color: #7D0A0A !important; border-color: #7D0A0A !important; color: #ffffff; }
        .text-primary, .text-warning { color: #C3E958 !important; }
        .alert-primary { background-color: #91EAB2 !important; border-color: #91EAB2 !important; color: #131313 !important; }
        .badge.bg-primary{ background-color: #30470b !important; border-color: #30470b !important; color:#ffffff; }

        /* --- CUSTOM RADIO BUTTON GREEN STYLE --- */

        /* 1. Mengubah warna saat radio button DIPILIH (Checked) */
        .form-check-input:checked {
            background-color: #6d8664 !important; /* Warna hijau primary Anda */
            border-color: #6d8664 !important;
        }

        /* 2. Mengubah warna "ring" fokus saat diklik/di-tab */
        /* Ini penting agar saat diklik tidak muncul lingkaran biru samar */
        .form-check-input:focus {
            border-color: #6d8664 !important;
            /* Membuat efek bayangan/ring hijau transparan */
            /* rgba(109, 134, 100) adalah versi RGB dari #6d8664 */
            box-shadow: 0 0 0 0.25rem rgba(109, 134, 100, 0.25) !important;
            /* Jika Anda tidak ingin ada efek ring sama sekali, gunakan: box-shadow: none !important; */
        }

        /* 3. (Opsional) Mengubah warna border saat di-hover tapi belum dipilih */
        .form-check-input:not(:checked):hover {
            border-color: #6d8664 !important;

        }
        /* --- STYLE LAYOUT SIDEBAR --- */
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: 100vh;
        }

        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background: #674636; /* Warna Tema Kopi Utama */
            color: #fff;
            transition: all 0.3s;
            z-index: 999;
            display: flex;
            flex-direction: column;
        }

        #sidebar .sidebar-header {
            padding: 25px 20px;
            background: #543a2d;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar ul.components {
            padding: 20px 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        #sidebar ul p {
            color: rgba(255, 255, 255, 0.5);
            padding: 10px 20px;
            font-size: 0.85em;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 0;
        }

        /* Style Item Menu */
        #sidebar ul li a {
            padding: 15px 20px;
            font-size: 1em;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: 0.3s;
            border-left: 5px solid transparent;
            cursor: pointer;
        }

        /* Hover Menu */
        #sidebar ul li a:hover, 
        #sidebar ul li a[aria-expanded="true"] {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left: 5px solid #d7ccc8;
        }

        /* Menu Aktif */
        #sidebar ul li.active > a {
            color: #fff;
            background: #8d6e63;
            border-left: 5px solid #fff;
            font-weight: 500;
        }
        
        #sidebar ul li.active > a i { color: #fff !important; }

        /* Fix untuk Ikon Dropdown Bootstrap */
        #sidebar .dropdown-toggle::after {
            color: rgba(255, 255, 255, 0.5);
            margin-left: auto;
        }

        /* Style untuk Submenu (Dropdown items) */
        #sidebar ul.collapse li a {
            padding-left: 50px !important;
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 0.95em;
            background: transparent;
            border-left: none;
        }
         #sidebar ul.collapse li a:hover,
         #sidebar ul.collapse li.active > a {
             background: rgba(0,0,0,0.1) !important;
             color: #fff !important;
         }

        /* Area User & Logout */
        .user-info-box {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            margin-top: auto;
        }

        /* --- STYLE KONTEN UTAMA --- */
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            padding: 15px 30px;
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-content-area {
            padding: 30px;
            flex-grow: 1;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="wrapper">
        
        <nav id="sidebar">
            
            {{-- Header Sidebar --}}
            <div class="sidebar-header d-flex align-items-center gap-3">
                <div class="bg-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-paw fa-lg" style="color: #674636;"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="line-height: 1;">Petcare</h5>
                    <small style="font-size: 0.8em; opacity: 0.7;">Clinic</small>
                </div>
            </div>

            {{-- List Menu Navigasi --}}
            <ul class="list-unstyled components mb-auto">
                <p>Menu Utama</p>
                
                {{-- Menu Dashboard --}}
                <li class="{{ Request::is('home*') ? 'active' : '' }}">
                    <a href="{{ url('/home') }}">
                        <i class="fa-solid fa-gauge-high me-3 text-white-50" style="width: 25px; text-align: center;"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <p class="mt-3">Data Management</p>

                {{-- DROPDOWN MENU: Master Data --}}
                @php
                    $isActiveMaster = Request::is('pemilik*', 'hewan*');
                @endphp
                <li class="{{ $isActiveMaster ? 'active' : '' }}">
                    <a href="#masterDataSubmenu" data-bs-toggle="collapse" aria-expanded="{{ $isActiveMaster ? 'true' : 'false' }}" class="dropdown-toggle">
                        <i class="fa-solid fa-database me-3 text-white-50" style="width: 25px; text-align: center;"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="collapse list-unstyled {{ $isActiveMaster ? 'show' : '' }}" id="masterDataSubmenu">
                        <li class="{{ Request::is('pemilik*') ? 'active' : '' }}">
                            <a href="{{ url('/pemilik') }}">Data Pemilik</a>
                        </li>
                        <li class="{{ Request::is('hewan*') ? 'active' : '' }}">
                            <a href="{{ url('/hewan') }}">Data Hewan</a>
                        </li>
                    </ul>
                </li>

                {{-- Contoh Menu Lain --}}
                {{-- <li>
                    <a href="#">
                        <i class="fa-solid fa-calendar-check me-3 text-white-50" style="width: 25px; text-align: center;"></i>
                        <span>Jadwal Kunjungan</span>
                    </a>
                </li> --}}

            </ul>
            
            {{-- Area User Info & Logout --}}
            <div class="user-info-box">
                 <div class="d-flex align-items-center mb-3">
                    {{-- Avatar (Menggunakan fallback 'U' jika tidak login) --}}
                    <div class="bg-white text-dark rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    {{-- Nama & Role (Menggunakan fallback 'User' dan 'Guest') --}}
                    <div style="line-height: 1.2;">
                        <span class="d-block fw-bold text-truncate" style="max-width: 140px;">{{ auth()->user()->name ?? 'User' }}</span>
                        <small class="badge bg-warning text-dark" style="font-size: 0.7em;">{{ strtoupper(auth()->user()->role ?? 'Guest') }}</small>
                    </div>
                </div>
                 {{-- Form Logout --}}
                 {{-- Perhatian: Jika belum login, tombol ini mungkin akan menyebabkan error 419 atau redirect jika diklik --}}
                 <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100 btn-sm d-flex align-items-center justify-content-center gap-2" onclick="return confirm('Yakin ingin keluar?')">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>

        </nav>
        <div id="content">
            
            {{-- Top Navbar --}}
            <nav class="top-navbar shadow-sm">
                <div>
                    {{-- Judul Halaman Dinamis --}}
                    <h5 class="mb-0 text-dark fw-bold">
                        @if(Request::is('home*')) Dashboard Overview
                        @elseif(Request::is('pemilik*')) Manajemen Pemilik
                        @elseif(Request::is('hewan*')) Manajemen Hewan
                        @else Halaman Admin
                        @endif
                    </h5>
                </div>
            </nav>
            
            {{-- Area Konten Utama --}}
            <div class="main-content-area">
                {{-- SEMUA KONTEN (Termasuk Form Login jika ada) akan dirender di sini --}}
                @yield('content')
            </div>
            
        </div>

</div>
    {{-- ============================================================ --}}
    {{-- SCRIPT JAVASCRIPT GLOBAL (Urutan Sangat Penting!)            --}}
    {{-- ============================================================ --}}

    {{-- 1. jQuery (WAJIB PALING PERTAMA sebelum script lain) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- 2. Bootstrap Bundle JS (Termasuk Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 3. Select2 JS (Wajib SETELAH jQuery) --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- 4. Stack Scripts (Tempat script spesifik halaman akan dirender) --}}
    {{-- Script dari @push('scripts') di file AddHewan.blade.php akan muncul di sini --}}
    @stack('scripts')

</body>
</html>
