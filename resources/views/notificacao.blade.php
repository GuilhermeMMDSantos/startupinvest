@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/notificao.css')}}" />
@endsection

@section('contentBody_base_inicio')

<ul class="list-group">
    @forelse($notificacoes as $notificacao)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{route('startup.perfil',$notificacao->userdeorigem->code_user)}}" style="display:inline-block;width:100%;height:100%;">
            <span>{{$notificacao->message}}</span>
        </a>
    </li>
    @empty
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Ainda não possui nenhuma notificação!</span>
    </li>
    @endforelse
</ul>

@endsection



@section('scripts_base_inicio')
@endsection