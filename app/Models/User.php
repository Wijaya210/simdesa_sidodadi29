<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'no_kk',
        'alamat',
        'rt_rw',
        'pekerjaan',
        'jenis_kependudukan',
        'no_hp',
        'jenis_kelamin',
        'tanggal_lahir',
        'is_admin_added',
        'is_registered',
        'otp',
        'otp_expires_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', // otomatis hash password
    ];
}
