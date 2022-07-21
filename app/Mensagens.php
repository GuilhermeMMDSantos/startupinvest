<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conversas;

class Mensagens extends Model
{
    protected $table = "mensagens";
    protected $fillable = [
        'fk_conversa',
        'fk_remetente',
        'fk_destinatario',
        'conteudo'
    ];

    public function conversa(){
        return $this->belongsTo(Conversas::class,'fk_conversa','id');
    }

    public function remetente(){
        return $this->belongsTo(User::class,'fk_remetente','id');
    }
}
