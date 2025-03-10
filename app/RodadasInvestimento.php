<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RodadasInvestimento extends Model
{
    protected $table = "rodadas_investimento";
    protected $fillable = [
        'fk_startup',
        'valor_objetivo',
        'valor_objetivo_sem_taxa',
        'valor_obtido',
        'oferta_acoes',
        'max_investidores',
        'valor_minimo_investimento',
        'data_limite',
        'estado',
        'potencial_de_crescimento',
        'comprovativo'
    ];


    public function investidores(){
        return $this->belongsToMany('App\Investidores','rodadas_investidores','fk_rodada','fk_investidor','id','fk_user');
    }

    public function investidoresNaRodada(){
        return $this->hasMany('App\RodadasInvestidores','fk_rodada','id');
    }

    public function startup(){
        return $this->belongsTo('App\Startups','fk_startup','fk_user');
    }

    public function finalidadesInvestimento(){
        return $this->hasMany('App\FinalidadesInvestimento','fk_rodada','id');
    }
}
