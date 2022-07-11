<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investidores extends Model
{
    protected $table = 'investidores';

    protected $fillable = [
        'fk_user',
        'nome',
        'sobrenome',
        'nif',
        'tipo_entidade',
        'bilhete_identidade',
        'contrato_sociedade',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'fk_user');
    }

    public function rodadas()
    {
        return $this->belongsToMany('App\RodadasInvestimento','rodadas_investidores','fk_investidor','fk_rodada','fk_user','id');
    }

    public function formacoes(){
        return $this->hasMany('App\FormacaoInvestidor','fk_investidor','fk_user');
    }

    public function experiencias(){
        return $this->hasMany('App\ExperienciaInvestidor','fk_investidor','fk_user');
    }
}
