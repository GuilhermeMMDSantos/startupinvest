@extends('../layout')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="assets/css/painel.css">

@endsection
@section('contentBody')
<div class="container-fluid">

    <header class="row" >
        
            <div class="col-sm-10">
                <h1>ecoStartup-Admin</h1>
            </div>
            <div class="col-sm-2">
                <a id="btn_sair" href="{{url('userout')}}">Sair</a>
            </div>
       
    </header>



    <div class="container-fluid corpo">

        <div class="row"  >

            <aside class="menuAside col-sm-2" >
                <ul>
                    <li><a href="#">Usuarios</a></li>
                    <li><a href="#">Denuncias</a></li>
                </ul>
            </aside>

            <section class="container-fluid conteudo col-sm-10" style="border:1px solid #ccc;border-radius:3px;">

                <div class="row" style="background:#7472611c;">
                    <div class="col-sm-12">
                        <h1 class="rotulo">STARTUPS</h1>
                    </div>
                </div>

                <div class="row" id="divContainerStartupsCard" style="padding-top:10px;padding-left:20px;">
                    @foreach($startups as $startup)
                    <div class="float-left">
                        <div class="card cartao card_emp" id="cartao_user{{$startup->id_user}}">
                            <div class="card-header">
                                <p><strong>Nome:</strong> <span>{{$startup->nome}}</span><br><strong>Setor de atividade:</strong> <span>{{$startup->setor->nome}}</span><br><strong>Fase de desenvolvimento:</strong> <span>{{$startup->fase->nome}}</span></p>
                            </div>
                            <div class="card-body">
                                <video width="100%" height="260" id="video_cartao_user{{$startup->id_user}}" controls>
                                    <source src="{{asset('storage/'.$startup->video_produto)}}">
                                </video>
                                <p><strong>Pitch Elevator:</strong> <span class="pitch">{{$startup->pitch_elevator}}</span></p>
                                <p><strong>Registado as:</strong> <span><?= \Carbon\Carbon::parse($startup->user->created_at)->format('d-m-Y  H:m:s') ?></span></p>
                                <div class="btn">
                                    <button class="btn_aceitar" id="btn_aceitar_{{$startup->id_user}}">Aceitar</button>
                                    <button class="btn_regeitar" id="btn_regeitar_{{$startup->id_user}}">Regeitar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


                <div class="row" style="background:#7472611c;">
                    <div class="col-sm-12">
                        <h1 class="rotulo">Potenciais investidores</h1>
                    </div>
                </div>

                <div class="row" style="padding-top:10px;padding-left:10px;padding-left:20px;">
                    @foreach($potenciaisInvestidores as $potencialInvestidor)
                    <div class="float-left">
                        <div class="card cartao card_inv" id="cartao_user{{$potencialInvestidor->id_user}}">
                            <div class="card-header">
                                <p><strong>Nome: </strong><span>{{$potencialInvestidor->nome}} @if(isset($potencialInvestidor->sobrenome)){{$potencialInvestidor->sobrenome}}@endif</span><br>
                                    @if(isset($potencialInvestidor->nif))
                                    <span><strong>NIF: </strong>{{$potencialInvestidor->nif}}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="card-body">
                                <video width="100%" height="260" id="video_cartao_user{{$potencialInvestidor->id_user}}" controls>
                                    <source src="{{asset('storage/'.$potencialInvestidor->video_porque_investir)}}">
                                </video>
                                <p><strong>Registado as:</strong> <span><?= \Carbon\Carbon::parse($potencialInvestidor->user->created_at)->format('d-m-Y H:m:s') ?></span></p>
                                <div class="btn">
                                    <button class="btn_aceitar" id="btn_aceitar_{{$potencialInvestidor->id_user}}">Aceitar</button>
                                    <button class="btn_regeitar" id="btn_regeitar_{{$potencialInvestidor->id_user}}">Regeitar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script src="assets/js/script3.js"></script>
@endsection