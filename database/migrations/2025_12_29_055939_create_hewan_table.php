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
        Schema::create('tb_hewan', function (Blueprint $table) {

            $table->id('id_hewan');
            $table->unsignedBigInteger('id_pemilik');
            $table->string('nama_hewan');
            $table->enum('jenis_kelamin',['Jantan', 'Betina']);
            $table->year('tahun_kelahiran');
            $table->string('ras_hewan');
            $table->decimal('berat_hewan', total: 10, places: 2);

            //Relasi Pemilik-Hewan
            $table->foreign('id_pemilik')->references('id_pemilik')->on('tb_pemilik')->onDelete('cascade');

            
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_hewan');
    }
};
