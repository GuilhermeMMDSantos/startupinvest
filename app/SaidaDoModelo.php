<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaidaDoModelo extends Model
{
    protected $table = "saida_do_modelo";
    protected $fillable = [
        'id_rodada',
        'variavel',
        'valor',
        'classificacao'
    ];
}
