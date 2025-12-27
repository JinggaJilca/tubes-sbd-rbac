<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    //Inisialisasi tabel pemilik
    protected $table = 'tb_pemilik';
    public $timestamps = false;

    protected $primaryKey = 'id_pemilik';
    
    protected $fillable = ['nama_lengkap', 'alamat', 'nomor_telepon', 'email'];
    /*
    KOLOM YANG TIDAK BOLEH DIISI
    protected $guarded = [...]
    */
}
