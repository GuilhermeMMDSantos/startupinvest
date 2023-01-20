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
<div id="form-container" class="w-100">

    <div class="card">
        <div class="card-header">
            <h4>Cadastro</h4>
            <div style="font-size:20px;">
                
                <input class="input-type-entity" type="radio" name="entity_register" id="entity-startup" value="option1" checked>
                <label class="" for="entity-startup">
                    Startup
                </label>
              
                <input class="input-type-entity ml-3" type="radio" name="entity_register" id="entity-investor" value="option1">
                <label class="" for="entity-investor">
                    Investidor
                </label>
            </div>
        </div>
        <div class="card-body">
            @include('form_startup')
            @include('form_investidor')
        </div>
    </div>

</div>
@endsection


@section('scripts')
<script src="{{asset('assets/js/new_cadastro.js')}}"></script>
@endsection