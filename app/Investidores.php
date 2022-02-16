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
        'video_validar'
    ];

    public function user(){
        return $this->belongsTo('App\User','fk_user');
    }


    
}
