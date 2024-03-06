@extends('../layout')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/painel.css')}}">
@endsection
@section('contentBody')
<div>

    @include('Admin/header_admin')
    <div class="container-fluid">
        <div class="row" style="padding-left: 6.5%; padding-right: 6.5%;">
            <section class="container-fluid col-sm-12">

                <div class="row mb-3" style="background:#7472611c;margin-top:15px;">
                    <div class="col-sm-12">
                        <h5>STARTUPS</h5>
                    </div>
                </div>

                <div class="row" style="padding-bottom:15px;">
                    @forelse($startups as $startup)
                    <div class="col-sm-6" id="colum-card{{$startup->fk_user}}">
                        <div class="card h-100 cartao card_emp " id="cartao_user{{$startup->fk_user}}">

                            <div class="card-body">

                                <div>
                                    <p><strong>Nome:</strong> <span>{{$startup->nome}}</span><br><strong>Setor de atividade:</strong> <span>{{$startup->setor->nome}}</span><br><strong>Fase de desenvolvimento:</strong> <span>{{$startup->fase->nome}}</span></p>
                                </div>

                                <div style="width:100%; height:200; border:1px solid #ccc;margin-bottom:10px;">
                                    <a href="{{asset('storage/'.$startup->nif)}}" target="_blank">Número de identificação Fiscal (PDF)</a>
                                </div>

                                <div style="border:1px solid #ccc;margin-bottom:10px;">
                                    <video src="{{asset('storage/'.$startup->mvp)}}" width="100%" height="80%" controls="true">
                                    </video>
                                </div>

                                <p><strong>Pitch Elevator:</strong> <span class="pitch">{{ str_replace('##',' ',$startup->pitch_elevator) }}</span></p>

                            </div>
                            <div class="card-footer" style="border-top:none;background-color:white;">
                                <hr style="margin-bottom:0.5rem;">
                                <p><strong>Registado as:</strong> <span><?= \Carbon\Carbon::parse($startup->user->created_at)->format('d-m-Y  H:m:s') ?></span></p>
                                <div class="btn">
                                    <button class="btn_aceitar" id="btn_aceitar_{{$startup->fk_user}}">Aceitar</button>
                                    <button class="btn_regeitar" id="btn_regeitar_{{$startup->fk_user}}">Regeitar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container" style="text-align: center;">
                                <h1 class="display-4">Nenhuma Startup</h1>
                                <p class="lead">Não há nenhuma startup cadastrada esperando por validação!!!</p>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>


                <div class="row mb-3" style="background:#7472611c;">
                    <div class="col-sm-12">
                        <h5 class="rotulo">POTENCIAIS INVESTIDORES</h5>
                    </div>
                </div>

                <div class="row" style="padding-bottom:15px;">
                    @forelse($investidores as $investidor)
                    <div class="col-sm-6" id="colum-card{{$investidor->fk_user}}">
                        <div class="card h-100" id="cartao_user{{$investidor->fk_user}}">

                            <div class="card-body">

                                <div>
                                    <p>
                                       
                                        <span><strong>Nome: </strong>{{$investidor->nome}} {{$investidor->sobrenome}}</span><br>
                                    </p>
                                </div>

                                <div style="width:100%; height:200; border:1px solid #ccc;margin-bottom:10px;">
                                    <a href="{{asset('storage/'.$investidor->bilhete_identidade)}}" target="_blank">Bilhete de Identidade (PDF)</a>                                    
                                </div>

                                <div style=" border:1px solid #ccc;margin-bottom:10px;">
                                    <video src="{{asset('storage/'.$investidor->video_investidor)}}" width="100%" height="85%"controls="true">
                                    </video>
                                </div>

                            </div>
                            <div class="card-footer">
                                <p>
                                    <strong>Registado as:</strong>
                                    <span>
                                        <?= \Carbon\Carbon::parse($investidor->user->created_at)->format('d-m-Y H:m:s') ?>
                                    </span>
                                </p>
                                <div class="btn">
                                    <button class="btn_aceitar" id="btn_aceitar_{{$investidor->fk_user}}">Aceitar</button>
                                    <button class="btn_regeitar" id="btn_regeitar_{{$investidor->fk_user}}">Regeitar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container" style="text-align: center;">
                                <h1 class="display-4">Nenhum investidor</h1>
                                <p class="lead">Não há nenhum investidor cadastrado esperando por validação!!!</p>
                            </div>
                        </div>
                    </div>
                    @endforelse

                </div>
            </section>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src="assets/js/script3.js"></script>
@endsection