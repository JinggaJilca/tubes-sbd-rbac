<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik; 


class PemilikController extends Controller
{
    public function readPemilik(Request $request){
        $search = $request->keyword;

        $query = Pemilik::query();

        // 2. Terapkan Filter PENCARIAN (Jika ada keyword)
        $query->when($search, function($q, $search) {
            return $q->where('nama_lengkap', 'like', "%{$search}%") 
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nomor_telepon', 'like', "%{$search}%");
        });

        // 3. Eksekusi Query berdasarkan Mode
        
        // SKENARIO 1: Tanpa Pagination (Load Semua Data)
        if ($request->query('mode') === 'all') {
            // Ambil hasil dari $query yang sudah difilter di atas
            $pemilik = $query->get(); 
            $is_paginated = false;
        } 
        // SKENARIO 2: Server-Side Pagination
        else {
            $pemilik = $query->paginate(10);
            
            // PENTING: Append agar saat pindah halaman 2, kata kunci pencarian tidak hilang
            $pemilik->appends(['keyword' => $search]);
            
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