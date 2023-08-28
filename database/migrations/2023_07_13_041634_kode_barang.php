<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('kode_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nama_barang_id');
            $table->unsignedBigInteger('barang_keluar_id')->nullable();
            $table->enum('status',['Tersedia','Keluar','Tidak Bisa Digunakan'])->default('Tersedia');
            $table->text('keterangan')->default('Tersedia');
            $table->string('code');
            $table->timestamps();

            $table->foreign('nama_barang_id')->references('id')->on('barang')->onDelete('cascade');
            $table->foreign('barang_keluar_id')->references('id')->on('barang_keluar')->onDelete('set null');
        });
    }

    /**
     * Mengembalikan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_barang');
    }
};
