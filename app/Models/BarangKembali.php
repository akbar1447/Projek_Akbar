<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKembali extends Model
{
    protected $table = 'barang_kembali';
    protected $fillable = [
        'nama_barang_id',
        'jumlahkembali',
        'status',
        'kode_barang_kembali',
        'keterangan',
    ];

    // Relasi many-to-many dengan model KodeBarang melalui tabel perantara BarangKembaliKodeBarang
    public function kodeBarang()
    {
        return $this->hasMany(KodeBarang::class, 'nama_barang_id');
    }

    // Relasi many-to-one dengan model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'nama_barang_id');
    }
}
