<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbuser';

    protected $primaryKey = 'username';
    
    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'username',
        'password',
        'nama',
        'jenis',
    ];

    protected $hidden = [
        'password',
    ];
}