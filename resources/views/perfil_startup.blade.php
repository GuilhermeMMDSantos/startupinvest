@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_startup.css')}}" />
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
                            <h2></h2>{{$startup->nome}} &nbsp;&nbsp;&nbsp; @if($isMine)<button class="btnEditar" title="editar"><i class="fas fa-pencil-alt"></i></button> @endif</h2>
                            <ul style="list-style:none;">
                                <li><span>Fase desenvolvimento: </span><span>{{$startup->fase->nome}}</span></li>
                                <li><span>Sector Actividade: </span><span>{{$startup->setor->nome}}</span></li>
                                <li><span>Tipo Negócio: </<span>{{$startup->tipobusnessfunc->nome}}</span></li>
                            </ul>
                            <p>
                            {{$startup->pitch_elevator}}
                            </p>

                        </div>
                        <div class="col-sm-3">
                            @if($isMine)
                            @if($startup->buscando_investimento == 'nao')
                            <button type="button" class="btn" style="display:block;margin-bottom:5px;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;font-size:15px;">
                                Buscar investimento
                            </button>
                            @else
                            <p>Buscando Investimento</p>
                            <button type="button" class="btn" style="display:block;margin-bottom:5px;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;">
                                <i class="fas fa-"></i> &nbsp;Cancelar busca investimento
                            </button>
                            @endif

                            @elseif($tipoUser == 'investidor' && $startup->buscando_investimento == 'sim')
                            <button type="button" class="btn" style="display:block;margin-bottom:5px;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;">
                                <i class="fas fa-search-dollar"></i> &nbsp;Solicitar Pitch
                            </button>
                            @endif

                            @if(!$isMine)
                            <button type="button" class="btn " style="display: block;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;font-size:15px;">
                                Enviar mensagem
                            </button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            @if($isMine)
            <div class="card">
                <div class="card-body">
                    <h2>Pitch deck <button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button></h2>
                </div>
            </div>
            @endif

            @if($isMine || $startup->buscando_investimento == 'sim')
            <div class="card">
                <div class="card-body">
                    <h2>Solicitação da rodada @if($isMine)<button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h2>Equipa Administrativa @if($isMine)<button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Programas de aceleração/incubadora @if($isMine)<button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Conquistas(imagem/video junto de uma descrição) @if($isMine)<button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Startups de interesses @if($isMine)<button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>
                </div>
            </div>


        </div>
    </div>


</section>
@endsection
@section('scripts_base_inicio')

@endsection