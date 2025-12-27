<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemilikController;

Route::get('/', function () {
    return view('login');
});

//Contoh
// Route::get('/about',function(){
//     return view('about');
// });

// Route untuk Menampilkan Data (Read)
Route::get('/pemilik', [PemilikController::class, 'readPemilik']);

// Route untuk Menampilkan Form Tambah (Create)
Route::get('/pemilik/create', [PemilikController::class, 'createPemilik']);

// Route untuk Menyimpan Data (Store)
Route::post('/pemilik', [PemilikController::class, 'storePemilik']);

Route::get('/pemilik/{id}/edit',[PemilikController::class, 'editPemilik']); 

Route::put('/pemilik/{id}',[PemilikController::class, 'updatePemilik']); 

Route::delete('/pemilik/{id}', [PemilikController::class,'destroy']);