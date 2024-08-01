<div style="width:110px;height:110px;border:1px solid #ccc;border-radius:50%;">
    <img src="{{asset('storage/'.$startup->logotipo)}}" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
</div>



<div style="width:87%;padding-left:15px;padding-right:5px;">
    <p>
        <span id="nome-startup-intoducao" style="font-size:25px;margin-right:15px;">{{$startup->nome}}</span>
        @php
        $codigoStartup = Auth::user()->code_user;
        @endphp
        <input type="text" id="codigo-startup" value="{{Auth::user()->code_user}}" style="display:none;">
        <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->setor->nome}}</span>
        <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->fase->nome}}</span>
    </p>
    <p style="margin-top:-15px;">
        {{ str_replace('##',' ',$startup->pitch_elevator) }}
    </p>
    <div style="text-align:right;;margin-top:-13px;" id="btn-startup-intoducao">
        @if($myprofile)
        <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-editar-introducao-startup" style="border-radius: 30px;">Editar</button>
        <!--<a role="button" href="{{route('rodadas.page')}}" class="btn btn-outline-secondary ml-sm-2" style="height:33px;font-size:14px;border-radius: 30px">Rodadas de captação</a>
--> @if(empty($rodada) || $rodada->estado != 'fechada')
        <button type="button" class="btn btn-outline-secondary ml-sm-2" id="btn-buscar-investimento" data-toggle="modal" data-target="#modal-adicionar-oferta" style="height:33px;font-size:14px;border-radius: 30px; border-radius: 30px;@if($startup->estado_busca_invest == 'sim') display:none; @endif">Buscar Investimento</button>
        <button type="button" class="btn btn-outline-secondary ml-sm-2" id="btn-anular-ivestimento" style="height:33px;font-size:14px;border-radius: 30px;@if($startup->estado_busca_invest == 'nao') display:none; @endif">Anular Captação</button>
        @endif
        @else
        @if($startup->estado_busca_invest == 'sim' && $tipoUser=='investidor')

        <button type="button" id="btn-meeting" class="btn btn-outline-secondary ml-sm-2" style="height:33px;font-size:14px;border-radius: 30px">Meeting</button>
        @if($alreadySendRequestForSeePitch)
        <span style="font-size:14px;">Solicitação enviada...</span>

        @else
        <button type="button" class="btn btn-outline-secondary ml-sm-2" id="btn-solicitar-pitch" style="height:33px;font-size:14px;border-radius: 30px">Solicitar pitch</button>

        @endif
        &nbsp;
        @endif
        @endif
    </div>
</div>