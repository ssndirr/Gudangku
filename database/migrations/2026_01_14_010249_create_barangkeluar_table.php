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
        Schema::create('barangkeluar', function (Blueprint $table) {
            $table->id('id_keluar');
            
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')
            ->references('id_barang')
            ->on('barang')
            ->onDelete('cascade');

            $table->date('tanggal_keluar');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangkeluar');
    }
};
