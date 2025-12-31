<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\HewanController;


//1. AUTHENTICATION ROUTES

Auth::routes();

//2. ROUTE HALAMAN UTAMA

// Saat buka website pertama kali, langsung lempar ke halaman Login
Route::get('/', function () {
    return redirect('/login'); 
});

// Route default setelah login (biasanya Laravel mencari ini)
Route::get('/home', [HomeController::class, 'index'])->name('home');

//3. ROUTE PEMILIK (DENGAN PROTEKSI LOGIN & ROLE)

Route::middleware(['auth'])->group(function () {

    // A. WILAYAH UMUM (Admin, Editor, Viewer Boleh Masuk)
    Route::get('/pemilik', [PemilikController::class, 'readPemilik'])
        ->middleware('role:admin,editor,viewer');


    Route::get('/hewan', [HewanController::class, 'readHewan'])
        ->middleware('role:admin,editor,viewer');


    // B. WILAYAH KERJA (Hanya Admin & Editor)
    Route::middleware(['role:admin,editor'])->group(function () {
        //CREATE PEMILIK
        Route::get('/pemilik/create', [PemilikController::class, 'createPemilik']);
        Route::post('/pemilik', [PemilikController::class, 'storePemilik']);
        
        //CREATE HEWAN
        Route::get('/hewan/create', [HewanController::class, 'createHewan']);
        Route::post('/hewan', [HewanController::class, 'storeHewan']);
        
        //UPDATE PEMILIK
        Route::get('/pemilik/{id}/edit', [PemilikController::class, 'editPemilik']);
        Route::put('/pemilik/{id}', [PemilikController::class, 'updatePemilik']); 

        // UPDATE HEWAN
        Route::get('/hewan/{id}/edit', [HewanController::class, 'editHewan']);

        Route::put('/hewan/{id}', [HewanController::class, 'updateHewan']); 
    });


    // C. WILAYAH KERAS (Hanya Admin)
    //DELETE PEMILIK
    Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy'])
        ->middleware('role:admin');
        
    //DELETE HEWAN
    Route::delete('/hewan/{id}', [HewanController::class, 'destroy'])
        ->middleware('role:admin');
        
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ROUTE 404

Route::fallback(function () {
    return view('errors.404'); 
});
// Route untuk pencarian pemilik via AJAX
Route::get('/api/pemilik/search', [HewanController::class, 'searchPemilik'])->name('api.pemilik.search');