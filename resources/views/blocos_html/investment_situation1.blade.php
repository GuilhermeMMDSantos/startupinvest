@if($investidor->status_investimento == 0)
@if ($rodada->estado == 'fechada' && $presentUser==$investidor->investidor->fk_user)
@if($investidor->contrato_mutou == NULL)
<p> Contracto de Investimento Pendente.</p>
@else
<div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
    <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
</div>
<button>Visualizar Contrato</button><br>
@if($investidor->status_contrato_investidor != 3 && $investidor->status_contrato_investidor != 4)
<button>Discordar Contrato</button>
@endif
@if($investidor->status_contrato_investidor == 1)
<p>Assinatura do Investidor em Falta.</p>
<button>Assinar Contrato</button>
@elseif($investidor->status_contrato_investidor == 3)
<p>Descordou Com os Termos do Contrato</p>
<button>Abrir Meeting</button>
@elseif($investidor->status_contrato_investidor == 4)
<p>Assinado Pelo Investidor</p>
@endif
@if($investidor->status_contrato_startup == 1)
<p>Assinatura do Sócio Fundador em Falta</p>
@elseif($investidor->status_contrato_startup == 4)
<p>Assinado Pelo Sócio Fundador</p>
@endif
@endif
@elseif($rodada->estado == 'aberta')
Investimento Captado.
@endif
@elseif($investidor->status_investimento == 1)
Investimento Reembolsado.
@elseif($investidor->status_investimento == 2)
Investimento Não Reembolsado
@endif