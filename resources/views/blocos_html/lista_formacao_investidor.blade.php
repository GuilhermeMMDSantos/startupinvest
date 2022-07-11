@if(count($formacoes)>0)
<ul class="list-group">
    @foreach($formacoes as $formacao)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{$formacao->certificado->nome}} em {{$formacao->areafuncao->nome}} {{$formacao->dataInicioFormatada}} até @if($formacao->dataFimFormatada!=null) {{$formacao->dataFimFormatada}} @else o momento @endif</span>
        @if($myProfile)<button type="button" class="btn btn-primary btn-editar">Excluir</button>@endif
    </li>
    @endforeach
</ul>
@else
<div style="width:60px;height:60px;margin:auto;">
    <img src="{{asset('assets/img/formacao1.png')}}" style="width:100%;height:100%;object-fit:contain !important;" />
</div>

<p class="card-text" style="padding:5px 15px;text-align:center;font-size:17px;">Sem Formação Declarada</p>
@endif