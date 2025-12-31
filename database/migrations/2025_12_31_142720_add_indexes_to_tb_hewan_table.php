<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_hewan', function (Blueprint $table) {
            // 1. INDEX FOREIGN KEY (SANGAT PENTING)
            // Mempercepat proses JOIN dan Eager Loading (with('pemilik'))
            // Mempercepat pencarian hewan berdasarkan pemiliknya.
            // Kita beri nama index custom 'idx_hewan_pemilik' agar mudah dikenali.
            $table->index('id_pemilik', 'idx_hewan_pemilik');

            // 2. INDEX UNTUK KOLOM SORTING (ORDER BY)
            // Mempercepat pengurutan data, terutama saat pagination.

            // Index untuk nama_hewan. 
            // Catatan: Ini membantu sorting 'nama_hewan ASC/DESC'.
            // Ini TIDAK membantu pencarian 'LIKE %keyword%' (wildcard di depan),
            // tapi membantu pencarian 'LIKE keyword%' (prefix search).
            $table->index('nama_hewan', 'idx_hewan_nama');

            // Index untuk tahun kelahiran (sering digunakan untuk filter range atau sorting)
            $table->index('tahun_kelahiran', 'idx_hewan_tahun');

            // Index untuk ras hewan (untuk sorting)
            $table->index('ras_hewan', 'idx_hewan_ras');
            
            // Index untuk berat hewan (untuk sorting numerik)
            $table->index('berat_hewan', 'idx_hewan_berat');

            // --- CATATAN TENTANG JENIS KELAMIN ---
            // Saya TIDAK merekomendasikan indexing 'jenis_kelamin' jika isinya hanya 
            // sedikit variasi (misal hanya 'Jantan' dan 'Betina'). 
            // Index tidak efisien pada kolom dengan "kardinalitas rendah".
            // Database biasanya lebih memilih full scan daripada memakai index untuk data seperti ini.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_hewan', function (Blueprint $table) {
            // Hapus index jika migration di-rollback.
            // Gunakan nama index yang sama dengan yang didefinisikan di method up().
            $table->dropIndex('idx_hewan_pemilik');
            $table->dropIndex('idx_hewan_nama');
            $table->dropIndex('idx_hewan_tahun');
            $table->dropIndex('idx_hewan_ras');
            $table->dropIndex('idx_hewan_berat');
        });
    }
};