<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\Hewan;   
use Illuminate\Support\Str; 
class HewanController extends Controller
{
    public function readHewan(Request $request){
        // 1. Ambil Parameter Input
        $search = $request->keyword;
        $sortBy = $request->input('sort_by', 'id_hewan');
        $direction = $request->input('direction', 'asc');
        $mode = $request->query('mode'); 

        // 2. Validasi Kolom Sorting (Keamanan untuk mencegah SQL Injection)
        $validColumns = ['id_hewan', 'nama_hewan', 'jenis_kelamin', 'tahun_kelahiran', 'ras_hewan', 'berat_hewan', 'id_pemilik'];
        if (!in_array($sortBy, $validColumns)) {
            $sortBy = 'id_hewan';
        }

        // 3. Mulai Query dengan EAGER LOADING
        $query = Hewan::with('pemilik');

        // 4. Filter Pencarian (Diperbaiki dengan Pengelompokan)
        $query->when($search, function($q, $search) {

            $q->where(function($subQuery) use ($search) {
                $subQuery->where('nama_hewan', 'like', "%{$search}%")
                         ->orWhere('ras_hewan', 'like', "%{$search}%")
                         ->orWhere('tahun_kelahiran', 'like', "%{$search}%")
                         ->orWhere('jenis_kelamin', 'like', "%{$search}%")

                         ->orWhereHas('pemilik', function($ownerQuery) use ($search) {
                             $ownerQuery->where('nama_lengkap', 'like', "%{$search}%");
                         });
            });
        });

        // 5. Terapkan Sorting
        $query->orderBy($sortBy, $direction);

        // 6. Siapkan Parameter Query String untuk Pagination Link
        // Ini agar saat pindah halaman, filter pencarian dan sorting tetap terbawa
        $paginationParams = [
            'keyword' => $search,
            'sort_by' => $sortBy,
            'direction' => $direction
        ];

        // 7. Eksekusi Data (Pagination)
        if ($mode === 'all') {
            //=== PAGINATE DENGAN LIMIT BESAR (Mode "Tampilkan Semua")
            // Menggunakan 5000 sebagai batas aman untuk "semua" data agar memory tidak jebol jika data jutaan.
            $hewan = $query->paginate(5000);
            $is_paginated = true; // Tetap true karena teknisnya masih objek paginator

            // Tambahkan parameter mode ke link pagination
            $paginationParams['mode'] = 'all';
        } else {
            //=== PAGINATE NORMAL (10 Data per halaman)
            $hewan = $query->paginate(10);
            $is_paginated = true;
        }

        // Tambahkan semua parameter ke link pagination sekaligus
        $hewan->appends($paginationParams);

        return view('pages.hewan.showHewan', compact('hewan', 'is_paginated'));
    }

    public function createHewan(){
        return view('pages.hewan.addHewan');
    }
    
    public function searchPemilik(Request $request)
    {
        $search = $request->get('q');

        $data = Pemilik::query()
            ->where('nama_lengkap', 'LIKE', "%{$search}%")
            ->orWhere('alamat', 'LIKE', "%{$search}%")
            ->limit(20)
            // PERBAIKAN 1: Ambil kolom 'id_pemilik' yang asli dari database
            ->get(['id_pemilik', 'nama_lengkap', 'alamat']);

        $formattedData = $data->map(function ($item) {
            return [
                // PERBAIKAN 2 (SANGAT PENTING):
                // Ambil nilai dari kolom 'id_pemilik', tapi kirim sebagai key 'id' ke Select2.
                // Kita juga memaksanya jadi string agar lebih aman.
                'id'   => (string) $item->id_pemilik, 
                
                // Text gabungan nama dan alamat
                'text' => $item->nama_lengkap . ' - ' . Str::limit($item->alamat, 50)
            ];
        });

        return response()->json($formattedData);
    }

    public function storeHewan(Request $request){
        // 1. Validasi (Seperti kode Anda)
        $validatedData = $request->validate([
            'namaHewan' => 'required|max:255',
            'rasHewan' => 'required',
            'tahunKelahiran' => 'required|numeric',
            'beratHewan' => 'required|numeric',
            'jenisKelamin' => 'required|in:Jantan,Betina',

            // --- PERHATIAN BAGIAN INI ---
            // Jika masih error "Table 'pemilik' not found", GANTI 'pemilik'
            // dengan nama tabel yang BENAR ada di database Anda (cek phpMyAdmin).
            // Contoh: 'exists:tb_pemilik,id_pemilik'
            'pemilik_id' => 'required|exists:tb_pemilik,id_pemilik',
        ], [
            'pemilik_id.required' => 'Anda harus memilih pemilik hewan.',
            'pemilik_id.exists' => 'Data pemilik yang dipilih tidak valid.',
        ]);


        // 2. MENYIMPAN DATA (INI YANG SEBELUMNYA HILANG)

        // Kita perlu memetakan nama input form (camelCase)
        // ke nama kolom database (biasanya snake_case).
        Hewan::create([
            // Nama Kolom DB  =>  Nama Input Form
            'id_pemilik'      => $request->pemilik_id,
            'nama_hewan'      => $request->namaHewan,
            'jenis_kelamin'   => $request->jenisKelamin,
            'tahun_kelahiran' => $request->tahunKelahiran,
            'ras_hewan'       => $request->rasHewan,
            'berat_hewan'     => $request->beratHewan,
        ]);


        // 3. Redirect setelah sukses
        return redirect('/hewan')->with('success','Berhasil menambahkan data hewan baru');
    }
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'id_pemilik', 'id_pemilik');
    }

    public function editHewan($id){
        $data = Hewan::findOrFail($id);

        return view('pages.hewan.editHewan',[
            'data'=>$data,
        ]);
    }

    public function updateHewan($id, Request $request){
        // 1. VALIDASI
        $validatedData = $request->validate([
            'namaHewan'      => 'required|max:255',
            'rasHewan'       => 'required|max:255',
            'tahunKelahiran' => 'required|numeric|min:1990|max:' . (date('Y') + 1),
            // Berat minimal 0.1 kg, tidak boleh negatif
            'beratHewan'     => 'required|numeric|min:0.1',
            'jenisKelamin'   => 'required|in:Jantan,Betina',
            // Validasi foreign key (sudah benar)
            'pemilik_id'     => 'required|exists:tb_pemilik,id_pemilik',
        ], [
            'pemilik_id.required' => 'Anda harus memilih pemilik hewan.',
            'pemilik_id.exists'   => 'Data pemilik yang dipilih tidak valid.',
        ]);

        // 2. PROSES UPDATE (Menggunakan findOrFail agar lebih aman)
        // Mencari data hewan, jika tidak ketemu akan otomatis menampilkan error 404
        $hewan = Hewan::findOrFail($id);

        // Melakukan update data
        $hewan->update([
            'id_pemilik'      => $request->pemilik_id,
            'nama_hewan'      => $request->namaHewan,
            'jenis_kelamin'   => $request->jenisKelamin,
            'tahun_kelahiran' => $request->tahunKelahiran,
            'ras_hewan'       => $request->rasHewan,
            'berat_hewan'     => $request->beratHewan,
        ]);

        // 3. REDIRECT (PERBAIKAN KRUSIAL: Kembali ke halaman /hewan)
        return redirect('/hewan')->with('success','Berhasil mengubah data hewan');
    }

    public function destroy($id){
        Hewan::findOrFail($id)->delete();
        return redirect('/hewan')->with('success','Menghapus data hewan');
    }
}
