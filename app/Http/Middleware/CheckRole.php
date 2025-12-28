<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login?
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Ambil role user saat ini
        $userRole = Auth::user()->role;

        // 3. Cek apakah role user ada di daftar yang diizinkan?
        // in_array mengecek: Apakah 'viewer' ada di dalam ['admin', 'editor']?
        if (in_array($userRole, $roles)) {
            return $next($request); // Silakan masuk
        }

        // 4. Jika tidak cocok, TAMPILKAN ERROR
        // Code 403 artinya "Forbidden" (Dilarang Masuk)
        // Jika Anda ingin menipu user agar terlihat "Page Not Found", ganti 403 jadi 404.
        abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI');
    }
}