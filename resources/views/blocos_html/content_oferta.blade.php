<div class="col-12 col-sm-8" style="padding-top:10px;">
    <div class="card shadow-sm" id="card-video">
        <div class="card-body ">
            <h5 class="card-title decoration-underline badge badge-warning ml-2" style="font-size:20px;">Pitch</h5>
            <video class="w-100 rounded" controls>
                <source src="@if ($havePermissionToWatchPitch || $myprofile) {{ asset('storage/' . $startup->pitch_deck) }} @endif"
                    type="video/mp4">
                Seu navegador não suporta vídeos.
            </video>
        </div>
    </div>


</div>


<div class="col-sm-4" style="padding-top:10px;">
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            @if (!empty($rodada))
                <h5 class="card-title text-center font-weight-bold">
                    Rodada
                    @if ($rodada->estado == 'aberta')
                        <span class="badge badge-warning ml-2" style="font-size:14px;">Faltam
                            {{ $rodada->tempo_restante }} Dias</span>
                    @elseif ($rodada->estado == 'fechada')
                        <span class="badge badge-success ml-2">Terminada</span>
                    @elseif ($rodada->estado == 'anulada')
                        <span class="badge badge-danger ml-2">Cancelada</span>
                    @endif
                </h5>
                <hr>
                <div class="text-center mb-3">
                    <span class="font-weight-bold d-block">Meta</span>
                    <h5 class="text-success">{{ number_format($rodada->valor_objetivo, 2, ',', '.') }} AOA</h5>
                </div>
                <div class="text-center mb-3">
                    <span class="font-weight-bold d-block">Oferta</span>
                    <h5 class="text-success">{{ $rodada->oferta_acoes }}% Participação Societária</h5>
                </div>
                <div class="text-center mb-3">
                    <span class="font-weight-bold d-block">Valor Mínimo a Investir</span>
                    <h5 class="text-success">{{ number_format($rodada->valor_minimo_investimento, 2, ',', '.') }} AOA
                    </h5>
                </div>
                <div class="text-center mb-3">
                    <span class="font-weight-bold d-block">Captado</span>
                    <h5 class="text-success">{{ number_format($rodada->valor_obtido, 2, ',', '.') }} AOA</h5>
                </div>
                <div class="text-center mb-4">
                    <span class="font-weight-bold d-block">Investidores na Rodada</span>
                    <h5 class="text-success">{{ count($rodada->investidoresNaRodada) }}</h5>
                </div>

                @if ($havePermissionToWatchPitch && $participanteNaRodada == null)
                    <div class="d-flex justify-content-center">
                        @if ($referenceValue != null)
                            <p>Referência Bancária</p>
                            <p>{{$referenceValue}}</p>
                        @else
                            <button id="btn-participar-rodada" data-toggle="modal" data-target="#modal-investir"
                                class="btn btn-lg btn-success btn-block">
                                Participar na rodada
                            </button>
                        @endif

                    </div>
                @elseif($participanteNaRodada != null)
                    <div class="text-center mb-3">

                        <span class="font-weight-bold d-block" style="background: #e8f5e9;">
                            @if ($rodada->estado == 'anulada')
                                Valor Investido (Reembolsável)
                            @else
                                Valor Investido
                            @endif
                        </span>
                        <h5 class="text-success">
                            {{ number_format($participanteNaRodada->valor_investido, 2, ',', '.') }}
                            AOA</h5>
                    </div>
                @elseif($rodada->estado == 'aberta' && !$myprofile)
                    <div class="alert alert-info text-center" role="alert">
                        Solicite o pitch da startup<br>
                        Assista o pitch da startup<br>
                        Participe da rodada de investimento<br>
                    </div>
                @endif


                @if ($rodada->estado == 'fechada' && ($myprofile || $participanteNaRodada != null))
                    <a href="{{ route('rodada.page', $rodada->id) }}" rule="button"
                        class="btn btn-lg btn-success btn-block">Assinar contrato</a>
                @elseif($myprofile || $participanteNaRodada != null)
                    <a href="{{ route('rodada.page', $rodada->id) }}" rule="button"
                        class="btn btn-lg btn-success btn-block">Detalhes</a>
                @endif
            @else
                <div class="text-center">
                    <img src="{{ asset('assets/img/experiencia1.png') }}" alt="Sem oferta declarada"
                        style="width:60px;height:60px;margin:auto;">
                    <p class="mt-3 font-weight-bold" style="font-size:18px;">Sem Oferta Declarada</p>
                    <p class="text-muted" style="font-size:15px;">Startup Não Está a Buscar Investimento no Momento</p>
                </div>
            @endif
        </div>
    </div>
</div>
