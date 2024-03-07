<div class="col-sm-8" style="padding-top:10px;">
    <div class="card">
        <div class="card-body" style="padding-bottom:30px;">
            <video style="border:2px solid #e9ecef9c;" src="@if($havePermissionToWatchPitch || $myprofile){{asset('storage/'.$startup->pitch_deck)}}@endif" width="100%" height="80%" controls="true">
            </video>

        </div>
    </div>
</div>
<div class="col-sm-4" style="padding-top:10px;">
    <div class="card mb-3">
        <div class="card-body">
            @if(!empty($rodada))
            <h5 class="card-title" style="text-align:center;">Oferta - <span style="font-size:14px;">Faltam {{$rodada->tempo_restante}} Dias</span>
            </h5>
            <hr>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Busco</span>
                <h5 style="color:green;text-align:center;">{{$rodada->valor_objetivo}} AOA</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Por</span>
                <h5 style="color:green;text-align:center;">{{$rodada->oferta}}% Participação Societária</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Já Consegui</span>
                <h5 style="color:green;text-align:center;">{{$rodada->valor_obtido}} AOA</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Investidores Na Rodada</span>
                <h5 style="color:green;text-align:center;">{{count($rodada->investidores)}}</h5>
            </div>


            @if($havePermissionToWatchPitch)
            <div style=" border-radius:5px;height:47px;text-align:center;" id="container-btn-gerar-ref">
                @if(!empty($referencaPagamento))
                <p style="font-size:20px; font-weight:bold; background:#febd69;color:white; height:100%;padding-top:10px; padding-bottom:10px;">Ref. {{$referencaPagamento}}</p>
                @else

                <button data-toggle="modal" data-target="#modal-gerar-referencia-pagamento" id="btn-gerar-ref" class="btn btn-lg btn-block" style="background:#379f4f;color:white;">Participar na rodada</button>
                <div class="text-center " id="my-spinner" style="display:none;">
                    <div class="spinner-border  text-warning" role="status">
                    </div>
                </div>

                @endif

            </div>
            @endif

            @else

            <div style="width:40px;height:40px;margin:auto;">
                <img src="{{asset('assets/img/experiencia1.png')}}" style="width:100%;height:100%;object-fit:contain !important;" />
            </div>

            <p class="card-text" style="padding:5px 15px;text-align:center;font-size:17px;">Sem oferta declarada</p>
            <p class="card-text" style="padding:5px 15px;text-align:center;font-size:14px;">Startup não está a buscar investimento no momento</p>

            @endif
        </div>
    </div>


</div>