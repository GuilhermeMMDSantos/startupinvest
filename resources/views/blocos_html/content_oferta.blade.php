<div class="col-sm-8">
    <video src="@if($havePermissionToWatchPitch){{asset('storage/'.$startup->pitch_deck)}}@endif" controls="true" width="100%" height="500" />
</div>
<div class="col-sm-4" style="padding-top:10px;">
    <div class="card ">
        <div class="card-body">
            <h5 class="card-title" style="text-align:center;">Oferta - <span style="font-size:14px;">Faltam {{$rodada->tempo_restante}} Dias</span>
            </h5>
            <hr>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Busco</span>
                <h5 style="color:green;text-align:center;">{{$rodada->valor_objetivo}}Kz</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Por</span>
                <h5 style="color:green;text-align:center;">{{$rodada->oferta}}% Participação Societária</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Já Consegui</span>
                <h5 style="color:green;text-align:center;">{{$rodada->valor_obtido}}Kz</h5>
            </div>
            <div>
                <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Investidores Na Rodada</span>
                <h5 style="color:green;text-align:center;">{{count($rodada->investidores)}}</h5>
            </div>
            @if($havePermissionToWatchPitch)
            <a href="#" class="btn btn-primary btn-lg btn-block">Investir</a>

            @endif
        </div>
    </div>
</div>