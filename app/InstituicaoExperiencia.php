<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstituicaoExperiencia extends Model
{
    protected $table = "instituicoes_experincia";
    protected $fillable = [
        'nome',
        'outro'
    ];
}
