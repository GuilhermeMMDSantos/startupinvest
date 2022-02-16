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
                            @if($potencialInvestidor->id_tipo_entidade == 2)
                            <div style="width:120px;height:120px;border:2px solid #ccc;border-radius:70px;">
                                @else
                                <div style="width:120px;height:120px;border:2px solid #ccc;">
                                    @endif
                                    <img style="width:100%;height:100%;" src="{{asset('assets/img/img1.png')}}" />
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <h2><span style="font-size:2.1rem;font-weight:bold;">{{$potencialInvestidor->nome}}</span>&nbsp;{{$potencialInvestidor->sobrenome}} &nbsp;&nbsp;&nbsp; @if($isMine)<button class="btnEditar" title="editar"><i class="fas fa-pencil-alt"></i></button>@endif</h2>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <span style="font-size: 15px;color: #4d4747;">Tipo entidade: </span><span class="badge badge-secondary" style="font-size: 13px;"></span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span style="font-size: 15px;color: #4d4747;">Nacionalidade: </<span><span class="badge badge-secondary" style="font-size: 13px;">{{$potencialInvestidor->nacionalidade->nome}}</span>
                                    </div>
                                </div>
                                <div>
                                    @if(!$isMine)
                                    <button type="button" class="btn " style="display: inline-block;float:right;background-color: transparent;color: #be970dc4;border: 1px solid #be970dc4;font-size:15px;">
                                        Enviar mensagem
                                    </button>
                                    @endif
                                </div>
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



            </div>
        </div>


</section>
@endsection

@section('scripts_base_inicio')

@endsection