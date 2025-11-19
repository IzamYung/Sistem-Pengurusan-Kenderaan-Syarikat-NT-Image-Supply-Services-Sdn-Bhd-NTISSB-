<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; 
    protected $primaryKey = 'id_pekerja'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pekerja', 
        'nama',
        'jawatan',
        'email',
        'password',
        'no_tel',
        'gambar_profil',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

