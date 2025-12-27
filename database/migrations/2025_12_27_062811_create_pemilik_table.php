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
        //Membuat tabel pemilik
        Schema::create('tb_pemilik', function (Blueprint $table) {

            $table->id('id_pemilik');
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->string('nomor_telepon');
            $table->string('email');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pemilik');
    }
};
