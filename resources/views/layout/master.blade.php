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
        .btn-primary { background-color: #8EB486 !important; border-color: #8EB486 !important; color:#ffffff; }
        .btn-primary:hover { background-color: #4B5945 !important; border-color: #4B5945 !important; }
        .btn-warning{ background-color: #4D7111 !important; border-color: #4D711158 !important; color:#ffffff; }
        .btn-warning:hover{ background-color: #30470b !important; border-color: #30470b !important; color:#ffffff; }
        .btn-danger { background-color: #AE431E !important; border-color: #AE431E !important; color: #ffffff; }
        .btn-danger:hover { background-color: #7D0A0A !important; border-color: #7D0A0A !important; color: #ffffff; }
        .text-primary, .text-warning { color: #C3E958 !important; }
        .alert-primary { background-color: #91EAB2 !important; border-color: #91EAB2 !important; color: #131313 !important; }
        .badge.bg-primary{ background-color: #30470b !important; border-color: #30470b !important; color:#ffffff; }

    </style>
    @stack('styles')
</head>
<body>
            
            {{-- Area Konten Utama --}}
            <div class="main-content-area">
                
                @yield('content')
            </div>
            
        </div>
        </div>
    {{-- 4. CDN Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    {{-- jQuery (Wajib ada sebelum Select2) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>