@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/pagina_da_rodada.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid" style="padding-left:6.5% !important;padding-right:6.5% !important; padding-bottom:50px;">



    <h2 class="mb-4" id="title-page">Rodada <i style="font-size:20px;margin-right:2px;color:#818182;">•</i><span style="font-size:15px;font-weight:bold;color:#818182;"> {{$rodada->estado}}</span></h2>

    <div class="card" style="margin-bottom:15px;" id="intro-rodada">

        <div class="card-body row">
            <div class="col-sm-3 col-12">
                <h5>Rodada</h5>
                <h6>{{$rodada->id}}</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor objectivo</h5>
                <h6>{{number_format($rodada->valor_objetivo,2,',','.')}} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor Captado</h5>
                <h6>{{number_format($rodada->valor_obtido,2,',','.')}} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Participação Oferecida</h5>
                <h6>{{$rodada->oferta_acoes}}%</h6>
            </div>

        </div>
    </div>
    @if($investidor != NULL)
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-sm-6 col-12">
                        <p>
                            <span class="badge badge-primary">Startup</span>&nbsp;<a href="{{route('startup.perfil',$investidor->rodada->startup->user->code_user)}}" style="font-size:20px;">{{$investidor->rodada->startup->nome}}</a>

                        </p>
                        <p>
                            <span class="badge badge-primary">Aportado</span>&nbsp;<span style="font-size:20px;"> {{number_format($investidor->valor_investido,2,',','.')}} AOA</span>
                        </p>
                        <p>
                            <span class="badge badge-primary">Porcentagem</span>&nbsp;<span style="font-size:20px;"> {{$investidor->acoes_adquirida}}%</span>
                        </p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <p><span class="badge badge-primary">Situação</span></p>
                        @if($investidor->situation == null)
                        Captado
                        @elseif($investidor->situation == 'Não Rembolsado')
                        {{$investidor->situation}}
                        @elseif($investidor->situation == 'Reembolsado')
                        {{$investidor->situation}}
                        @elseif($investidor->situation == 'Não Assinado')
                        <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                            <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                        </div>
                        <a href="{{route('view_pdf',$investidor->contrato_mutou)}}">Assinar Contrato</a>
                        @elseif($investidor->situation == 'Assinado')
                        <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                            <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                        </div>
                        <a href="#" role="button">Visualizar Contrato</a>
                        @elseif($investidor->situation == 'Aguardando Contracto')
                        {{$investidor->situation}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <h5 style="color:#818182;">Investidores na Rodada</h5>
    <div class="container-fluid">
        <div class="row">
            @forelse($investidores as $investidor)
            <div class="col-sm-6 col-12">
                <div class="card  h-100">
                    <div class="card-body row card-investor-rodada">
                        <div class="col-12 col-sm-8">
                            <p>
                                <span class="badge badge-primary">Investidor</span>&nbsp;<a href="{{route('startup.perfil',$investidor->investidor->user->code_user)}}">{{$investidor->investidor->nome_completo}}</a>
                            </p>
                            <p>
                                <span class="badge badge-primary">Aportado</span>&nbsp;<span>{{number_format($investidor->valor_investido,2,',','.')}} AOA</span>
                            </p>
                            <p>
                                <span class="badge badge-primary">Porcentagem</span>&nbsp;<span> {{$investidor->acoes_adquirida}}%</span>
                            </p>
                        </div>
                        <div class="col-12 col-sm-4" style="text-align:center;">
                            <p><span class="badge badge-primary">Situação</span></p>
                            @if($investidor->situation == null)
                            Captado
                            @elseif($investidor->situation == 'Não Rembolsado')
                            {{$investidor->situation}}
                            @elseif($investidor->situation == 'Reembolsado')
                            {{$investidor->situation}}
                            @elseif($investidor->situation == 'Não Assinado')
                            <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                            </div>
                            <a href="{{route('view_pdf',$investidor->contrato_mutou)}}">Assinar Contrato</a>
                            @elseif($investidor->situation == 'Assinado')
                            <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                            </div>
                            <a href="#" role="button">Visualizar Contrato</a>
                            @elseif($investidor->situation == 'Aguardando Contracto')
                            {{$investidor->situation}}
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class=" col-12 d-flex align-items-center justify-content-center" style="min-height:200px;">
                <h2 style="font-size:25px;">Nenhum @if($investidor !=NULL )outro @endif Investidor Participou da Rodada.</h2>
            </div>
            @endforelse
        </div>
    </div>

</section>
@endsection



@section('scripts_base_inicio')
<script type="text/javascript" src="{{asset('assets/js/pagina_da_rodada.js')}}">
</script>
@endsection