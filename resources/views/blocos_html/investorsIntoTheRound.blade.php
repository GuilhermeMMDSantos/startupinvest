@forelse($investidores as $investidor)
<div class="col-sm-6 col-12">
    <div class="card  h-100">
        <div class="card-body row card-investor-rodada">
            <div class="col-12 col-sm-8">
                <p>
                    <span class="badge badge-primary">Investidor</span>&nbsp;<a
                        href="{{ route('startup.perfil', $investidor->investidor->user->code_user) }}">{{ $investidor->investidor->nome_completo }}</a>
                </p>
                <p>
                    <span
                        class="badge badge-primary">Aportado</span>&nbsp;<span>{{ number_format($investidor->valor_investido, 2, ',', '.') }}
                        AOA</span>
                </p>
                <p>
                    <span class="badge badge-primary">Porcentagem</span>&nbsp;<span>
                        {{ $investidor->acoes_adquirida }}%</span>
                </p>
            </div>
            <div class="col-12 col-sm-4" style="text-align:center;">
                <p style="text-align:center;"><span class="badge badge-primary">Situação</span></p>
                <div id="situation-container{{ $investidor->fk_investidor }}"
                    class="situation-container">
                    @if ($investidor->status_investimento == 0)
                    @if ($rodada->estado == 'fechada' && $presentUser == $rodada->fk_startup)
                    @if ($investidor->contrato_mutou == null)
                    <p style="text-align:center;"> Contracto de Investimento Pendente.</p>
                    <input type="file" class="field-contract-2"
                        linker="{{ $investidor->fk_investidor }}" accept=".pdf"
                        name="contrato_investimento"
                        id="load-contrato-investimento{{ $investidor->fk_investidor }}"
                        hidden>

                    @else
                    <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                        <img src="{{ asset('assets/img/contract.png') }}"
                            class="w-100 h-100" />
                    </div>


                    @if ($investidor->status_contrato_investidor == 3)
                    <p style="text-align:center;">Investidor Discorda Com os Termos do Contrato.</p>

                    @elseif($investidor->status_contrato_investidor == 1)
                    <p style="text-align:center;">Assinatura do Investidor em Falta.</p>
                    @elseif($investidor->status_contrato_investidor == 2)
                    <p style="text-align:center;">Assinado Pelo Investidor</p>
                    @endif

                    @if ($investidor->status_contrato_startup == 1)
                    <p style="text-align:center;">Assinatura do Sócio Fundador em Falta</p>

                    @elseif($investidor->status_contrato_startup == 4)
                    <p style="text-align:center;">Assinado Pelo Sócio Fundador</p>
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
                </div>
            </div>
        </div>




        <div class="card-footer text-right bg-light situation-container">

            @if ($investidor->status_investimento == 0)
            @if ($rodada->estado == 'fechada' && $presentUser == $rodada->fk_startup)
            @if ($investidor->contrato_mutou == null)
            <label type="button" class="btn btn-outline-primary"
                for="load-contrato-investimento{{ $investidor->fk_investidor }}"
                ><i class="fas fa-file-contract"></i> Adicionar
                Contrato</label>
            @endif
            @endif
            @endif


            @if ($investidor->contrato_mutou != null)
            <button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#pdfModal"
                data-doc="{{ $investidor->contrato_mutou }}" data-origin=1>
                <i class="fas fa-file-contract"></i> Ler Contrato
            </button>

            @if ($investidor->status_contrato_investidor != 2)
            <button class="btn btn btn-outline-danger btn-eliminar-contrato"
                linker="{{ $investidor->fk_investidor }}"
                ><i class="fas fa-ban"></i> Eliminar
                Contrato</button>
            @endif

            @if ($investidor->status_contrato_investidor == 3)
            <a rule="button" href="{{route('mensagens_post',['id_other' => $investidor->fk_investidor])}}" class="btn btn-outline-primary"><i class="fas fa-comments"></i> Iniciar Meeting</a><br>
            @endif

            @if ($investidor->status_contrato_startup == 1 && $investidor->status_contrato_investidor != 3)
            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                data-target="#pdfModal"
                data-doc="{{ $investidor->contrato_mutou }}"
                data-idinvestor="{{ $investidor->fk_investidor }}"
                data-origin=2>
                <i class="fas fa-pen"></i> Assinar Contrato
            </button>
            @endif
            @endif
        </div>

    </div>
</div>
@empty
<div class=" col-12 d-flex align-items-center justify-content-center" style="min-height:200px;">
    <h2 style="font-size:25px;">Nenhum @if ($investidor != null)
        outro
        @endif Investidor Participou da Rodada.
    </h2>
</div>
@endforelse