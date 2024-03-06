@php
use App\User;

@endphp

<div class="list-group">
    @forelse($dados as $dado)

    @php
    $user = User::where('id',$dado->id)->first();
    @endphp

    <p id="first_meeting" hidden>@if($loop->index == 0){{$user->id}}@endif</p>

    <a href="#" class="list-group-item list-group-item-action meeting" guito="{{$dado->id}}">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">@if($user->tipo == 'startup') {{$user->startup->nome}} @else {{$user->investidor->nome.' '.$user->investidor->sobrenome}} @endif</h5>
            <small>{{ \Carbon\Carbon::parse($dado->date_)->format('d/m/Y')}}</small>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <p class="mb-1" style="width:95%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;color:#808080c9;">@if($dado->id == $dado->remetente) {{$user->tipo}}: @else Eu: @endif{{$dado->conteudo}}</p>
            
            <span id="marcador_{{$dado->id}}" style="width:20px;height:20px;text-align:center;font-size:11px;border-radius:20px;background:#1399fc;color:white; @if($dado->unview > 0) display:inline-block;@else display:none;@endif ">@if($dado->unview>9) +9 @else {{$dado->unview}} @endif</span>
            
        </div>
    </a>

    @empty

    @endforelse
</div>