<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RodadasInvestidores extends Model
{
    protected $table = "rodadas_investidores";

    protected $fillable = [
        'fk_rodada',
        'fk_investidor',
        'valor_investido',
        'acoes_adquirida',
        'contrato_mutou',
        'status_contrato_investidor',
        'status_contrato_startup',
        'status_investimento',
        'contrato_mutou_aprovado',
        'contrato_mutou_original'
    ];

    public function rodada(){
       return  $this->belongsTo('App\RodadasInvestimento','fk_rodada');
    }

    public function investidor(){
        return  $this->belongsTo('App\Investidores','fk_investidor','fk_user');
     }

}
