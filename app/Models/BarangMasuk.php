<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'nama_barang_id',
        'jumlahmasuk',
        'kode_barang_masuk',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'nama_barang_id', 'id');
    }

}
