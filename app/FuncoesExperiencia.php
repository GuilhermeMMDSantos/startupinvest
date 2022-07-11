<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuncoesExperiencia extends Model
{
    protected $table = "funcoes_experiencia";
    protected $fillable = [
        'nome',
        'outro'
    ];
}
