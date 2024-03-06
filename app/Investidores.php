<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conversas;

class Investidores extends Model
{
    protected $table = 'investidores';

    protected $fillable = [
        'fk_user',
        'nome',
        'sobrenome',
        'bilhete_identidade',
        'foto',
        'video_investidor'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'fk_user');
    }

    public function rodadas()
    {
        return $this->belongsToMany('App\RodadasInvestimento','rodadas_investidores','fk_investidor','fk_rodada','fk_user','id');
    }

    public function conversas(){
        return $this->hasMany(Conversas::class,'fk_investidor','fk_user');
    }

}
