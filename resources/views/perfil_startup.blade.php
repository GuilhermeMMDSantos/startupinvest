@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_startup.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:10px;">

    <div id="content-intro-startup" style="display:flex;padding-bottom:15px;border-bottom:2px solid #e9ecef;background: #f8f9fa;padding-left:5px;padding-top:5px;">

    </div>


    <div class="row" id="content-oferta">
    </div>


    <div class="row" style="background:#e9ecefa6;margin-top:30px;">
        <div class="col-sm-12">
            <h2 style="text-align: center;">Investidores @if($myProfile)
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-adicionar-investidores-startup">Adicionar</button> @endif
            </h2>

            <div id="container-table-investor-of-startup">
            </div>

        </div>
    </div>
    <div class="row" style="padding-top:30px;">
        <div class="col-sm-12">
            <h2>Equipa @if($myProfile)
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-adicionar-membro-equipa">Adicionar</button> @endif
            </h2>
        </div>
    </div>
    <div class="row" style="padding-bottom:30px;" id="container-membros-equipa">
        @forelse($membrosEquipa as $membro)
        <div class="col-sm-6" style="margin-top:10px;">
            <div class="card h-100">
                <div class="card-body">
                    <div style="width:80px;height:80px;border:1px solid #ccc;border-radius:50%;margin:auto;">
                        <img src="{{asset('storage/'.$membro->img)}}" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
                    </div>
                    <p style="text-align:center;">{{$membro->nome}}&nbsp;{{$membro->sobrenome}}</p>
                    <p style="margin-top:-10px;text-decoration:underline;font-weight:bold;">
                        @foreach($membro->cargosExecutivos as $cargo)
                        <span>{{$cargo->descricao}}({{$cargo->sigla}})</span><br>
                        @endforeach
                    </p>
                    <p style="margin-top:-10px;"><span style="color:#adb5bd;">Formação:</span>
                        @foreach($membro->formacoes as $formacao)
                        <span>{{$formacao->certificado->nome}} em {{$formacao->areafuncao->nome}} {{$formacao->dataInicioFormatada}} - {{$formacao->dataFimFormatada}}</span><br>
                        @endforeach
                    </p>
                    <p style="margin-top:-10px;"><span style="color:#adb5bd;">Experiência</span>:
                        @foreach($membro->experiencias as $experiencia)
                        <span>{{$experiencia->funcao->nome}} no(a) {{$experiencia->instituicao->nome}} </span><br>
                        @endforeach
                    </p>
                </div>
                @if($myProfile)
                <div class="card-footer">
                    <!--<button type="button" class="btn btn-primary btn-editar">Editar</button> &nbsp;-->
                    <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-excluir-membro-startup" data-code="{{$membro->id}}">Eliminar</button>
                </div>
                @endif
            </div>
        </div>
        @empty
        <p style="color:#3333339c;text-indent:25px;">Startup sem colaborador informado</p>
        @endforelse
    </div>
</section>

<!-- Modal -->
@include('modais/editar_introducao_startup')
@include('modais/edicionar_investidores_startup')
@include('modais/editar_investidor_startup')
@include('modais/eliminar_investidor_startup')
@include('modais/adicionar_membro_equipa')
@include('modais/eliminar_membro_startup')
@include('modais/adicionar_oferta');


@endsection
@section('scripts_base_inicio')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //VARIAVEIS UTILIZADAS NA FUNCIONALIDADE - ADICIONAR MEMBRO
    var formacoes = [];
    var experiencias = [];
    var contadorFormacoes = 0;
    var contadorExperiencias = 0;
    var certificadoInputFocus = false;
    var certificadoItemClicked = false;
    var areaFormacaoInputFocus = false;
    var areaFormacaoItemClicked = false;
    var haveImgMembro = false;
    //------------------------------------------------------

    $(function() {

        var codigoStartup = "{{$codigoStartup}}";
        loadIntroducaoStartup();
        loadOferta();
        loadInvestorsTable();

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


        //SOBRE OFERTA
        $("#input-pitch-video").change(function() {
            $("#input-aux-pitch-video").val($(this)[0].files[0].name);
        });

        $("#btn-publicar-oferta").click(function() {

            var metaOferta = $("#meta-oferta").val().trim();
            var porcetagemOferta = $("#porcentagem-oferta").val().trim();
            var terminoOferta = $("#termino-oferta").val().trim();
            var pitchVideo = $("#input-pitch-video").val().trim();
            var haveError = false;
            // var regexJustNumber = "/^[1-9]+$/";

            if (metaOferta.length == 0) {
                $("#content-alert-unset-meta").html('Meta em falta');
                haveError = true;
            } else
                $("#content-alert-unset-meta").html('');

            if (porcetagemOferta.length == 0) {
                $("#content-alert-unset-porcentagem").html('Porcentagem em falta ');
                haveError = true;

            } else if (isNaN(porcetagemOferta)) {
                $("#content-alert-unset-porcentagem").html('Informe somente número ');
                haveError = true;
            } else
                $("#content-alert-unset-porcentagem").html('');

            if (terminoOferta.length == 0) {
                $("#content-alert-unset-termino-angariacao").html('Data em falta ');
                haveError = true;
            } else
                $("#content-alert-unset-termino-angariacao").html('');


            if (pitchVideo.length == 0) {
                $("#content-alert-unset-pitch-video").html('Pitch em falta');
                haveError = true;
            } else
                $("#content-alert-unset-pitch-video").html('');

            if (haveError)
                return false;

            var myForm = new FormData();
            let csrf_code = '{{csrf_token()}}';
            let elementoPitchVideo = $("#input-pitch-video").prop("files")[0];
            myForm.append('csrfmiddlewaretoken', csrf_code);
            myForm.append('pitch_video', elementoPitchVideo);
            myForm.append('meta', metaOferta);
            myForm.append('porcentagem', porcetagemOferta);
            myForm.append('termino', terminoOferta);


            $.ajax({
                url: '/criar_oferta',
                type: 'POST',
                contentType: false,
                processData: false,
                data: myForm,
                success: function(response) {
                    loadOferta();
                    $("#btn-buscar-investimento").hide();
                    $("#btn-anular-ivestimento").show();

                    $("#modal-adicionar-oferta").modal('hide');
                },
                error: function(error) {
                    console.log("ERRO AO CADASTRAR OFERTA");
                    console.log(error);
                }
            });

        });

        $("#content-intro-startup").on('click', '#btn-anular-ivestimento', function() {
            $.ajax({
                url: '/anular_oferta',
                type: 'GET',
                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(response) {
                    loadIntroducaoStartup();
                    loadOferta();
                },
                error: function(error) {
                    console.log("ERRO AO ANULAR OFERTA");
                    console.log(error);
                }
            });
        });


        //SOBRE ADICIONAR MEMBRO

        $("#modal-adicionar-membro-equipa").on('show.bs.modal', function() {


            resetarFormularioAdicionarMembro();
            haveImgMembro = false;
            contadorFormacoes = 0;
            contadorExperiencias = 0;

            if ($("#img-membro-equipa-add").attr('src').indexOf("img_standard_membro") != -1) {

            }

            $.ajax({
                url: '/buscar_cargos_executvo',
                type: 'get',
                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(response) {
                    $("#cargos-executivo").empty();
                    $("#cargos-executivo").append(response);
                },
                error: function(error) {
                    console.log("ERRO AO BUSCAR CARGOS EXECUTIVO");
                    console.log(error);
                }
            });

        });

        // SOBRE ADICIONAR MEMBRO-TRATAMENTO DA BUSCA E SELECAO DO CERTIFICADO-FORMACAO

        $("#formacao-certificado-input").keyup(function() {

            let valorCertificadoInput = $(this).val().trim();
            certificadoInputFocus = true;
            certificadoItemClicked = false;

            $("#content-alert-unselected-certificado").html('');
            $("#formacao-certificado-input-hide").val('');

            if (valorCertificadoInput.length == 0) {
                $("#lista-resultado-busca-certificado").hide(400);
                return false;
            }
            $.ajax({
                url: '/buscar_certificados',
                type: 'get',
                data: {
                    '_token': '{{csrf_token()}}',
                    'valorCertificadoInput': valorCertificadoInput
                },
                success: function(response) {
                    $("#lista-resultado-busca-certificado").empty();
                    $("#lista-resultado-busca-certificado").append(response);
                    $("#lista-resultado-busca-certificado").show(400);
                },
                error: function(error) {
                    console.log("ERRO AO BUSCAR CERTIFICADOS");
                    console.log(error);
                }
            });
        });


        $("#lista-resultado-busca-certificado").on('click', 'a', function() {
            $("#formacao-certificado-input").val($(this).html());
            $("#formacao-certificado-input-hide").val($(this).attr('valor'));
            certificadoItemClicked = true;
        });

        //-------------------------------------------------------------------------

        // SOBRE ADICIONAR MEMBRO-TRATAMENTO DA BUSCA DA AREA DE FORMACAO

        $("#formacao-area-formacao-input").keyup(function() {

            let valorAreaFormacaoInput = $(this).val().trim();
            areaFormacaoInputFocus = true;
            areaFormacaoItemClicked = false;

            $("#content-alert-unselected-area-formacao").html('');
            $("#formacao-area-formacao-input-hide").val('');

            if (valorAreaFormacaoInput.length == 0) {
                $("#lista-resultado-busca-area-formacao").hide(400);
                return false;
            }
            $.ajax({
                url: '/buscar_areas_formacao',
                type: 'get',
                data: {
                    '_token': '{{csrf_token()}}',
                    'valorAreaFormacaoInput': valorAreaFormacaoInput
                },
                success: function(response) {
                    $("#lista-resultado-busca-area-formacao").empty();
                    $("#lista-resultado-busca-area-formacao").append(response);
                    $("#lista-resultado-busca-area-formacao").show(400);
                },
                error: function(error) {
                    console.log("ERRO AO BUSCAR AREAS FORMAÇÃO");
                    console.log(error);
                }
            });
        });

        $("#lista-resultado-busca-area-formacao").on('click', 'a', function() {
            $("#formacao-area-formacao-input").val($(this).html());
            $("#formacao-area-formacao-input-hide").val($(this).attr('valor'));
            areaFormacaoItemClicked = true;
        });

        //--------------------------------------------------------------------------

        //SOBRE ADICIONAR MEMBRO-TRATAMENTO DA BUSCA DA FUNCAO DA EXPERIENCIA

        $("#experiencia-funcao-input").keyup(function() {
            var wordsSearch = $(this).val().trim();

            $("#content-alert-emptyfield-funcao-experiencia").html('');
            $("#experiencia-funcao-input-hide").val('0');

            if (wordsSearch.length == 0) {
                $("#lista-resultado-busca-funcao-experiencia").hide(400);
                return false;
            }

            $.ajax({
                url: '/buscar_funcao_experiencia',
                type: 'get',
                data: {
                    '_token': '{{csrf_token()}}',
                    'wordsSearch': wordsSearch
                },
                success: function(response) {
                    $("#lista-resultado-busca-funcao-experiencia").empty();
                    $("#lista-resultado-busca-funcao-experiencia").append(response['html']);
                    if (response['qtd'] > 0)
                        $("#lista-resultado-busca-funcao-experiencia").show(400);
                },
                error: function(error) {
                    console.log("ERRO AO BUSCAR AREAS FORMAÇÃO");
                    console.log(error);
                }
            });
        });

        $("#lista-resultado-busca-funcao-experiencia").on('click', 'a', function() {
            $("#experiencia-funcao-input").val($(this).html());
            $("#experiencia-funcao-input-hide").val($(this).attr('valor'));
        });

        //-------------------------------------------------------------------

        //SOBRE ADICIONAR MEMBRO-TRATAMENTO DA BUSCA DA INSTITUICAO DA EXPERIENCIA

        $("#experiencia-instituicao-input").keyup(function() {
            var wordsSearch = $(this).val().trim();

            $("#content-alert-emptyfield-instituicao-experiencia").html('');
            $("#experiencia-instituicao-input-hide").val('0');

            if (wordsSearch.length == 0) {
                $("#lista-resultado-busca-instituicao-experiencia").hide(400);
                return false;
            }

            $.ajax({
                url: '/buscar_intituicao_experiencia',
                type: 'get',
                data: {
                    '_token': '{{csrf_token()}}',
                    'wordsSearch': wordsSearch
                },
                success: function(response) {
                    $("#lista-resultado-busca-instituicao-experiencia").empty();
                    $("#lista-resultado-busca-instituicao-experiencia").append(response['html']);
                    if (response['qtd'] > 0)
                        $("#lista-resultado-busca-instituicao-experiencia").show(400);
                },
                error: function(error) {
                    console.log("ERRO AO BUSCAR FUNCAO EXPERIENCIA");
                    console.log(error);
                }
            });
        });

        $("#lista-resultado-busca-instituicao-experiencia").on('click', 'a', function() {
            $("#experiencia-instituicao-input").val($(this).html());
            $("#experiencia-instituicao-input-hide").val($(this).attr('valor'));
        });
        //-------------------------------------------------------------------

        $(document).click(function(elemento) {
            $(".my-select-input").hide(100);
            if (certificadoInputFocus && !certificadoItemClicked && $("#formacao-certificado-input").val().trim().length > 0) {
                $("#content-alert-unselected-certificado").html('Não selecionou um certificado');
                certificadoInputFocus = false;
            }

            if (areaFormacaoInputFocus && !areaFormacaoItemClicked && $("#formacao-area-formacao-input").val().trim().length > 0) {
                $("#content-alert-unselected-area-formacao").html('Não selecionou uma área de formação');
                areaFormacaoInputFocus = false;
            }
        });

        //-----VALIDAÇÃO DATAS FORMAÇÃO
        $("#formacao-mes-ano-inicio").change(function() {
            $("#formacao-mes-ano-fim").attr('min', $("#formacao-mes-ano-inicio").val());
            $("#content-alert-unselected-data-formacao-inicio").html('');

        });

        $("#formacao-mes-ano-fim").change(function() {
            $("#formacao-mes-ano-inicio").attr('max', $("#formacao-mes-ano-fim").val());
            $("#content-alert-unselected-data-formacao-fim").html('');
        });

        //------------------------------

        $("#nome-membro-equipa").keypress(function() {
            $("#content-alert-unselected-nome-membro").html();
        });

        $("#sobrenome-membro-equipa").keypress(function() {
            $("#content-alert-unselected-sobrenome-membro").html();
        });

        $("#btn-salvar-formacao").click(function() {


            if ($("#formacao-mes-ano-inicio").val().trim().length == 0)
                $("#content-alert-unselected-data-formacao-inicio").html('Não selecionou uma data');

            if ($("#formacao-mes-ano-fim").val().trim().length == 0)
                $("#content-alert-unselected-data-formacao-fim").html('Não selecionou uma data');

            if (!areaFormacaoItemClicked)
                $("#content-alert-unselected-area-formacao").html('Não selecionou uma área de formação');
            if (!certificadoItemClicked)
                $("#content-alert-unselected-certificado").html('Não selecionou um certificado');

            if ($("#formacao-mes-ano-inicio").val().trim().length == 0 || $("#formacao-mes-ano-fim").val().trim().length == 0 || !areaFormacaoItemClicked || !certificadoItemClicked)
                return false;

            let certificadoValue = $("#formacao-certificado-input").val();
            let certificadoId = $("#formacao-certificado-input-hide").val();
            let areaFormacaoValue = $("#formacao-area-formacao-input").val();
            let areaFormacaoId = $("#formacao-area-formacao-input-hide").val();
            let dataInicioValue = $("#formacao-mes-ano-inicio").val();
            let dataFimValue = $("#formacao-mes-ano-fim").val();

            let formacao = {
                certificado: certificadoId,
                areaformacao: areaFormacaoId,
                datainicio: dataInicioValue,
                datafim: dataFimValue
            };



            contadorFormacoes++;

            formacoes['line' + contadorFormacoes] = formacao;

            let htmlElement = "<li id='line" + contadorFormacoes + "'>" + certificadoValue + " em " + areaFormacaoValue + " (" + dataInicioValue + "-" + dataFimValue + ")<i class='fa fa-bell dismiss-line' _id='line" + contadorFormacoes + "' style='float:right;' role='button'></i></li>";

            $("#lista-formacoes").append(htmlElement);

            $("#content-form-adicionar-formacao").hide();





            if (contadorFormacoes < 3)
                $("#btn-show-form-formacao").show();
            else
                $("#btn-show-form-formacao").hide();



        });

        $("#lista-formacoes").on('click', '.dismiss-line', function() {
            let valor = $(this).attr('_id');
            $("#" + valor).remove();
            delete formacoes[valor];
            contadorFormacoes--;
            if (contadorFormacoes < 3)
                $("#btn-show-form-formacao").show();


        });

        $("#btn-salvar-experiencia").click(function() {
            let funcaoIsEmpty = false;
            let instituicaoIsEmpty = false;
            let dataIsEmpty = false;

            if ($("#experiencia-funcao-input").val().trim().length == 0) {
                $("#content-alert-emptyfield-funcao-experiencia").html('Não informou o função');
                funcaoIsEmpty = true;
            }

            if ($("#experiencia-instituicao-input").val().trim().length == 0) {
                $("#content-alert-emptyfield-instituicao-experiencia").html('Não informou a instituição');
                instituicaoIsEmpty = true;
            }

            if ($("#experiencia-mes-ano-inicio").val().trim().length == 0) {
                $("#content-alert-emptyfield-datainico-experiencia").html('Não informou a data');
                dataIsEmpty = true;
            }

            if (funcaoIsEmpty || instituicaoIsEmpty || dataIsEmpty)
                return false;


            let funcaoValue = $("#experiencia-funcao-input").val();
            let idFuncao = $("#experiencia-funcao-input-hide").val();
            let instituicaoValue = $("#experiencia-instituicao-input").val();
            let idInstituicao = $("#experiencia-instituicao-input-hide").val();
            let dataInicioValue = $("#experiencia-mes-ano-inicio").val();
            let dataFimValue = $("#experiencia-mes-ano-fim").val();

            if (dataFimValue.length == 0)
                dataFimValue = "momento";

            let experiencia = {
                funcao: funcaoValue,
                idFuncao: idFuncao,
                instituicao: instituicaoValue,
                idInstituicao: idInstituicao,
                datainicio: dataInicioValue,
                datafim: dataFimValue
            };



            contadorExperiencias++;

            experiencias['line_experiencia' + contadorExperiencias] = experiencia;

            let htmlElement = "<li id='line_experiencia" + contadorExperiencias + "'>" + funcaoValue + " no(a)  " + instituicaoValue + " desde " + dataInicioValue + "-" + dataFimValue + "<i class='fa fa-bell dismiss-line' _id='line_experiencia" + contadorExperiencias + "' style='float:right;' role='button'></i></li>";

            $("#lista-experiencias").append(htmlElement);

            $("#content-form-adicionar-experiencia").hide();

            if (contadorExperiencias < 3)
                $("#btn-show-form-experiencia").show();
            else
                $("#btn-show-form-experiencia").hide();

        });

        $("#lista-experiencias").on('click', '.dismiss-line', function() {
            let valor = $(this).attr('_id');
            $("#" + valor).remove();
            delete experiencias[valor];
            contadorExperiencias--;
            if (contadorExperiencias < 3)
                $("#btn-show-form-experiencia").show();
        });

        $("#btn-show-form-formacao").click(function() {
            $("#formacao-certificado-input").val('');
            $("#formacao-area-formacao-input").val('');
            areaFormacaoItemClicked = false;
            certificadoItemClicked = false;

            $("#content-form-adicionar-formacao").show();
            $("#content-form-adicionar-experiencia").hide();

            if (contadorExperiencias < 3)
                $("#btn-show-form-experiencia").show();


            $(this).hide();
        });

        $("#btn-show-form-experiencia").click(function() {
            $("#experiencia-funcao-input").val('');
            $("#experiencia-instituicao-input").val('');
            $("#content-form-adicionar-experiencia").show();
            $("#content-form-adicionar-formacao").hide();
            if (contadorFormacoes < 3)
                $("#btn-show-form-formacao").show();

            $(this).hide();
        });

        $("#btn-cancelar-add-formacao").click(function() {
            $("#content-form-adicionar-formacao").hide();
            if (contadorFormacoes < 3)
                $("#btn-show-form-formacao").show();
        });

        $("#btn-cancelar-add-experiencia").click(function() {
            $("#content-form-adicionar-experiencia").hide();
            if (contadorExperiencias < 3)
                $("#btn-show-form-experiencia").show();
        });

        $("#load_img-membro-equipa-add").change(function() {

            let myForm = new FormData();
            let csrf_code = '{{csrf_token()}}';
            let userCode = codigoStartup;
            let elementoInput = $("#load_img-membro-equipa-add").prop("files")[0];
            myForm.append('img_tmp', elementoInput);
            myForm.append('code', userCode)
            myForm.append('csrfmiddlewaretoken', csrf_code);
            haveImgMembro = true;

            $.ajax({
                url: '/load_tmp_img_membro_equipa',
                type: 'POST',
                contentType: false,
                processData: false,
                data: myForm,
                async: false,
                success: function(response) {
                    let srcDaImg = $("#img-membro-equipa-add").attr('src');
                    let novaSrc = srcDaImg.substring(0, srcDaImg.indexOf("armazenamento")) + '' + response;
                    $("#img-membro-equipa-add").attr('src', novaSrc)
                },
                error: function(error) {
                    console.log("Erro");
                    console.log(error);
                }
            });

            $(".content-btn-remove-img-membro-equipa").show();
        });

        $(".btn-remove-img-membro-equipa").click(function() {

            let userCode = codigoStartup;
            let srcDaImg = $("#img-membro-equipa-add").attr('src');
            let novaSrc = srcDaImg.substring(0, srcDaImg.indexOf("armazenamento")) + 'armazenamento/startups/img/membros/img_standard_membro_equipa.png';
            $("#img-membro-equipa-add").attr('src', novaSrc);

            $(".content-btn-remove-img-membro-equipa").hide();
            haveImgMembro = false;
        });

        $(".item-cargos-executivo").click(function() {
            $("#content-alert-unselected-cargo-membro").html('');
        });

        $("#nome-membro-equipa").keyup(function() {
            $("#content-alert-unselected-nome-membro").html('');
        });

        $("#sobrenome-membro-equipa").keyup(function() {
            $("#content-alert-unselected-sobrenome-membro").html('');
        });

        $("#btn-adicionar-membro-equipa").click(function() {



            let lengthNome = $("#nome-membro-equipa").val().trim().length;
            let lengthSobreNome = $("#sobrenome-membro-equipa").val().trim().length;

            if (lengthNome == 0)
                $("#content-alert-unselected-nome-membro").html('Não informou o nome');

            if (lengthSobreNome == 0)
                $("#content-alert-unselected-sobrenome-membro").html('Não informou o sobrenome');

            if (lengthNome == 0 || lengthSobreNome == 0)
                return false;


            let csrf_code = '{{csrf_token()}}';
            let img = $("#load_img-membro-equipa-add").prop("files")[0];
            let nomeMembroEquipa = $("#nome-membro-equipa").val();
            let sobrenome = $("#sobrenome-membro-equipa").val();
            let cargoExecutivo = $("#cargos-executivo").val();
            var escolheuCargo = false;

            let form = new FormData();
            form.append('csrfmiddlewaretoken', csrf_code);
            form.append('imagem', img);
            form.append('haveImg', haveImgMembro);
            form.append('nome', nomeMembroEquipa);
            form.append('sobrenome', sobrenome);
            form.append('cargo', cargoExecutivo);
            form.append('experiencia', experiencias);
            let formacaoString = '';
            var formacoesVetor = [];
            var experienciaString = '';
            var experienciasVetor = [];
            var cargosString = '';


            for (let iterador = 0; iterador <= contadorFormacoes; iterador++) {

                if (formacoes['line' + iterador] != undefined) {

                    formacaoString = formacoes['line' + iterador]['certificado'] + '|' + formacoes['line' + iterador]['areaformacao'] + '|' + formacoes['line' + iterador]['datainicio'] + '|' + formacoes['line' + iterador]['datafim'];
                    formacoesVetor.push(formacaoString);
                }
            }


            for (let iterador = 0; iterador <= contadorExperiencias; iterador++) {
                if (experiencias['line_experiencia' + iterador] != undefined) {
                    experienciaString = experiencias['line_experiencia' + iterador]['funcao'] + '|' + experiencias['line_experiencia' + iterador]['idFuncao'] + '|' + experiencias['line_experiencia' + iterador]['instituicao'] + '|' + experiencias['line_experiencia' + iterador]['idInstituicao'] + '|' + experiencias['line_experiencia' + iterador]['datainicio'] + '|' + experiencias['line_experiencia' + iterador]['datafim'];
                    experienciasVetor.push(experienciaString);
                }
            }




            $(".item-cargos-executivo").each(function() {
                if ($(this).prop('checked')) {
                    cargosString = $(this).val() + '|' + cargosString
                    escolheuCargo = true;
                }
            });

            if (escolheuCargo == false) {
                $("#content-alert-unselected-cargo-membro").html("Deve escolher pelo menos um(1) cargo. Somente deve existir um(1) colaborador a exercer um determinado cargo.");
                return false;
            }


            form.append('formacao', formacoesVetor);
            form.append('experiencia', experienciasVetor);
            form.append('cargos', cargosString);

            $.ajax({
                url: '/add_membro_equipa',
                type: 'POST',
                contentType: false,
                processData: false,
                data: form,
                success: function(response) {

                    $("#container-membros-equipa").empty();
                    $("#container-membros-equipa").append(response);
                    $('#modal-adicionar-membro-equipa').modal('hide');
                },
                error: function(error) {
                    console.log("ERRO");
                    console.log(error);
                }
            });
        });


        $("#content-intro-startup").on('click', '#btn-solicitar-pitch', function() {
            var codeStartup = '{{$codigoStartup}}';
            $.ajax({
                url: "/solicitar_pitch",
                type: "get",
                data: {
                    'codeStartup': codeStartup
                },
                success: function(response) {
                    
                    loadIntroducaoStartup();
                },
                error: function(error) {
                    console.log("Erro ao solicitar pitch");
                    console.log(error);
                }
            });
        });

        function resetarFormularioAdicionarMembro() {

            let dataAtual = consultarDataAtual();
            let valorAtualAtributoSrcDaImagemMembro = $("#img-membro-equipa-add").attr('src');
            let novoValorAtributoSrcDaImagemMembro = valorAtualAtributoSrcDaImagemMembro.substring(0, valorAtualAtributoSrcDaImagemMembro.indexOf("armazenamento")) + 'armazenamento/startups/img/membros/img_standard_membro_equipa.png';


            $("#img-membro-equipa-add").attr('src', novoValorAtributoSrcDaImagemMembro);

            $("#load_img-membro-equipa-add").val('');
            $(".content-btn-remove-img-membro-equipa").hide();
            $("#nome-membro-equipa").val('');
            $("#sobrenome-membro-equipa").val('');

            $("#lista-formacoes").empty();
            $("#formacao-certificado-input").val('');
            $("#formacao-certificado-input-hide").val('');
            $("#formacao-area-formacao-input").val('');
            $("#formacao-area-formacao-input-hide").val('');

            $("#formacao-mes-ano-inicio").attr('value', '1975-11');
            $("#formacao-mes-ano-inicio").attr('min', '1975-11');
            $("#formacao-mes-ano-inicio").attr('max', dataAtual);

            $("#formacao-mes-ano-fim").attr('value', dataAtual);
            $("#formacao-mes-ano-fim").attr('max', dataAtual);
            $("#formacao-mes-ano-fim").attr('min', '1975-11');

            $("#btn-show-form-formacao").show();

            $("#content-form-adicionar-formacao").hide();

            $("#lista-experiencias").empty();

            $("#experiencia-funcao-input").val('');
            $("#experiencia-funcao-input-hide").val('');
            $("#experiencia-instituicao-input").val('');
            $("#experiencia-instituicao-input-hide").val('');

            $("#experiencia-mes-ano-inicio").attr('value', dataAtual);
            $("#experiencia-mes-ano-inicio").attr('min', '1975-11');
            $("#experiencia-mes-ano-inicio").attr('max', dataAtual);

            $("#experiencia-mes-ano-fim").val('');

            $("#btn-show-form-experiencia").show();

            $("#content-form-adicionar-experiencia").hide();
        }

        function consultarDataAtual() {
            let dataNow = new Date();
            let mes = dataNow.getMonth() < 10 ? '0' + (dataNow.getMonth() + 1) : (dataNow.getMonth() + 1);
            let dataNowFormated = dataNow.getFullYear() + '-' + mes;

            return dataNowFormated;
        }

        function loadInvestorsTable() {

            var isMyProfile = '{{$myProfile}}' == 1 ? true : false;
            let codeUser = '{{$codigoStartup}}';



            $.ajax({
                url: '/load_investors_table',
                type: 'get',
                data: {
                    'ismyprofile': isMyProfile,
                    'codigoStartup': codeUser

                },
                success: function(response) {


                    $("#container-table-investor-of-startup").empty();
                    $("#container-table-investor-of-startup").append(response['html']);
                },
                error: function(error) {
                    console.log("Erro ao carregar tabela de investidores");
                    console.log(error);
                }
            });
        }

        function loadOferta() {

            var codeStartup = "{{$codigoStartup}}";

            $.ajax({
                url: "/load_oferta",
                type: "get",
                data: {
                    "codeStartup": codeStartup
                },
                success: function(response) {

                    $("#content-oferta").empty();
                    $("#content-oferta").append(response['html']);
                },
                error: function(error) {
                    console.log("Erro ao carregar oferta");
                    console.log(error);
                }
            });
        }

        function loadIntroducaoStartup() {

            $.ajax({
                url: "/load_introducao_startup",
                type: "get",
                data: {
                    "codigoStartup": codigoStartup
                },
                success: function(response) {

                    $("#content-intro-startup").empty();
                    $("#content-intro-startup").append(response['html']);
                },
                error: function(error) {
                    console.log("Erro ao carregar introducao startup");
                    console.log(error);
                }
            });
        }

        $(document).on("click", "#pagination a,#search_btn", function() {


            var url = $(this).attr("href");

            var finalURL = url;

            var isMyProfile = '{{$myProfile}}' == 1 ? true : false;

            let codeUser = '{{$codigoStartup}}';

            $.ajax({
                url: finalURL,
                type: 'get',
                data: {
                    'ismyprofile': isMyProfile,
                    'codigoStartup': codeUser
                },
                success: function(response) {
                    $("#container-table-investor-of-startup").empty();
                    $("#container-table-investor-of-startup").append(response['html']);
                },
                error: function(error) {
                    console.log("Erro ao carregar tabela de investidores");
                    console.log(error);
                }
            });
            return false;
        })



        




    });
</script>
@endsection