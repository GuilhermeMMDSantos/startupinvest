
        <div style="width:110px;height:110px;border:1px solid #ccc;border-radius:50%;">
            <img src="{{asset('storage/'.$startup->logotipo)}}" style="width:100%;height:100%;border-radius:50%;">
        </div>



        <div style="width:87%;padding-left:15px;padding-right:5px;">
            <p>
                <span style="font-size:25px;margin-right:15px;">{{$startup->nome}}</span>
                @php
                $codigoStartup = Auth::user()->code_user;
                @endphp
                <input type="text" id="codigo-startup" value="{{Auth::user()->code_user}}" style="display:none;">
                <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->setor->nome}}</span>
                <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->fase->nome}}</span>
                <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->tipobusnessfunc->nome}}</span>
            </p>
            <p style="margin-top:-15px;">
                {{ str_replace('##',' ',$startup->pitch_elevator) }}
            </p>
            <div style="text-align:right;;margin-top:-13px;">
        
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-editar-introducao-startup">Editar</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-outline-secondary" style="height:33px;font-size:14px; @if($startup->estado_busca_invest == 'sim') display:none; @endif">Buscar Investimento</button>
                <button type="button" class="btn btn-outline-secondary" style="height:33px;font-size:14px;@if($startup->estado_busca_invest == 'nao') display:none; @endif">Anular Investimento</button>

            </div>
        </div>