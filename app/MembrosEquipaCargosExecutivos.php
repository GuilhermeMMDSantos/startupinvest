<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembrosEquipaCargosExecutivos extends Model
{
    protected $table = "membrosequipa_cargosexecutivo_m_m";
    protected $fillable = [
        'fk_cargo_executivo',
        'fk_membro_equipa'
    ];
}
