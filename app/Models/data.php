<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    use HasFactory;

    protected $fillable = [
        'mes_real',
        'cod',
        'nombre',
        'umd',
        'numero',
        'fecha',
        'anopro',
        'mespro',
        'sujeba',
        'nombre_sujeba',
        'cantidad',
        'totpes',
    ];
}
