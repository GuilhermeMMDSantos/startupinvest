@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/pagina_da_rodada.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid" style="padding-left:6.5% !important;padding-right:6.5% !important; padding-bottom:50px;">



    <h2 class="mb-4" id="title-page" val="{{$rodada->id}}">Rodada <i style="font-size:20px;margin-right:2px;color:#818182;">•</i><span style="font-size:15px;font-weight:bold;color:#818182;"> {{$rodada->estado}}</span></h2>

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
                        <div id="investor-invest-situation-container">
                            @if($investidor->status_investimento == 0)
                            @if ($rodada->estado == 'fechada' && $presentUser==$investidor->investidor->fk_user)
                            @if($investidor->contrato_mutou == NULL)
                            <p> Contracto de Investimento Pendente.</p>
                            @else
                            <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                            </div>
                            <button>Visualizar Contrato</button><br>
                            @if($investidor->status_contrato_investidor != 3 && $investidor->status_contrato_investidor != 4)
                            <button>Discordar Contrato</button>
                            @endif
                            @if($investidor->status_contrato_investidor == 1)
                            <p>Assinatura do Investidor em Falta.</p>
                            <button>Assinar Contrato</button>
                            @elseif($investidor->status_contrato_investidor == 3)
                            <p>Descordou Com os Termos do Contrato</p>
                            <button>Abrir Meeting</button>
                            @elseif($investidor->status_contrato_investidor == 4)
                            <p>Assinado Pelo Investidor</p>
                            @endif
                            @if($investidor->status_contrato_startup == 1)
                            <p>Assinatura do Sócio Fundador em Falta</p>
                            @elseif($investidor->status_contrato_startup == 4)
                            <p>Assinado Pelo Sócio Fundador</p>
                            @endif
                            @endif
                            @elseif($rodada->estado == 'aberta')
                            Investimento Captado.
                            @endif
                            @elseif($investidor->status_investimento == 1)
                            Investimento Reembolsado.
                            @elseif($investidor->status_investimento == 2)
                            Investimento Não Reembolsado
                            @endif
                        </div>
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
                            <div id="situation-container{{$investidor->fk_investidor}}" class="situation-container">
                                @if($investidor->status_investimento == 0)
                                @if ($rodada->estado == 'fechada' && $presentUser==$rodada->fk_startup)
                                @if($investidor->contrato_mutou == NULL)
                                <p> Contracto de Investimento Pendente.</p>
                                <input type="file" class="field-contract-2" linker="{{$investidor->fk_investidor}}" accept=".pdf" name="contrato_investimento" id="load-contrato-investimento{{$investidor->fk_investidor}}" hidden>
                                <label type="button" class="btn btn-primary" for="load-contrato-investimento{{$investidor->fk_investidor}}" style="font-size:14px;border-radius:20px;margin-top:5px;">Adicionar Contrato</label>
                                @else
                                <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                    <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                                </div>
                                <a href="{{route('view_doc',[$rodada->id, $investidor->fk_investidor])}}" rule="button" class="btn btn-primary" style="font-size:12px;margin-top:5px;">Visualizar Contrato</a>

                                @if($investidor->status_contrato_investidor != 4)
                                <button class="btn btn-primary btn-eliminar-contrato" linker="{{$investidor->fk_investidor}}" style="font-size:12px;margin-top:5px;">Eliminar Contrato</button>
                                @endif

                                @if($investidor->status_contrato_investidor == 3)
                                <p>Investidor Discorda Com os Termos do Contrato.</p>
                                <button class="btn btn-primary" style="font-size:12px;margin-top:5px;">Abrir Meeting</button><br>

                                @elseif($investidor->status_contrato_investidor == 1)
                                <p>Assinatura do Investidor em Falta.</p>
                                @elseif($investidor->status_contrato_investidor == 4)
                                <p>Assinado Pelo Investidor</p>
                                @endif

                                @if($investidor->status_contrato_startup == 1)
                                <p>Assinatura do Sócio Fundador em Falta</p>
                                <button class="btn btn-primary" style="font-size:12px;margin-top:5px;">Assinar Contrato</button>
                                @elseif($investidor->status_contrato_startup == 4)
                                <p>Assinado Pelo Sócio Fundador</p>
                                @endif

                                @endif
                                @elseif($rodada->estado == 'aberta')
                                Investimento Captado.
                                @endif
                                @elseif($investidor->status_investimento == 1)
                                Investimento Reembolsado.
                                @elseif($investidor->status_investimento == 2)
                                Investimento Não Reembolsado
                                @endif
                            </div>
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