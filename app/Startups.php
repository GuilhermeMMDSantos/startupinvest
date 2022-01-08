<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Startups extends Model
{
    protected $fillable = [
        'id_user','nome','setor_atividade','fase_desenvolvimento','comprovativo_registo','pitch_elevator','img'
    ];



    public function user(){
        return $this->belongsTo('App\User','id_user');
    }

    public function setor(){
        return $this->belongsTo('App\Setores','setor_atividade','id');
    }

    public function fase(){
        return $this->belongsTo('App\Fases','fase_desenvolvimento','id');
    }

    public function tipobusnessfunc(){
        return $this->belongsTo('App\TipoBusness','tipobusness','id');
    }

}
