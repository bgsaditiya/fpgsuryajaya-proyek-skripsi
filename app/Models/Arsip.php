<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rule;
use App\Models\User;
use App\Models\Konfigurasi;

class Arsip extends Model
{
    use HasFactory;

    protected static function boot(){
        parent::boot();
 
        static::created(function ($model) {
            $model->id_rule = $model->id_arsip;
            $model->id_konf = $model->id_arsip;
            $model->save();
        });
    }

    protected $table = 'tbarsip';

    public $timestamps = false;

    protected $primaryKey = 'id_arsip';

    protected $fillable = [
        'id_arsip',
        'id_rule',
        'username',
        'id_konf',
        'tgl_analisis',
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class, 'id_rule', 'id_rule');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function konfigurasi()
    {
        return $this->belongsTo(Konfigurasi::class, 'id_konf', 'id_konf');
    }
}