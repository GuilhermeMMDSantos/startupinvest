<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conversas;

class Mensagens extends Model
{
    protected $table = "mensagens";
    protected $fillable = [
        
        'fk_remetente',
        'fk_destinatario',
        'conteudo'
    ];


    public function remetente(){
        return $this->belongsTo(User::class,'fk_remetente','id');
    }

    public function destinatario(){
        return $this->belongsTo(User::class,'fk_destinatario','id');
    }
}
