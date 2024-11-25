<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // Nama tabel

    protected $fillable = [
        'akun', // Relasi ke pengguna
        'total_harga', 
        'nama_pembeli', 
        'tanggal_transaksi', 
        'metode_pembayaran',
    ];

    /**
     * Relasi ke model User (pemilik akun).
     */
    public function akun()
    {
        return $this->belongsTo(User::class, 'akun', 'id');
        // Foreign key: 'akun', primary key di users: 'id'
    }

    /**
     * Relasi ke model DetailTransaksi.
     */
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'idtransaksi', 'id');
        // Foreign key di tabel detail_transaksi: 'idtransaksi'
    }
}
