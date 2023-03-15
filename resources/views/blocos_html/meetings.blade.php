@php
use App\User;

@endphp
<header style="border:1px solid #ccc;">
    <h5 style="padding:7px 16px;">
        Meetings
    </h5>
</header>

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
        <p class="mb-1">{{$dado->conteudo}}</p> 
    </a>

    @empty

    @endforelse
</div>