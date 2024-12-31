<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'tbrule';

    public $timestamps = false;

    protected $primaryKey = 'id_rule';

    protected $casts = [
        'item_ante' => 'array',
        'item_cons' => 'array',
        'nilai_supp' => 'array',
        'nilai_conf' => 'array',
        'nilai_lift' => 'array',
    ];


    protected $fillable = [
        'id_rule',
        'item_ante',
        'item_cons',
        'nilai_supp',
        'nilai_conf',
        'nilai_lift',
    ];
}