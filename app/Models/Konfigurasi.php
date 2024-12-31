<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_konf';

    protected $table = 'tbkonfigurasi';
    public $timestamps = false;
    
    protected $fillable = [
        'jum_data',
        'max_rule',
        'tgl_awal',
        'tgl_akhir',
    ];
}