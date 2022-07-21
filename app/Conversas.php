<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Startups;
use App\Investidores;
use App\Mensagens;

class Conversas extends Model
{
  protected $table = "conversas";
  protected $fillable = [
    'fk_startup',
    'fk_investidor'
  ];

  public function startup(){
    return $this->belongsTo(Startups::class,'fk_startup','fk_user');
  }

  public function investidor(){
    return $this->belongsTo(Investidores::class,'fk_investidor','fk_user');
  }

  public function mensagens(){
    return $this->hasMany(Mensagens::class,'fk_conversa','id');
  }
}
