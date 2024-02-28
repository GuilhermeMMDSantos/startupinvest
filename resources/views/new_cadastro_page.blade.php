@extends('layout')

@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/new_cadastro_page.css')}}">
@endsection


@section('contentBody')
<div id="header" class="w-100">
    <div class="container-fluid">
        <h1 id="logo"><a href="{{route('new_home_page')}}">startup<strong style="color:white !important;">Investe</strong></a></h1>

    </div>
</div>
<div id="form-container" class="w-100" style="padding-top:40px;">


    <div id="header-card" class="mb-3">
        <h4>Cadastro</h4>
        <a role="button" class="input-type-entity @if(session('tipo') == false ||  session('tipo') == 'startup') input-type-entity-ativo @endif" id="entity-startup">Startup</a>&nbsp;&nbsp;
        <a role="button" class="input-type-entity @if(session('tipo') == 'investidor') input-type-entity-ativo  @endif" id="entity-investor">Investidor</a>
        @if (session('tipo'))
        <input id="type-entity" value="{{ session('tipo') }}" hidden>
        @endif
    </div>


    @include('form_startup')
    @include('form_investidor')


</div>
@endsection


@section('scripts')
<script src="{{asset('assets/js/new_cadastro.js')}}"></script>
@endsection