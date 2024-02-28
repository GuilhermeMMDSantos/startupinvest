<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conversas;

class Startups extends Model
{
    protected $fillable = [
        'fk_user',
        'nome',
        'nif',
        'fk_setor_economico',
        'fk_fase_desenvolvimento',
        'mvp',
        'pitch_elevator',
        'pitch_deck',
        'logotipo',
        'estado_busca_invest'
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

   public function rodadaAtual(){
       return $this->hasOne('App\RodadasInvestimento','fk_startup','fk_user')->where('estado','aberta');
   }

   public function membrosEquipa(){
       return $this->hasMany('App\MembrosEquipaStartup','fk_startup','fk_user');
   }

   public function incubadorAceleradora(){
       return $this->belongsTo('App\IncubadorasAceleradoras','fk_incubadora_aceleradora','id');
   }

   public function conversas(){
    return $this->hasMany(Conversas::class,'fk_startup','fk_user');
   }
}
