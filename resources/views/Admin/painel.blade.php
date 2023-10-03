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

                <div class="row" style="background:#7472611c;margin-top:15px;">
                    <div class="col-sm-12">
                        <h5>STARTUPS</h5>
                    </div>
                </div>

                <div class="row" style="padding-bottom:15px;">
                    @forelse($startups as $startup)
                    <div class="col-sm-6" style="padding-top:20px;" id="colum-card{{$startup->fk_user}}">
                        <div class="card h-100 cartao card_emp " id="cartao_user{{$startup->fk_user}}">
                            <div class="card-header">
                                <p><strong>Nome:</strong> <span>{{$startup->nome}}</span><br><strong>Setor de atividade:</strong> <span>{{$startup->setor->nome}}</span><br><strong>Fase de desenvolvimento:</strong> <span>{{$startup->fase->nome}}</span></p>
                            </div>
                            <div class="card-body">

                                <div style="width:100%; height:200; border:1px solid #ccc;margin-bottom:10px;">
                                    <p>Nome da Incubadora/Aceleradora: {{$startup->incubadorAceleradora->nome}}</p>
                                    <p>NIF da Incubadora/Aceleradora: {{$startup->incubadorAceleradora->nif}}</p>
                                    <a href="{{asset('storage/'.$startup->contrato_incubadora_aceleradora)}}" target="_blank">Contrato com a incubadora/aceleradora</a>
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


                <div class="row" style="background:#7472611c;">
                    <div class="col-sm-12">
                        <h5 class="rotulo">POTENCIAIS INVESTIDORES</h5>
                    </div>
                </div>

                <div class="row" style="padding-bottom:15px;">
                    @forelse($investidores as $investidor)
                    <div class="col-sm-4" style="padding-top:20px;" id="colum-card{{$investidor->fk_user}}">
                        <div class="card h-100" id="cartao_user{{$investidor->fk_user}}">
                            <div class="card-header">
                                <p><strong>Nome: </strong><span>{{$investidor->nome}} @if(isset($investidor->sobrenome)){{$investidor->sobrenome}}@endif</span><br>
                                    @if(isset($investidor->nif))
                                    <span><strong>NIF: </strong>{{$investidor->nif}}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="card-body">
                                @if($investidor->tipo_entidade == 'Física')
                                <a href="{{asset('storage/'.$investidor->bilhete_identidade)}}" target="_blank">Bilhete de Identidade</a><br>
                                @endif
                                <a href="{{asset('storage/'.$investidor->contrato_sociedade)}}" target="_blank">Contrato de Sociedade</a>

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