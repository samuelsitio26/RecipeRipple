<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'nomor_telepon',
        'password',
        'profile_image', // Kolom tambahan jika ada
        'google_id',
        'google_token',
        'google_refresh_token',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



}
