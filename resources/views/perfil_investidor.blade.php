@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_investidor.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section class="container-fluid" style="padding-left:6.5%;padding-right:6.5%;  ">
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5>Agenda</h5>
                </div>
            </div>

        </div>
        <div class="col-sm-9">

            <div class="card">
                <div class="card-body" style="padding-left:50px;padding-right:20px;">
                    <div class="row">
                        <div class="col-sm-1.5">
                            <div style="width:120px;height:120px;border:2px solid #ccc;border-radius:70px;">
                                <img style="width:100%;height:100%;" src="{{asset('assets/img/img1.png')}}" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <h2>{{$potencialInvestidor->nome}}&nbsp;{{$potencialInvestidor->sobrenome}} &nbsp;&nbsp;&nbsp; @if($isMine)<button class="btnEditar" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>
                            <ul style="list-style:none;">
                                <li>Tipo entidade: {{$potencialInvestidor->tipoentidade->descricao}}</li>
                                <li>Nacionalidade: {{$potencialInvestidor->nacionalidade->nome}}</li>
                            </ul>
                        </div>
                        
                        <div class="col-sm-3">
                        @if(!$isMine)
                            <button type="button" class="btn " style="display: block;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;font-size:15px;">
                               Enviar mensagem
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Experiência <button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Histórico de investimento <button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Startups de interesses <button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button></h2>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Investidores de interesses <button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button></h2>
                </div>
            </div>

        </div>
    </div>


</section>
@endsection

@section('scripts_base_inicio')

@endsection