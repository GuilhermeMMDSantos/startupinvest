@if ($investidor->status_investimento == 0)
@if ($rodada->estado == 'fechada' && $presentUser == $investidor->investidor->fk_user)
    @if ($investidor->contrato_mutou == null)
        <p> Contracto de Investimento Pendente.</p>
    @else
        <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
            <img src="{{ asset('assets/img/contract.png') }}"
                class="w-100 h-100" />
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal"
            data-target="#pdfModal" data-doc="{{ $investidor->contrato_mutou }}"
            data-origin=1>
            Ler Contrato
        </button><br>
        @if ($investidor->status_contrato_investidor != 2 && $investidor->status_contrato_investidor != 3)
            <button type="button" class="btn btn-primary" id="btn-discordar-contrato">Discordar
                Contrato</button>
        @endif
        @if ($investidor->status_contrato_investidor == 1)
            <p>Assinatura do Investidor em Falta.</p>
            <button type="button" class="btn btn-primary">Assinar Contrato</button>
        @elseif($investidor->status_contrato_investidor == 2)
            <p>Descordou Com os Termos do Contrato</p>
            <button type="button" class="btn btn-primary">Abrir Meeting</button>
        @elseif($investidor->status_contrato_investidor == 3)
            <p>Assinado Pelo Investidor</p>
        @endif
        @if ($investidor->status_contrato_startup == 1)
            <p>Assinatura do Sócio Fundador em Falta</p>
        @elseif($investidor->status_contrato_startup == 2)
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