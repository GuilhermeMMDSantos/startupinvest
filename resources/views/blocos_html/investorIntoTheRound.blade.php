@if ($investidor != null)
<div class="col-12">
    <div class="card">
        <div class="card-body row">
            <div class="col-sm-6 col-12">
                <p>
                    <span class="badge badge-primary">Startup</span>&nbsp;<a
                        href="{{ route('startup.perfil', $investidor->rodada->startup->user->code_user) }}"
                        style="font-size:20px;">{{ $investidor->rodada->startup->nome }}</a>

                </p>
                <p>
                    <span class="badge badge-primary">Aportado</span>&nbsp;<span style="font-size:20px;">
                        {{ number_format($investidor->valor_investido, 2, ',', '.') }} AOA</span>
                </p>
                <p>
                    <span class="badge badge-primary">Porcentagem</span>&nbsp;<span style="font-size:20px;">
                        {{ $investidor->acoes_adquirida }}%</span>
                </p>

                <div>
                    <h6 class="badge badge-primary">Confirmação da Assinatura de Contrato</h6><br>
                    @if($investidor->comprovativo_assinatura == null)
                    <div class="alert alert-info" role="alert">
                        <p style="font-size:14px;">Após as assinaturas, A startup, deve submeter um video feito pelos sócios fundadores a confirmar a assinatura do contrato com o referido investidor, qual o valor captado com o investidor e qual a porcentagem para o investidor.</p>
                    </div>
                    @else
                    <a href="{{asset('storage/'.$investidor->comprovativo_assinatura)}}" target="_blank"><i class="fas fa-film"></i> Comprovativo de Assinatura da Startup</a>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 col-12 ">
                <p style="text-align:center;"><span class="badge badge-primary">Contrato</span></p>
                <div id="investor-invest-situation-container">
                    @if ($investidor->status_investimento != 1 && $investidor->status_investimento != 2)
                    @if ( ($rodada->estado == 'fechada' || $rodada->estado == 'sucedida') && $presentUser == $investidor->investidor->fk_user)
                    @if ($investidor->contrato_mutou == null)
                    <p style="text-align:center; font-size:12px;"> Contracto de Investimento Pendente.</p>
                    @else
                    <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                        <img src="{{ asset('assets/img/contract.png') }}"
                            class="w-100 h-100" />
                    </div>


                    @if ($investidor->status_contrato_investidor == 1)
                    <p style="text-align:center; font-size:12px;">Assinatura do Investidor em Falta.</p>

                    @elseif($investidor->status_contrato_investidor == 3)
                    <p style="text-align:center; font-size:12px;">Descordou Com os Termos do Contrato</p>

                    @elseif($investidor->status_contrato_investidor == 4)
                    <p style="text-align:center; font-size:12px;">Assinado Pelo Investidor</p>
                    @endif


                    @if ($investidor->status_contrato_startup == 1)
                    <p style="text-align:center; font-size:12px;">Assinatura do Sócio Fundador em Falta</p>
                    @elseif($investidor->status_contrato_startup == 4)
                    <p style="text-align:center; font-size:12px;">Assinado Pelo Sócio Fundador</p>
                    @endif


                    @endif

                    @elseif($rodada->estado == 'aberta')
                    Captando...
                    @endif
                    @elseif($investidor->status_investimento == 1)
                    Investimento Reembolsado.
                    @elseif($investidor->status_investimento == 2)
                    Investimento Não Reembolsado
                    @endif



                </div>
            </div>


        </div>

        <div class="card-footer text-right bg-light">

            @if (($rodada->estado == 'fechada' || $rodada->estado == 'sucedida') && $presentUser == $investidor->investidor->fk_user)
            @if ($investidor->contrato_mutou != null)

            @if($rodada->estado == 'sucedida')

            <a rule="button" href="{{asset('storage/'.$investidor->contrato_mutou)}}" target="_blank" class="btn btn-primary">
                <i class="fas fa-file-contract"></i> Ler Contrato
            </a>

            @else

            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#pdfModal" data-doc="{{ $investidor->contrato_mutou }}"
                data-origin=1>
                <i class="fas fa-file-contract"></i> Ler Contrato
            </button>

            @endif

            @if ($investidor->status_contrato_investidor == 1)
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#pdfModal"
                data-doc="{{ $investidor->contrato_mutou }}"
                data-idinvestor="{{ $investidor->fk_investidor }}"
                data-origin=2>
                <i class="fas fa-pen"></i> Assinar Contrato
            </button>
            @elseif($investidor->status_contrato_investidor == 3)
            <a rule="button" href="{{route('mensagens_post',['id_other' => $rodada->fk_startup])}}" class="btn btn-outline-primary"><i class="fas fa-comments"></i> Iniciar Meeting</a>
            @endif

            @if ($investidor->status_contrato_investidor != 4 && $investidor->status_contrato_investidor != 3)
            <button type="button" class="btn btn-outline-danger" id="btn-discordar-contrato"><i class="fas fa-ban"></i> Discordar Contrato</button>
            @endif

            @endif
            @endif
        </div>

    </div>
</div>
@endif