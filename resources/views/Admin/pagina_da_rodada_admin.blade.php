@extends('Admin.layout_admin')

@section('stylesheets_admin')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pagina_da_rodada_admin.css') }}">
@endsection

@section('contentBody_admin')
<section id="body-section" class="container-fluid"
    style="padding-left:6.5% !important;padding-right:6.5% !important; padding-bottom:50px;">

    <h2 class="mb-4" id="title-page" val="{{ $rodada->id }}">Rodada <i
            style="font-size:20px;margin-right:2px;color:#818182;">•</i><span
            style="font-size:15px;font-weight:bold;color:#818182;" id="rodada-status"> {{ $rodada->estado }}</span></h2>

    <div class="card" style="margin-bottom:15px;" id="intro-rodada">

        <div class="card-body row">
            <div class="col-sm-3 col-12">
                <h5>Rodada</h5>
                <h6>{{ $rodada->id }}</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor objectivo</h5>
                <h6>{{ number_format($rodada->valor_objetivo, 2, ',', '.') }} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor Captado</h5>
                <h6>{{ number_format($rodada->valor_obtido, 2, ',', '.') }} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Participação Oferecida</h5>
                <h6>{{ $rodada->oferta_acoes }}%</h6>
            </div>

        </div>
    </div>


    <div id="container-transfer-our-comprovativo">
        
    </div>


   
    <h5 style="color:#818182;">Investidores na Rodada</h5>

    <div class="row">
        @forelse($investidores as $investidor)
        <div class="col-sm-6 col-12">
            <div class="card  h-100">
                <div class="card-body row card-investor-rodada">
                    <div class="col-12 col-sm-8">
                        <p>
                            <span class="badge badge-primary">Investidor</span>&nbsp;<a
                                href="{{ route('startup.perfil', $investidor->investidor->user->code_user) }}">{{ $investidor->investidor->nome_completo }}</a>
                        </p>
                        <p>
                            <span
                                class="badge badge-primary">Aportado</span>&nbsp;<span>{{ number_format($investidor->valor_investido, 2, ',', '.') }}
                                AOA</span>
                        </p>
                        <p>
                            <span class="badge badge-primary">Porcentagem</span>&nbsp;<span>
                                {{ $investidor->acoes_adquirida }}%</span>
                        </p>
                        <div>
                            <h6 class="badge badge-primary">Confirmação da Assinatura de Contrato</h6><br>
                            <div>
                                @if($investidor->comprovativo_assinatura == null)
                                <div class="alert alert-info" role="alert">
                                    <p style="font-size:14px;">Após as assinaturas, A startup, deve submeter um video feito pelos sócios fundadores a confirmar a assinatura do contrato com o referido investidor, qual o valor captado com o investidor e qual a porcentagem para o investidor.</p>
                                </div>
                                @else
                                <a href="{{asset('storage/'.$investidor->comprovativo_assinatura)}}" target="_blank"><i class="fas fa-film"></i> Comprovativo de Assinatura da Startup</a>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align:center;">
                        <p><span class="badge badge-primary">Contrato</span></p>
                        <div id="situation-container{{ $investidor->fk_investidor }}"
                            class="situation-container">
                            <a href="{{asset('storage/'.$investidor->contrato_mutou)}}" target="_blank"><i class="fas fa-file-contract"></i> Contrato Financimento</a><br>
                            @if ($investidor->status_contrato_investidor == 3)
                            <p style="text-align:center; font-size:12px;">Investidor Discorda Com os Termos do Contrato.</p>

                            @elseif($investidor->status_contrato_investidor == 1)
                            <p style="text-align:center; font-size:12px;">Assinatura do Investidor em Falta.</p>
                            @elseif($investidor->status_contrato_investidor == 4)
                            <p style="text-align:center; font-size:12px;">Assinado Pelo Investidor</p>
                            @endif

                            @if ($investidor->status_contrato_startup == 1)
                            <p style="text-align:center; font-size:12px;">Assinatura do Sócio Fundador em Falta</p>

                            @elseif($investidor->status_contrato_startup == 4)
                            <p style="text-align:center; font-size:12px;">Assinado Pelo Sócio Fundador</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class=" col-12 d-flex align-items-center justify-content-center" style="min-height:200px;">
            <h2 style="font-size:25px;">Nenhum Investidor Participou da Rodada.</h2>
        </div>
        @endforelse
    </div>


</section>
<div id="element-pass1" data-value="{{$rodadaId}}"></div>
@include("modais/send_money_to_startup");
@endsection

@section('scripts_admin')
<script src="{{ asset('assets/js/pagina_da_rodada_admin.js') }}"></script>
@endsection