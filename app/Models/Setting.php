<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings'; // Nama tabel yang digunakan

    protected $fillable = [
        'nama_toko',
        'alamat_toko',
        'nomor_telepon',
        'metode_pembayaran',
    ];
}
