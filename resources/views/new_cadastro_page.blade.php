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


<div id="form-container" class="w-100" style="padding-top:40px; position:relative;">

    @if($errors->any())
    <div style="position:absolute;right:10px;top:10px;z-index:10;">
        @foreach ($errors->all() as $error)
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay=5000 data-animation=true style="z-index:10;background:#dc354554;">
            <div class="toast-header">
                <i class="fa fa-bell rounded mr-2"></i>
                <strong class="mr-auto">Validação</strong>
                <small>...</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{ $error }}
            </div>
        </div>
        @endforeach

    </div>
    @endif


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