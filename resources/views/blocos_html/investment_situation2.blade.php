@if ($investidor->status_investimento == 0)
    @if ($rodada->estado == 'fechada' && $presentUser == $rodada->fk_startup)
        @if ($investidor->contrato_mutou == null)
            <p> Contracto de Investimento Pendente.</p>
            <input type="file" class="field-contract-2" linker="{{ $investidor->fk_investidor }}" accept=".pdf"
                name="contrato_investimento" id="load-contrato-investimento{{ $investidor->fk_investidor }}" hidden>
            <label type="button" class="btn btn-primary" for="load-contrato-investimento{{ $investidor->fk_investidor }}"
                style="font-size:14px;border-radius:20px;margin-top:5px;">Adicionar
                Contrato</label>
        @else
            <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                <img src="{{ asset('assets/img/contract.png') }}" class="w-100 h-100" />
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdfModal"
                data-doc="{{ $investidor->contrato_mutou }}" data-origin=1>
                Ler Contrato
            </button>

            @if ($investidor->status_contrato_investidor != 3 && $investidor->status_contrato_startup != 2)
                <button class="btn btn-primary btn-eliminar-contrato" linker="{{ $investidor->fk_investidor }}"
                    style="font-size:12px;margin-top:5px;">Eliminar
                    Contrato</button>
            @endif

            @if ($investidor->status_contrato_investidor == 2)
                <p>Investidor Discorda Com os Termos do Contrato.</p>
                <button class="btn btn-primary" style="font-size:12px;margin-top:5px;">Iniciar
                    Meeting</button><br>
            @elseif($investidor->status_contrato_investidor == 1)
                <p>Assinatura do Investidor em Falta.</p>
            @elseif($investidor->status_contrato_investidor == 3)
                <p>Assinado Pelo Investidor</p>
            @endif

            @if ($investidor->status_contrato_startup == 1)
                <p>Assinatura do Sócio Fundador em Falta</p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdfModal"
                    data-doc="{{ $investidor->contrato_mutou }}" data-idinvestor="{{ $investidor->fk_investidor }}"
                    data-origin=2>
                    Assinar Contrato
                </button>
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
