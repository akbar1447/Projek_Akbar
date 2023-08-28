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
        Schema::create('brang_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nama_barang_id');
            $table->foreign('nama_barang_id')->references('id')->on('barang')->onDelete('cascade');
            $table->integer('jumlahkeluar');
            $table->string('kode_barang_keluar');
            $table->string('nama');
            $table->string('jabatan');
            $table->integer('hp');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
