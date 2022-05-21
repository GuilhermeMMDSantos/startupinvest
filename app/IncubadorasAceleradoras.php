<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncubadorasAceleradoras extends Model
{
  protected $table = "incubadora_aceleradora";
  protected $fillable = [
      'nome',
      'nif',
      'outro'
  ];
}
 