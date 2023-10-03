<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciasPagamento extends Model
{
    protected $table = "referencias_pagamento";
    protected $fillable = [
        'referencia',
        'fk_rodada_investimento',
        'fk_investidor',
        'valor_monetario',
        'status'
    ];

    public function investidor(){
        return $this->belongsTo('App\Investidores','fk_investidor','fk_user');
    }
}
