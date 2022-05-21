<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestidoresDaStartup extends Model
{
    protected $table = "investidores_da_startup";

    protected $fillable = [
        'email',
        'nome',
        'sobrenome',
        'fk_startup',
        'porcentagem_na_startup',
        'tipo_entidade'
    ];
}
