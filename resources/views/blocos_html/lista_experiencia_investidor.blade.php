@if(count($experiencias)>0)
<ul class="list-group">
    @foreach($experiencias as $experiencia)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ $experiencia->funcao->nome}} no(a) {{ $experiencia->instituicao->nome}} ({{$experiencia->dataInicioFormatada}} até @if($experiencia->data_fim !=null){{$experiencia->dataFimFormatada}} @else o momento @endif)</span>
        @if($myProfile) <button type="button" class="btn btn-primary btn-editar">Excluir</button>@endif
    </li>
    @endforeach
</ul>
@else

<div style="width:40px;height:40px;margin:auto;">
    <img src="{{asset('assets/img/experiencia1.png')}}" style="width:100%;height:100%;object-fit:contain !important;" />
</div>

<p class="card-text" style="padding:5px 15px;text-align:center;font-size:17px;">Sem Experiência Declarada</p>
@endif