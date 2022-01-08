<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PotenciaisInvestidores extends Model
{
    protected $table = 'potenciais_investidores';
    
    protected $fillable = [
        'id_user','nome','sobrenome','nif','id_nacionalidade','id_tipo_entidade'
    ];

    public function user(){
        return $this->belongsTo('App\User','id_user');
    }

    public function nacionalidade(){
        return $this->belongsTo('App\Nacionalidades','id_nacionalidade'); 
    }

    public function tipoentidade(){
        return $this->belongsTo('App\TiposEntidades','id_tipo_entidade'); 
    }
    
}
