<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormacaoMembroEquipa extends Model
{
    protected $table = "formacao_membro_equipa";
    protected $fillable = [
        'fk_membro_equipa',
        'fk_area_formacao',
        'fk_certificado_formacao',
        'data_inicio',
        'data_fim'
    ];
    
    public function areafuncao(){
        return $this->belongsTo('App\AreasFormacao','fk_area_formacao');
    }

    public function certificado(){
        return $this->belongsTo('App\CertificadosFormacao','fk_certificado_formacao');
    }
}
