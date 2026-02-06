<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'custo',
        'data_limite',
        'ordem_apresentacao',
    ];

    protected $casts = [
        'data_limite' => 'date',
    ];
}
