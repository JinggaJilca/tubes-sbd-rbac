<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik; 


class PemilikController extends Controller
{
    public function readPemilik(Request $request)
    {
        // SKENARIO 1: Tanpa Pagination (Load Semua Data)
        if ($request->query('mode') === 'all') {
            
            $pemilik = Pemilik::all(); 

            $is_paginated = false;

        } 
        // SKENARIO 2: Server-Side Pagination (10 Item per Halaman)
        else {
            
            $pemilik = Pemilik::paginate(10);
            $is_paginated = true;
            
        }

        return view('pages.pemilik.showPemilik', compact('pemilik', 'is_paginated'));
    }

    public function createPemilik(){
        return view('pages.pemilik.addPemilik');
    }

    public function storePemilik(Request $request){
        //Validasi input
        $request->validate([
                'namaLengkap'   => 'required',
                'nomorTelepon'  => 'required|numeric',
                'email'         => 'required|email',
                'alamat'        => 'required',
            ]);

       //Menambahkan data ke tabel pemilik
        Pemilik::create([
                'nama_lengkap'  => $request->namaLengkap,
                'alamat'        => $request->alamat,
                'nomor_telepon' => $request->nomorTelepon,
                'email'         => $request->email,
        ]);
        //Setelah menambahkan data
        return redirect('/pemilik')->with('success','Menambahkan data');
    }

    public function editPemilik($id){
        $data = Pemilik::findOrFail($id);

        return view('pages.pemilik.editPemilik',[
            'data'=>$data,
        ]);
    }

    public function updatePemilik($id, Request $request){

        //Validasi
        $request->validate([
                'namaLengkap'   => 'required',
                'nomorTelepon'  => 'required|numeric',
                'email'         => 'required|email',
                'alamat'        => 'required',
            ]);

        Pemilik::where('id_pemilik', $id)->update([
                'nama_lengkap'  => $request->namaLengkap,
                'alamat'        => $request->alamat,
                'nomor_telepon' => $request->nomorTelepon,
                'email'         => $request->email,
        ]);

        return redirect('/pemilik')->with('success','Mengubah data');
    }

    public function destroy($id){
        Pemilik::findOrFail($id)->delete();
        return redirect('/pemilik')->with('success','Menghapus data');
    }
}