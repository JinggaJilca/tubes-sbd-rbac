<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pemilik;

class Hewan extends Model
{
    use HasFactory;

    protected $table = 'tb_hewan'; 
    protected $primaryKey = 'id_hewan';
    public $timestamps = false;
    protected $fillable = [
        'nama_hewan',     
        'ras_hewan',      
        'tahun_kelahiran',
        'berat_hewan',    
        'jenis_kelamin',  
        'id_pemilik',
    ];

    public function pemilik()
    {
        /**
         * Logika: "Satu data HEWAN ini DIMILIKI OLEH satu PEMILIK."
         *
         * Parameter 1: Class model tujuan (Pemilik::class)
         * Parameter 2: Nama kolom foreign key di tabel 'tb_hewan' (milik model ini)
         * Parameter 3: Nama kolom primary key di tabel 'tb_pemilik' (milik model tujuan)
         */
        // SESUAIKAN 'id_pemilik' DENGAN NAMA KOLOM DI DATABASE ANDA!
        return $this->belongsTo(Pemilik::class, 'id_pemilik', 'id_pemilik');
    }
}