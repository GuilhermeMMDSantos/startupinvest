<div
    style="width: 110px; height: 110px; border: 2px solid #d6d6d6; border-radius: 50%; display: flex; justify-content: center; align-items: center; background: #ffffff;">
    <img src="{{ asset('storage/' . $startup->logotipo) }}"
        style="width: 100%; height: 100%; border-radius: 50%; object-fit: contain !important;">
</div>



<div style="width:87%;padding-left:15px;padding-right:5px;">
    <p>
        <span id="nome-startup-intoducao"
            style="font-size: 1.8rem; font-weight: bold; color: #333; margin-bottom: 5px;">{{ $startup->nome }}</span>
        @php
            $codigoStartup = Auth::user()->code_user;
        @endphp
        <input type="text" id="codigo-startup" value="{{ Auth::user()->code_user }}" style="display:none;">
        <span style="color: #767d84; font-size: 1rem; margin-left: 10px; margin-right:5px;"><i
                style="font-size:20px;margin-right:2px;">•</i>{{ $startup->setor->nome }}</span>
        <span style="color: #767d84; font-size: 1rem;"><i
                style="font-size:20px;margin-right:2px;">•</i>{{ $startup->fase->nome }}</span>
    </p>

    <p style="font-size: 1rem; color: #555; line-height: 1.5; margin-top: 10px;">
        {{ str_replace('##', ' ', $startup->pitch_elevator) }}<br>
        @if ($startup->estado_busca_invest == 'sim' && $tipoUser == 'investidor')
            Avaliado com: <span
                style="font-size:20px;color:#ca9227;font-weight:bold;">{{ number_format($rodada->potencial_de_crescimento, 2, ',', '.') }}%</span>
            de Potencial de Crescimento
        @endif
    </p>

    <div style="text-align:right;;margin-top:-13px;" id="btn-startup-intoducao">
        @if ($myprofile)
            <button type="button" class="btn btn-primary btn-editar" data-bs-toggle="modal"
                data-bs-target="#modal-editar-introducao-startup" style="border-radius: 30px;">Editar</button>
            <!--<a role="button" href="{{ route('rodadas.page') }}" class="btn btn-outline-secondary ml-sm-2" style="height:33px;font-size:14px;border-radius: 30px">Rodadas de captação</a>
-->
            @if (empty($rodada) || $rodada->estado != 'fechada')
                <button type="button" class="btn btn-outline-secondary ml-sm-2" id="btn-buscar-investimento"
                    data-bs-toggle="modal" data-bs-target="#modal-adicionar-oferta"
                    style="height:33px;font-size:14px;border-radius: 30px; border-radius: 30px;@if ($startup->estado_busca_invest == 'sim') display:none; @endif">Buscar
                    Investimento</button>
                <button type="button" class="btn btn-outline-secondary ml-sm-2" id="btn-anular-ivestimento"
                    style="height:33px;font-size:14px;border-radius: 30px;@if ($startup->estado_busca_invest == 'nao') display:none; @endif">Anular
                    Captação</button>
            @endif
        @else
            @if ($startup->estado_busca_invest == 'sim' && $tipoUser == 'investidor')
                
                @if ($permissoesVerPitch != null && ($permissoesVerPitch->estado == 'ativo' || $permissoesVerPitch->estado == 'livre'))
                <button type="button" id="btn-meeting" class="btn btn-outline-secondary ml-sm-2"
                    style="height:33px;font-size:14px;border-radius: 30px">Meeting</button>
                @endif
                @if($permissoesVerPitch != null && $permissoesVerPitch->estado == 'espera')
                    <span style="font-size:14px;">Solicitação enviada...</span> 
                @elseif($permissoesVerPitch == null || $permissoesVerPitch->estado == 'expirado')
                    <button type="button" class="btn btn-outline-secondary ml-sm-2" id="btn-solicitar-pitch"
                        style="height:33px;font-size:14px;border-radius: 30px">Solicitar pitch</button>
                @endif
                &nbsp;
            @endif
        @endif
    </div>
</div>
