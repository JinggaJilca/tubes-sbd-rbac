<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// PENTING: Jangan lupa import kedua Model ini di bagian atas!
use App\Models\Pemilik;
use App\Models\Hewan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Memastikan hanya user yang login yang bisa akses dashboard
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // 1. Menghitung total data dari database
        // Fungsi count() sangat efisien, dia hanya meminta jumlah angka ke DB, bukan mengambil seluruh datanya.
        $totalPemilik = Pemilik::count();

        // Pastikan Anda sudah membuat Model Hewan. Jika belum, baris ini akan error.
        // Jika tabel hewan masih kosong, dia akan mengembalikan nilai 0 (aman).
        $totalHewan = Hewan::count();

        // 2. Mengirim variabel ke View menggunakan compact()
        return view('home', compact('totalPemilik', 'totalHewan'));
    }
}