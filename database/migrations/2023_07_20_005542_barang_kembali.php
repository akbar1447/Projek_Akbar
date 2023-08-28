<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang_kembali', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nama_barang_id');
            $table->integer('jumlahkembali');
            $table->enum('status', ['Baik', 'Rusak']);
            $table->string('kode_barang_kembali');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('nama_barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_kembali');
    }
};