<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
            Schema::table('tb_pemilik', function (Blueprint $table) {
                // Menambahkan Index untuk kolom yang sering dicari/diurutkan
                $table->index('nama_lengkap');   // Mempercepat pencarian nama & sorting nama
                $table->index('alamat');         // Mempercepat pencarian alamat
                $table->index('nomor_telepon');  // Opsional: jika sering dicari
                
                // Catatan: 'id_pemilik' biasanya sudah otomatis ter-index karena dia Primary Key
            });
        }

        public function down()
        {
            Schema::table('pemilik', function (Blueprint $table) {
                // Hapus index jika migration di-rollback
                $table->dropIndex(['nama_lengkap']);
                $table->dropIndex(['alamat']);
                $table->dropIndex(['nomor_telepon']);
            });
        }
};
