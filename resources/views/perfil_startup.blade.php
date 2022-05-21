@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_startup.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:10px;">
    <div id="content-intro-startup" style="display:flex;padding-bottom:15px;border-bottom:2px solid #e9ecef;background: #f8f9fa;padding-left:5px;padding-top:5px;">


        <div style="width:110px;height:110px;border:1px solid #ccc;border-radius:50%;">
            <img src="{{asset('storage/'.$startup->logotipo)}}" style="width:100%;height:100%;border-radius:50%;">
        </div>



        <div style="width:87%;padding-left:15px;padding-right:5px;">
            <p>
                <span style="font-size:25px;margin-right:15px;">{{$startup->nome}}</span>
                @php
                $codigoStartup = Auth::user()->code_user;
                @endphp
                <input type="text" id="codigo-startup" value="{{Auth::user()->code_user}}" style="display:none;">
                <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->setor->nome}}</span>
                <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->fase->nome}}</span>
                <span style="margin-right:10px;color:#767d84;"><i style="font-size:20px;margin-right:2px;">•</i>{{$startup->tipobusnessfunc->nome}}</span>
            </p>
            <p style="margin-top:-15px;color:#0c141bb3;">
                {{ str_replace('##',' ',$startup->pitch_elevator) }}
            </p>
            <div style="text-align:right;;margin-top:-13px;">
                @if($myProfile)
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-editar-introducao-startup">Editar</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-outline-secondary" style="height:33px;font-size:14px; @if($startup->estado_busca_invest == 'sim') display:none; @endif">Buscar Investimento</button>
                <button type="button" class="btn btn-outline-secondary" style="height:33px;font-size:14px;@if($startup->estado_busca_invest == 'nao') display:none; @endif">Anular Investimento</button>

                @else
                @if($startup->estado_busca_invest == 'sim')
                <button type="button" class="btn btn-outline-secondary" style="height:33px;font-size:14px;">Solicitar pitch</button>
                &nbsp;
                @endif
                <button type="button" class="btn btn-outline-secondary" style="height:33px;font-size:14px;">Mensagem</button>

                @endif
            </div>
        </div>
    </div>
    @if($startup->estado_busca_invest == 'sim')
    <div class="row">
        <div class="col-sm-8">
            <video src="{{asset('storage/armazenamento/investidor/videos/video11.mp4')}}" controls="true" width="100%" height="500" />
        </div>
        <div class="col-sm-4" style="padding-top:10px;">
            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title" style="text-align:center;">Oferta - <span style="font-size:14px;">Faltam {{$rodada->tempo_restante}} Dias</span>
                    </h5>
                    <hr>
                    <div>
                        <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Busco</span>
                        <h5 style="color:green;text-align:center;">{{$rodada->valor_objetivo}}Kz</h5>
                    </div>
                    <div>
                        <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Por</span>
                        <h5 style="color:green;text-align:center;">{{$rodada->oferta}}% Participação Societária</h5>
                    </div>
                    <div>
                        <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Já Consegui</span>
                        <h5 style="color:green;text-align:center;">{{$rodada->valor_obtido}}Kz</h5>
                    </div>
                    <div>
                        <span style="font-weight: bold;text-align:center;display:inline-block;width:100%;">Investidores Na Rodada</span>
                        <h5 style="color:green;text-align:center;">{{count($rodada->investidores)}}</h5>
                    </div>
                    @if(!$myProfile)
                    <a href="#" class="btn btn-primary btn-lg btn-block">Investir</a>

                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-top:30px;padding-bottom:30px;">
        <div class="col-sm-12">
            <h2>Finalidades Do Investimento
            </h2>
            <ul id="content-finalidades-investimento">
                @foreach($rodada->finalidadesInvestimento as $finalidade)
                <li><i style="font-size:20px;margin-right:2px;">•</i>{{$finalidade->item}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="row" style="background:#e9ecefa6;margin-top:10px;">
        <div class="col-sm-12">
            <h2 style="text-align: center;">Investidores @if($myProfile)
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-adicionar-investidores-startup">Adicionar</button> @endif
            </h2>
            <table class="table table-striped">
                @if(count($investidoresDaStartup)>0)
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col" style="text-align:center;">Tipo</th>
                        <th scope="col" style="text-align:center; ">Porcentagem</th>
                        <th scope="col" style="text-align:center;">Contacto</th>

                        @if($myProfile) <th scope="col" style="text-align:center;width:15%;"></th>@endif
                    </tr>
                </thead>
                @endif
                <tbody id="body-table-investidores-da-startup">
                    @forelse($investidoresDaStartup as $investors)
                    <tr id="tupla_{{$investors->id}}">
                        <td>{{$investors->nome}} @if($investors->sobrenome != null) {{$investors->sobrenome}} @endif</td>
                        <td style="text-align:center;">@if($investors->tipo_entidade == 'fisica') Física @else Jurídica @endif</td>
                        <td style="text-align:center;">{{$investors->porcentagem_na_startup}}</td>
                        <td style="text-align:center;">{{$investors->email}}</td>

                        @if($myProfile)
                        <td style="text-align:center;">
                            <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-editar-investidor-startup" data-code="{{$investors->id}}" style="height: 30px;font-size: 12px;">Editar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-editar" style="height: 30px;font-size: 12px;" data-toggle="modal" data-target="#modal-excluir-investidor-startup" data-code="{{$investors->id}}">Eliminar</button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="color:#3333339c;">Startup Sem Investidor Informado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="padding-top:30px;">
        <div class="col-sm-12">
            <h2>Equipa @if($myProfile)
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-adicionar-membro-equipa">Adicionar</button> @endif
            </h2>
        </div>
    </div>
    <div class="row" style="padding-bottom:30px;">
        @forelse($membrosEquipa as $membro)
        <div class="col-sm-4" style="margin-top:10px;">
            <div class="card h-100">
                <div class="card-body">
                    <div style="width:80px;height:80px;border:1px solid #ccc;border-radius:50%;margin:auto;">
                        <img src="{{asset('storage/'.$membro->img)}}" style="width:100%;height:100%;border-radius:50%;">
                    </div>
                    <p style="text-align:center;">{{$membro->nome}}</p>
                    <p style="margin-top:-10px;text-decoration:underline;font-weight:bold;"></p>
                    <p style="margin-top:-10px;"><span style="color:#adb5bd;">Formação</span>: </p>
                    <p style="margin-top:-10px;"><span style="color:#adb5bd;">Experiência</span>: </p>
                </div>
                @if($myProfile)
                <div class="card-footer">
                    <button type="button" class="btn btn-primary btn-editar">Editar</button> &nbsp;
                    <button type="button" class="btn btn-primary btn-editar">Eliminar</button>
                </div>
                @endif
            </div>
        </div>
        @empty
        <p style="color:#3333339c;">Startup Sem Colaborador Informado</p>
        @endforelse
    </div>
</section>

<!-- Modal -->
@include('modais/editar_introducao_startup')
@include('modais/edicionar_investidores_startup')
@include('modais/editar_investidor_startup')
@include('modais/eliminar_investidor_startup')
@include('modais/adicionar_membro_equipa')


@endsection
@section('scripts_base_inicio')
<script type="text/javascript">
    $(function() {
        var codigoStartup = "{{$codigoStartup}}";
        $('#modal-editar-introducao-startup').on('show.bs.modal', function(event) {

            $.ajax({
                url: "/load_form_editar_introducao_startup",
                type: "get",
                data: {
                    '_token': '{{csrf_token()}}',
                    'codigoStartup': codigoStartup
                },
                success: function(response) {
                    $("#modal-editar-introducao-startup-body").empty();
                    $("#modal-editar-introducao-startup-body").html(response);
                },
                error: function(erro) {
                    console.log("ERRO");
                    console.log(erro);
                }
            });
        });


        $('#modal-editar-investidor-startup').on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);
            let code = button.data('code');

            $.ajax({
                url: "/load_form_editar_investidor_startup",
                type: "get",
                data: {
                    '_token': '{{csrf_token()}}',
                    'code': code
                },
                success: function(response) {
                    $("#modal-editar-investidor-startup-body").empty();
                    $("#modal-editar-investidor-startup-body").html(response);
                },
                error: function(erro) {
                    console.log("ERRO");
                    console.log(erro);
                }
            });

        });

        $("#modal-excluir-investidor-startup").on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let codeOfClickedBtn = button.data('code');

            $("#btn-aceitar-eliminar-investidor").prop('info', codeOfClickedBtn);

        });

        $("#btn-aceitar-eliminar-investidor").click(function() {
            let idInvestidorDaStartup = $(this).prop('info');

            $.ajax({
                url: "/eliminar_investidor_startup",
                type: "get",
                data: {
                    '_token': '{{csrf_token()}}',
                    'idInvestidorDaStartup': idInvestidorDaStartup
                },
                success: function(response) {
                    $("#tupla_" + idInvestidorDaStartup).remove();
                    $("#modal-excluir-investidor-startup").modal('hide');
                },
                error: function(erro) {
                    console.log("ERRO");
                    console.log(erro);
                }
            });

        });




    });
</script>
@endsection