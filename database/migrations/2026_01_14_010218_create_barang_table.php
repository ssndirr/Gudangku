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
        Schema::create('barang', function (Blueprint $table) {
            $table->BigIncrements('id_barang');
            $table->string('nama_barang');

            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')
            ->references('id_kategori')
            ->on('kategori')
            ->onDelete('cascade');

            $table->unsignedBigInteger('ruangan_id');
            $table->foreign('ruangan_id')
            ->references('id_ruangan')
            ->on('ruangan')
            ->onDelete('cascade');
            
            $table->Integer('stok');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
