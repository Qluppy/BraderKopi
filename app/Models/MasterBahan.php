<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterBahan extends Model
{
    use HasFactory;
    
    protected $table = 'master_bahan';

    protected $fillable = [
        'nama_bahan',
        'deskripsi_bahan',
        'jumlah_stok', // Pastikan ini juga ada
        'satuan', // Tambahkan satuan di sini
    ];

    public function stok()
    {
        return $this->hasMany(Stok::class, 'idbahan');
    }

    public function produkBahan()
    {
        return $this->hasMany(ProdukBahan::class, 'idbahan');
    }
}
