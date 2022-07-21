<div class="col-sm-8" style="padding-top:10px;">
    <div class="card">
        <div class="card-body">
            <video style="border:2px solid #e9ecef9c;" src="@if($havePermissionToWatchPitch || $myprofile){{asset('storage/'.$startup->pitch_deck)}}@endif" controls="true" width="100%" height="500" />

            <div style="text-align:right;font-size:14px;">
                <a role="button" id="btn-conversa" style="background:#dedede;padding:5px;border-radius:2px;color:#6c757d;"><i class="fa fa-comment-dots"></i> Conversa</a>
            </div>

            <div id="container-list-conversas" style="border:1px solid #ccc;height:200px;margin-top:10px;display:none;overflow-y:auto;">
            </div>

            <div id="container-chat" style=" height:270px;margin-top:10px; display:none;">
                 
                <div id="bady-chat" style="border:1px solid #ccc;height:200px;background: #f8f9fa;overflow-y:auto;">
                </div>
                <div id="footer-chat" style="display:flex;padding-top:5px;overflow-y:auto;">
                    <input type="text" id="conteudo-message-chat" class="form-control" placeholder="Escreva aqui"> &nbsp;
                    <button style="font-size:14px;" id="btn-enviar-message-chat">enviar</button>
                </div>
            </div>




        </div>
    </div>
</div>
<div class="col-sm-4" style="padding-top:10px;">
    <div class="card ">
        <div class="card-body">
            @if(!empty($rodada))
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