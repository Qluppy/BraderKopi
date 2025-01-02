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
        'satuan', // Tambahkan satuan di sini
        'jenis_bahan',
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
