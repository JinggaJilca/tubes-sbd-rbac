<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik; 


class PemilikController extends Controller
{
    public function readPemilik(Request $request){
        $search = $request->keyword;
        
        $sortBy = $request->input('sort_by', 'id_pemilik');
        $direction = $request->input('direction', 'asc');

        // 2. Validasi Kolom (PENTING untuk Keamanan)
        // Agar user tidak bisa injeksi kolom ngawur di URL
        $validColumns = ['nama_lengkap', 'alamat', 'nomor_telepon', 'email', 'id_pemilik'];
        if (!in_array($sortBy, $validColumns)) {
            $sortBy = 'id_pemilik';
        }

        // 3. Mulai Query
        $query = Pemilik::query();

        // 4. Filter Pencarian
        $query->when($search, function($q, $search) {
            return $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
        });

        // 5. TERAPKAN SORTING
        $query->orderBy($sortBy, $direction);

        // 6. Eksekusi Data (Pagination)
        if ($request->query('mode') === 'all') {
            // ini_set('memory_limit', '-1'); 
            // $pemilik = $query->get(); 
            // $is_paginated = false;

            //=== PAGINATE DENGAN 5.000 DATA
            $pemilik = $query->paginate(5000); 
            $is_paginated = true;
            
            $pemilik->appends(['keyword' => $search, 'mode' => 'all', 'sort_by' => $sortBy, 'direction' => $direction]);
        } else {
            $pemilik = $query->paginate(10);
            $is_paginated = true;
            $pemilik->appends(['keyword' => $search, 'sort_by' => $sortBy, 'direction' => $direction]);
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