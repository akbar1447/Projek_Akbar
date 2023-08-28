<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';

    protected $fillable = [
        'nama',
        'nama_barang_id',
        'jumlahkeluar',
        'jabatan',
        'hp',
        'keterangan',
    ];

    // Definisi relasi
    public function Barang()
    {
        return $this->belongsTo(Barang::class, 'nama_barang_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    
    public function kodeBarang()
    {
        return $this->hasMany(KodeBarang::class, 'nama_barang_id');
    }
}
