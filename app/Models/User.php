<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel jika tidak menggunakan konvensi default 'users'
    protected $table = 'users';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'role',
        'profile',
        'password'
    ];

    // Jika menggunakan kolom timestamps (created_at, updated_at), ini sudah default true.
    public $timestamps = true;
}
