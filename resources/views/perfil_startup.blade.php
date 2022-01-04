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
                            <div style="width:120px;height:120px;border:2px solid #ccc;">
                                <img style="width:100%;height:100%;" src="{{asset('assets/img/img1.png')}}" />
                            </div>

                        </div>
                        <div class="col-sm-10">
                            <h2><span style="font-size:2.1rem;font-weight:bold;">{{$startup->nome}}</span> &nbsp;&nbsp;&nbsp; @if($isMine)<button class="btnEditar" title="editar"><i class="fas fa-pencil-alt"></i></button> @endif</h2>
                            <div class="row">
                                <div class="col-sm-8">
                                    <span style="font-size: 15px;color: #4d4747;">Fase desenvolvimento: </span><span class="badge badge-secondary">{{$startup->fase->nome}}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span style="font-size: 15px;color: #4d4747;">Tipo Negócio: </<span><span class="badge badge-secondary">{{$startup->tipobusnessfunc->nome}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <span style="font-size: 15px;color: #4d4747;">Sector Actividade: </span><span class="badge badge-secondary">{{$startup->setor->nome}}</span>
                                </div>
                            </div>
                            <p style="margin-top:10px;background:#9fbcc21c; font-size:1.1rem;">
                                {{$startup->pitch_elevator}}
                            </p>
                            <div>
                                @if($isMine)
                                @if($startup->buscando_investimento == 'nao')
                                <button type="button" class="btn" style="display:inline-block;margin-bottom:5px;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;font-size:15px;">
                                    Buscar investimento
                                </button>
                                @else
                                <button type="button" class="btn" style="display:inline-block;margin-bottom:5px;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;font-size:15px;">
                                    Cancelar busca investimento
                                </button>
                                @endif

                                @elseif($tipoUser == 'investidor' && $startup->buscando_investimento == 'sim')
                                <button type="button" class="btn" style="display:inline-block;margin-bottom:5px;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;font-size:15px;">
                                    Solicitar Pitch
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
            </div>

            @if($isMine || $startup->buscando_investimento == 'sim')
            <div class="card">
                <div class="card-body">
                    <h2>Solicitação da rodada @if($isMine)<button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>
                    <div class="row">
                        <div class="col-sm-6">
                            <p>Meta: <span>2 000.000 kz</span></p>
                        </div>
                        <div class="col-sm-6">
                            <p>Oferta: <span>1% ações, mútuo conversível</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>Finalidades do Investimento: </p>
                            <ul style="list-style:none;">
                                <li>Pagar Hospedagem</li>
                                <li>Pagar fornecedor</li>
                                <li>Pagar Hospedagem</li>
                                <li>Pagar fornecedor</li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            
            @if($isMine)
            <div class="card">
                <div class="card-body">
                    <h2>Pitch deck <button class="btnEditar" style="float:right;" title="editar"><i class="fas fa-pencil-alt"></i></button></h2>
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

        </div>
    </div>


</section>
@endsection
@section('scripts_base_inicio')

@endsection