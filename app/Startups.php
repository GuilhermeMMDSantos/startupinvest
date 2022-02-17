<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Startups extends Model
{
    protected $fillable = [
        'fk_user',
        'nome',
        'fk_setor_economico',
        'fk_fase_desenvolvimento',
        'comprovativo_registo_empresa',
        'pitch_elevator',
        'pitch_deck',
        'logotipo',
        'estado_busca_invest',
        'fk_tipo_negocio'
    ];



    public function user(){
        return $this->belongsTo('App\User','fk_user');
    }

    public function setor(){
        return $this->belongsTo('App\Setores','fk_setor_economico');
    }

    public function fase(){
        return $this->belongsTo('App\Fases','fk_fase_desenvolvimento');
    }

    public function tipobusnessfunc(){
        return $this->belongsTo('App\TipoBusness','fk_tipo_negocio');
    }

}
