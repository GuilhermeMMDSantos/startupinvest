@forelse($membrosEquipa as $membro)
<div class="col-sm-6" style="margin-top:10px;">
    <div class="card h-100">
        <div class="card-body">
            <div style="width:80px;height:80px;border:1px solid #ccc;border-radius:50%;margin:auto;">
                <img src="{{asset('storage/'.$membro->img)}}" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
            </div>
            <p style="text-align:center;">{{$membro->nome}}&nbsp;{{$membro->sobrenome}}</p>
            <p style="margin-top:-10px;text-decoration:underline;font-weight:bold;">
                @foreach($membro->cargosExecutivos as $cargo)
                <span>{{$cargo->descricao}}({{$cargo->sigla}})</span><br>
                @endforeach
            </p>
            <p style="margin-top:-10px;"><span style="color:#adb5bd;">Formação:</span>
                @foreach($membro->formacoes as $formacao)
                <span>{{$formacao->certificado->nome}} em {{$formacao->areafuncao->nome}} {{$formacao->dataInicioFormatada}} - {{$formacao->dataFimFormatada}}</span><br>
                @endforeach
            </p>
            <p style="margin-top:-10px;"><span style="color:#adb5bd;">Experiência</span>:
                @foreach($membro->experiencias as $experiencia)
                <span>{{$experiencia->funcao->nome}} no(a) {{$experiencia->instituicao->nome}} </span><br>
                @endforeach
            </p>
        </div>

        <div class="card-footer">
            <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-excluir-membro-startup" data-code="{{$membro->id}}">Eliminar</button>
        </div>

    </div>
</div>
@empty
<p style="color:#3333339c;text-indent:25px;">Startup sem colaborador informado</p>
@endforelse