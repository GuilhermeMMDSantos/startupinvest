<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissoesVerPitch extends Model
{
    protected $table = "permissoes_ver_pitch";
    protected $fillable = [
        'fk_startup',
        'fk_investidor',
        'data_permissao',
        'estado'
    ];
}
