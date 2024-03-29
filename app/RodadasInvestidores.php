<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RodadasInvestidores extends Model
{
    protected $table = "rodadas_investidores";

    public function rodada(){
       return  $this->belongsTo('App\RodadasInvestimento','fk_rodada');
    }
}
