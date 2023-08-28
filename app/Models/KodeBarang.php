<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBarang extends Model
{
    use HasFactory;

    protected $table = 'kode_barang';

    protected $fillable = [
        'nama_barang_id',
        'barang_keluar_id',
        'code',
        'status',
        'keterangan',
    ];  

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'nama_barang_id');
    }
    
    public function barangKeluar()
    {
        return $this->hasMany(BarangKembali::class, 'nama_barang_id');
    }
}
