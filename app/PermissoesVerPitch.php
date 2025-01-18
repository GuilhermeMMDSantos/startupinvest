<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissoesVerPitch extends Model
{
    /* Apesar de chamar-se permissao ver pitch
    só pode ver pitch quem tem permissao
    só pode investir quem tem permissao ver pitch
    só pode enviar mensagem quem tem permissão(ativo ou livre) de ver pitch (a caixa de entrada de texto não aparece)

    Como o pagamento é por referência:
    Caso ele gere referência, a permissão só é expirada caso a referencia também expire.
    */
    protected $table = "permissoes_ver_pitch";
    protected $fillable = [
        'fk_startup',
        'fk_investidor',
        'data_permissao',//Valor padrão deve ser NULL
        'estado', /* espera, ativo, expirada, livre; 
        24h após a solicitacao(created_at) o estado espera torna-se expirada. 
        24h após a data de permissao o ativo torna-se expirado. quando expirado. Pode ser novamente solicitada(cria nova tupla na BD). 
        Caso já tenha investido na rodada, o estado é livre(tem permissão enquanto a a rodada existir).
        */
        'fk_rodada'
    ];
}
