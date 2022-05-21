<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RodadasInvestimento extends Model
{
    protected $table = "rodadas_investimento";

    public function investidores(){
        return $this->belongsToMany('App\Investidores','rodadas_investidores','fk_rodada','fk_investidor','id','fk_user');
    }

    public function finalidadesInvestimento(){
        return $this->hasMany('App\FinalidadesInvestimento','fk_rodada','id');
    }
}
