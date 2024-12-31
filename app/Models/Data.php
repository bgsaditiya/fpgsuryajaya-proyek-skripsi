<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Data extends Model
{
    use HasFactory, Searchable;

    protected $primaryKey = 'id_data';

    protected $table = 'tbdata';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'item',
        'tanggal',
    ];

}