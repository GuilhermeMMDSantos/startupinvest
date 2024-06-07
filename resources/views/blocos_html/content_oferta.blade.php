<div class="col-12 col-sm-8" style="padding-top:10px;">
    <div class="card" id="card-video">
        <div class="card-body " style="padding-bottom:30px;">
            <video style="border:2px solid #e9ecef9c;" src="@if($havePermissionToWatchPitch || $myprofile){{asset('storage/'.$startup->pitch_deck)}}@endif" width="100%" height="80%" controls="true">
            </video>

        </div>
    </div>
</div>
<div class="col-sm-4" style="padding-top:10px;">
    <div class="card mb-3">
        <div class="card-body">
            @if(!empty($rodada))
            <h5 class="card-title" style="text-align:center;">Oferta
                @if($rodada->estado == 'aberta')
                <span style="font-size:14px;">- Faltam {{$rodada->tempo_restante}} Dias </span>
                @elseif ($rodada->estado == 'fechada')
                <span style="color:#379f4f;"> Terminada</span>
                @elseif ($rodada->estado == 'anulada')
                <span style="color:red;"> Cancelada</span>
                @endif
            </h5>
            <hr>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Busco</span>
                <h5 style="color:green;text-align:center;">{{number_format($rodada->valor_objetivo,2,',','.')}} AOA</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Por</span>
                <h5 style="color:green;text-align:center;">{{$rodada->oferta_acoes}}% Participação Societária</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Valor Mínimo a Investir</span>
                <h5 style="color:green;text-align:center;">{{number_format($rodada->valor_minimo_investimento,2,',','.')}} AOA</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Já Consegui</span>
                <h5 style="color:green;text-align:center;">{{number_format($rodada->valor_obtido,2,',','.')}} AOA</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Investidores Na Rodada</span>
                <h5 style="color:green;text-align:center;">{{count($rodada->investidoresNaRodada)}}</h5>
            </div>


            @if($havePermissionToWatchPitch && $participanteNaRodada == null)

            <div style="border-radius:5px;height:47px;text-align:center;" id="container-btn-participar-rodada">
                <button data-toggle="modal" data-target="#modal-investir" id="btn-participar-rodada" class="btn btn-lg btn-block" style="background:#379f4f;color:white;">Participar na rodada</button>
            </div>

            @elseif($participanteNaRodada != null)

            @if($rodada->estado == 'anulada')
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;background: #00800029;">Valor Investido(Reembolsável)</span>
                <h5 style="color:green;text-align:center;">{{number_format($participanteNaRodada->valor_investido,2,",",".")}} AOA</h5>
            </div>
            @else
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;background: #00800029;">Valor Investido</span>
                <h5 style="color:green;text-align:center;">{{number_format($participanteNaRodada->valor_investido,2,",",".")}} AOA</h5>
            </div>
            @endif

            @endif

            @else

            <div style="width:40px;height:40px;margin:auto;">
                <img src="{{asset('assets/img/experiencia1.png')}}" style="width:100%;height:100%;object-fit:contain !important;" />
            </div>

            <p class="card-text" style="padding:5px 15px;text-align:center;font-size:17px;">Sem Oferta Declarada</p>
            <p class="card-text" style="padding:5px 15px;text-align:center;font-size:14px;">Startup Não Está a Buscar Investimento no Momento</p>
            @endif
        </div>
    </div>


</div>