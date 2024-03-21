<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdemTransferencia extends Model
{
    protected $table = "ordens_de_tranferencia";

    protected $fillable = [
        'fk_forma_pagamento',
        'fk_ordenante',
        'fk_beneficiario',
        'montante',
        'status'
    ];
}
