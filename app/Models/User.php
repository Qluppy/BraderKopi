<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'akun'; // Gunakan tabel 'pengguna'

    protected $fillable = [
        'username',
        'password',
        'isAdmin',
    ];

    protected $hidden = [
        'password', // Sembunyikan password saat serialisasi
        'remember_token',
    ];
}
