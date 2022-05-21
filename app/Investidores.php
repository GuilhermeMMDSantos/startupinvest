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
        'video_validar',
        'img'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'fk_user');
    }

    public function rodadas()
    {
        return $this->belongsToMany('App\RodadasInvestimento','rodadas_investidores','fk_investidor','fk_rodada');
    }
}
