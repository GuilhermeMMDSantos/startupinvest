<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembrosEquipaStartup extends Model
{
    protected $table = "membros_equipa_startup";
    protected $fillable = [
        'nome',
        'sobrenome',
        'fk_startup',
        'img'
    ];


    public function cargosExecutivos(){
        return $this->belongsToMany('App\CargosExecutivo','membrosequipa_cargosexecutivo_m_m','fk_membro_equipa','fk_cargo_executivo');
    }

    public function formacoes(){
        return $this->hasMany('App\FormacaoMembroEquipa','fk_membro_equipa');
    }

    public function experiencias(){
        return $this->hasMany('App\ExperienciaMembroEquipa','fk_membro_equipa');
    }
   
}
