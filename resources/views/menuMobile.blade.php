@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/menu_mobile.css')}}" />
@endsection

@section('contentBody_base_inicio')
<ul class="list-group list-group-flush">
    <li class="list-group-item"><a href="{{route('startup.perfil',Auth::user()->code_user)}}">Perfil {{Auth::user()->tipo}}</a></li>
    @if(Auth::user()->tipo == 'investidor')
    <li class="list-group-item"><a href="{{route('investidor.menu')}}">Investidores</a></li>
    @endif
    <li class="list-group-item"><a href="{{route('startup.menu')}}">Startups</a></li>
    <li class="list-group-item"><a href="#">Configurações e privacidade</a></li>
    <li class="list-group-item"><a href="{{url('userout')}}">Sair</a></li>
</ul>
@endsection