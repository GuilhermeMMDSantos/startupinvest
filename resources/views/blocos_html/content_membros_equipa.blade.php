@forelse($membrosEquipa as $membro)
<div class="col-sm-4" style="margin-top:10px;">
    <div class="card h-100">
        <div class="card-body">
            <div style="width:80px;height:80px;border:1px solid #ccc;border-radius:50%;margin:auto;">
                <img src="{{asset('storage/'.$membro->img)}}" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
            </div>
            <p style="text-align:center;">{{$membro->nome}}&nbsp;{{$membro->sobrenome}}</p>
            <p style="margin-top:-10px;font-weight:bold;">
                @foreach($membro->cargosExecutivos as $cargo)
                <span>{{$cargo->descricao}}({{$cargo->sigla}})</span><br>
                @endforeach
            </p>
            <p style="margin-top:-10px;">
                <span style="color:#adb5bd;">Formação</span><br>
                @foreach($membro->formacoes as $formacao)
                <span>{{$formacao->certificado->nome}} em {{$formacao->areafuncao->nome}} </span><br>
                @endforeach
            </p>
            <p style="margin-top:-10px;">
                <span style="color:#adb5bd;">Experiência</span><br>
                @foreach($membro->experiencias as $experiencia)
                <span>{{$experiencia->funcao->nome}} no(a) {{$experiencia->instituicao->nome}} </span><br>
                @endforeach
            </p>
        </div>
        @if($myprofile)
        <div class="card-footer">
            <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-excluir-membro-startup" data-code="{{$membro->id}}">Eliminar</button>
        </div>
        @endif
    </div>
</div>
@empty
<div class=" col-12 card">
    <div class="card-body">
        <div style="width:60px;height:60px;margin:auto;">
            <img src="{{asset('assets/img/formacao1.png')}}" style="width:100%;height:100%;object-fit:contain !important;" />
        </div>

        <p class="card-text" style="padding:5px 15px;text-align:center;font-size:17px;">Sem membro informado</p>
    </div>
</div>
@endforelse