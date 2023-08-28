<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'type',
        'tahun',
        'jumlah',
        'code',
        'gambar'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barangkeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'nama_barang_id');
    }

    public function barangmasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'nama_barang_id');
    }

    public function kodebarang()
    {
        return $this->hasMany(KodeBarang::class, 'nama_barang_id');
    }

    public function barangKembali()
    {
        return $this->hasMany(BarangKembali::class, 'nama_barang_id');
    }
}
