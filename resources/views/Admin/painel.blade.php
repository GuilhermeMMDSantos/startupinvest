@extends('../layout')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/painel.css')}}">
@endsection
@section('contentBody')
<div class="container-fluid">

    <header class="row">

        <div class="col-sm-10" id="logo" style="padding-top:7px;">
            <h5>ecoStartup-Admin</h5>
        </div>
        <div class="col-sm-2" style="padding-top:7px;text-align:right;">
            <a id="btn_sair" href="{{url('userout')}}" style="color:#ffcb2f;text-decoration:underline;">Sair</a>
        </div>

    </header>





    <div class="row">

        <aside class="col-sm-2" style="border:1px solid #ccc;">
            <ul style="list-style:none;text-decoration:underline;">
                <li><a href="#" style="color:#d39e00;">Usuários</a></li>
                <li><a href="#" style="color:#d39e00;">Denuncias</a></li>
            </ul>
        </aside>

        <section class="container-fluid col-sm-10" style="border:1px solid #ccc;">

            <div class="row" style="background:#7472611c;">
                <div class="col-sm-12">
                    <h5>STARTUPS</h5>
                </div>
            </div>

            <div class="row" style="padding-bottom:15px;">
                @foreach($startups as $startup)
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
                @endforeach
            </div>


            <div class="row" style="background:#7472611c;">
                <div class="col-sm-12">
                    <h5 class="rotulo">POTENCIAIS INVESTIDORES</h5>
                </div>
            </div>

            <div class="row" style="padding-bottom:15px;">
                @foreach($investidores as $investidor)
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
                @endforeach

            </div>
        </section>
    </div>


</div>
@endsection
@section('scripts')
<script src="assets/js/script3.js"></script>
@endsection