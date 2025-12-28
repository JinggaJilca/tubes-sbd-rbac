<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\HomeController; // Tambahkan ini (bawaan Laravel UI)

/*
|--------------------------------------------------------------------------
| 1. AUTHENTICATION ROUTES (WAJIB ADA)
|--------------------------------------------------------------------------

*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| 2. ROUTE HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
// Saat buka website pertama kali, langsung lempar ke halaman Login
Route::get('/', function () {
    return redirect('/login'); 
});

// Route default setelah login (biasanya Laravel mencari ini)
Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| 3. ROUTE PEMILIK (DENGAN PROTEKSI LOGIN & ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // A. WILAYAH UMUM (Admin, Editor, Viewer Boleh Masuk)
    Route::get('/pemilik', [PemilikController::class, 'readPemilik'])
        ->middleware('role:admin,editor,viewer');


    // B. WILAYAH KERJA (Hanya Admin & Editor)
    Route::middleware(['role:admin,editor'])->group(function () {
        
        Route::get('/pemilik/create', [PemilikController::class, 'createPemilik']);
        Route::post('/pemilik', [PemilikController::class, 'storePemilik']);
        
        Route::get('/pemilik/{id}/edit', [PemilikController::class, 'editPemilik']);
        Route::put('/pemilik/{id}', [PemilikController::class, 'updatePemilik']); 
    });


    // C. WILAYAH KERAS (Hanya Admin)
    Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy'])
        ->middleware('role:admin');
        
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| 3. ROUTE PEMILIK (DENGAN PROTEKSI LOGIN & ROLE)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('errors.404'); 
});