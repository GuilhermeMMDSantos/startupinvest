@if(count($rodadas) > 0)
<ul class="list-group list-group-flush">
    @foreach($rodadas as $rodada)
    <li class="list-group-item d-flex justify-content-between">
        <span>
            <a href="{{route('startup.perfil',$rodada->rodada->startup->user->code_user)}}" style="font-size:20px;">
                {{$rodada->rodada->startup->nome}}
            </a>
        </span>
        
        <span> {{$rodada->acoes_adquirida}}% de Participação</span>

        <span> {{$rodada->valor_investido}}AOA Investidos</span>
    </li>
    @endforeach
</ul>
@else
<div class="d-flex align-items-center justify-content-center" style="min-height:200px;">
    <h2>Nenhuma startup no portifólio</h2>
</div>
@endif