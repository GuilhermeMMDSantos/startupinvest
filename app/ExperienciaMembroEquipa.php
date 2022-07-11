<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienciaMembroEquipa extends Model
{
    protected $table = "experiencia_membro_equipa";
    protected $fillable = [
        'fk_membro_equipa',
        'fk_funcao',
        'fk_instituicao',
        'data_inicio',
        'data_fim'
    ];

    public function funcao(){
        return $this->belongsTo('App\FuncoesExperiencia','fk_funcao');
    }

    public function instituicao(){
        return $this->belongsTo('App\InstituicaoExperiencia','fk_instituicao');
    }
}
