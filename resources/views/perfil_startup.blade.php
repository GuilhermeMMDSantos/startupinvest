@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_startup.css')}}" />
@endsection

@section('contentBody_base_inicio')


<section id="body-section" class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:10px;">
    <input type="text" value="{{$codigoStartup}}" id="codigo-startup" hidden>
    <div id="content-intro-startup">
        <div class="d-flex justify-content-center " style="width:100%;height:120px;">
            <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <div class="row" id="content-oferta">
        <div class="d-flex justify-content-center " style="width:100%;height:400px;">
            <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    
    @if($startup->estado_busca_invest == 'sim' && $currentTypeUser != 'startup')
    <div class="row" id="content-avalutation">
        <div class="d-flex justify-content-center " style="width:100%;height:400px;">
            <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    @endif

    <div class="row" style="background:#e9ecefa6;margin-top:30px;">
        <div class="col-sm-12">
            <h2>Investidores @if($myProfile)
                <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-adicionar-investidores-startup">Adicionar</button> @endif
            </h2>

            <div id="container-table-investor-of-startup">
                <div class="d-flex justify-content-center " style="width:100%;height:320px;">
                    <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
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
        <div class="d-flex justify-content-center " style="width:100%;height:320px;">
            <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>



    <div id="popup-chat-container">
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
@include('modais/investir');


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

    var showChat = false;
    var destinatarioMessageChat = '';
    var heightComponenteMessage = 0;
    var popupChatOpen = false;
    //------------------------------------------------------

    var codigoStartup = "{{$codigoStartup}}";
    destinatarioMessageChat = "{{$startup->fk_user}}";

    var loader = "<div class='d-flex flex-column justify-content-center align-items-center' style='min-height:240px;'>\
                        <div class='spinner-border' role='status' style='width:50px;height:50px;'>\
                        </div>\
                    </div>";

    var loaderComParagrafo = "<div class='d-flex flex-column justify-content-center align-items-center' style='min-height:240px;'>\
                    <div class='spinner-border' role='status' style='width:50px;height:50px;'>\
                    </div>\
                    <p>Processando...</p>\
                </div>";


    $(function() {

        loadIntroducaoStartup();
        loadOferta();
        loadAvaluationContent();
        loadInvestorsTable();
        loadMembrosEquipa();

        $(".my-currency-format").val('0,00');
        $(".my-currency-format").keyup(function(e) {
            let valor = $(this).val();
            let valor_formatado = set_format(valor);
            $(this).val(valor_formatado);
            if ($(this).attr('name') == 'meta')
                show_valor_a_acrescer(valor);
        });
        $(".my-currency-format").keypress(function(e) {
            if (!(e.key >= 0 && e.key <= 9) && e.key != "Backspace")
                e.preventDefault();
        });

        $("#valor-a-investir").keyup(function() {

            let rodada_id = "{{$rodadaId}}";
            let valorMontante = $(this).val();
            $.ajax({
                url: "/atualizar_porcentagem_pelo_montante",
                type: "get",
                data: {
                    'rodada_id': rodada_id,
                    'valorMontante': valorMontante
                },
                success: function(response) {
                    $("#porcentagem-por-valor").val(response['porcentagem']);
                },
                error: function(erro) {
                    console.log("ERRO AO ATUALIZAR PORCENTAGEM");
                    console.log(erro);
                }
            });
        });

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


        $("#modal-excluir-membro-startup").on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let codeOfClickedBtn = button.data('code');

            $("#btn-aceitar-eliminar-membro").prop('info', codeOfClickedBtn);

        });

        $("#modal-investir").on('hidden.bs.modal', function(e) {
            $("#btn-spinner-investir").css({
                'display': 'none'
            });
        })

        $("#btn-aceitar-eliminar-membro").click(function() {
            let idMembroDaStartup = $(this).prop('info');

            $.ajax({
                url: "/eliminar_membro_startup",
                type: "get",
                data: {
                    '_token': '{{csrf_token()}}',
                    'idMembroDaStartup': idMembroDaStartup
                },
                success: function(response) {
                    loadMembrosEquipa();
                    $("#modal-excluir-membro-startup").modal('hide');
                },
                error: function(erro) {
                    console.log("ERRO");
                    console.log(erro);
                }
            });

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
                    loadInvestorsTable();
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

        $('#modal-adicionar-oferta').on('hidden.bs.modal', function(e) {
            $("#btn-spinner-oferta").css({
                'display': 'none'
            });
            $('#modal-adicionar-oferta input').val('');
            $("#modal-adicionar-oferta input[type='text']").val('0,00');
            $("#max-investidores").val(1);
            $(".alert-adicionar-oferta").html('');
            $('.is-invalid').removeClass("is-invalid");
        })
/*
        $("#btn-publicar-oferta").click(function() {

            let myForm = new FormData($("#form-criar-oferta")[0]);

            $("#btn-spinner-oferta").css({
                'display': 'inline-block'
            });
            if (!check_empty_field(myForm)) {
                $("#btn-spinner-oferta").css({
                    'display': 'none'
                });
                return false;
            }
            $.ajax({
                url: '/criar_oferta',
                type: 'POST',
                contentType: false,
                processData: false,
                data: myForm,
                success: function(response) {
                    if (response['status'] == 200) {
                        loadOferta();
                        $("#btn-buscar-investimento").hide();

                        Swal.fire({
                            icon: "success",
                            title: "Oferta Publicada",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $("#btn-anular-ivestimento").show();
                        $("#modal-adicionar-oferta").modal('hide');
                    } else {
                        if (response[0]["meta"]) {
                            $("#meta-oferta").addClass("is-invalid");
                            $("#alert-meta").html(response[0]["meta"]);
                        }
                        if (response[0]["porcentagem"]) {
                            $("#porcentagem-oferta").addClass("is-invalid");
                            $("#alert-porcentagem").html(response[0]["porcentagem"]);
                        }
                        $("#btn-spinner-oferta").css({
                            'display': 'none'
                        });
                    }

                },
                error: function(error) {
                    console.log("ERRO AO CADASTRAR OFERTA");
                    console.log(error);
                }
            });

        });
        */

        $("#btn-publicar-oferta").click(function() {
            var formPublicarOferta = new FormData($("#form-criar-oferta")[0]);

            $("#btn-spinner-oferta").css({
                'display': 'inline-block'
            });

            $.ajax({
                url: '/criar_oferta',
                type: 'POST',
                contentType: false,
                processData: false,
                data: formPublicarOferta,
                success: function(response) {
                    if (response['status'] == 200) {
                        loadOferta();
                        $("#btn-buscar-investimento").hide();

                        Swal.fire({
                            icon: "success",
                            title: "Oferta Publicada",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $("#btn-anular-ivestimento").show();
                        $("#modal-adicionar-oferta").modal('hide');
                    } else {
                       /* if (response[0]["meta"]) {
                            $("#meta-oferta").addClass("is-invalid");
                            $("#alert-meta").html(response[0]["meta"]);
                        }
                        if (response[0]["porcentagem"]) {
                            $("#porcentagem-oferta").addClass("is-invalid");
                            $("#alert-porcentagem").html(response[0]["porcentagem"]);
                        }*/
                       console.log("STATUS DIFERENTE DE 200");
                       console.log(response['message']);
                        $("#btn-spinner-oferta").css({
                            'display': 'none'
                        });
                    }

                },
                error: function(error) {
                    console.log("ERRO AO CADASTRAR OFERTA");
                    console.log(error);
                }
            });
        });

        $("#content-intro-startup").on('click', '#btn-anular-ivestimento', function() {

            Swal.fire({
                title: "Deseja Anular Rodada?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#c43333bf",
                cancelButtonColor: "#319c4ad4",
                confirmButtonText: "Desejo",
                cancelButtonText: "Não",
                customClass: {
                    confirmButton: 'btn-anular-rodada',
                    cancelButton: 'btn-anular-rodada'
                }
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/anular_oferta',
                        type: 'GET',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'rodada_id': '{{$rodadaId}}'
                        },
                        success: function(response) {
                            loadIntroducaoStartup();
                            loadOferta();
                            Swal.fire({
                                icon: "success",
                                title: "Rodada Anulada",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(error) {
                            console.log("ERRO AO ANULAR OFERTA");
                            console.log(error);
                        }
                    });



                }
            });


        });


        $("#input-pitch-video").change(function() {
            if (($(this)[0].files[0].size / 1000000) < 65) {
                $("#pitch-label-tamanho").css({
                    'color': 'black'
                });
            } else {
                $("#pitch-label-tamanho").css({
                    'color': 'red'
                });
            }
        });



        //SOBRE ADICIONAR MEMBRO

        $("#modal-adicionar-membro-equipa").on('show.bs.modal', function() {


            resetarFormularioAdicionarMembro();

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

            if (!areaFormacaoItemClicked)
                $("#content-alert-unselected-area-formacao").html('Não selecionou uma área de formação');
            if (!certificadoItemClicked)
                $("#content-alert-unselected-certificado").html('Não selecionou um certificado');

            if (!areaFormacaoItemClicked || !certificadoItemClicked)
                return false;

            let certificadoValue = $("#formacao-certificado-input").val();
            let certificadoId = $("#formacao-certificado-input-hide").val();
            let areaFormacaoValue = $("#formacao-area-formacao-input").val();
            let areaFormacaoId = $("#formacao-area-formacao-input-hide").val();


            let formacao = {
                certificado: certificadoId,
                areaformacao: areaFormacaoId,

            };



            contadorFormacoes++;

            formacoes['line' + contadorFormacoes] = formacao;

            let htmlElement = "<li id='line" + contadorFormacoes + "'>" + certificadoValue + " em " + areaFormacaoValue + "<i class='fa fa-bell dismiss-line' _id='line" + contadorFormacoes + "' style='float:right;' role='button'></i></li>";

            $("#lista-formacoes").append(htmlElement);

            $("#content-form-adicionar-formacao").hide();





            if (contadorFormacoes < 2)
                $("#btn-show-form-formacao").show();
            else
                $("#btn-show-form-formacao").hide();



        });

        $("#lista-formacoes").on('click', '.dismiss-line', function() {
            let valor = $(this).attr('_id');
            $("#" + valor).remove();
            delete formacoes[valor];
            contadorFormacoes--;
            if (contadorFormacoes < 2)
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

            if (funcaoIsEmpty || instituicaoIsEmpty || dataIsEmpty)
                return false;


            let funcaoValue = $("#experiencia-funcao-input").val();
            let idFuncao = $("#experiencia-funcao-input-hide").val();
            let instituicaoValue = $("#experiencia-instituicao-input").val();
            let idInstituicao = $("#experiencia-instituicao-input-hide").val();



            let experiencia = {
                funcao: funcaoValue,
                idFuncao: idFuncao,
                instituicao: instituicaoValue,
                idInstituicao: idInstituicao
            };



            contadorExperiencias++;

            experiencias['line_experiencia' + contadorExperiencias] = experiencia;

            let htmlElement = "<li id='line_experiencia" + contadorExperiencias + "'>" + funcaoValue + " no(a)  " + instituicaoValue + "<i class='fa fa-bell dismiss-line' _id='line_experiencia" + contadorExperiencias + "' style='float:right;' role='button'></i></li>";

            $("#lista-experiencias").append(htmlElement);

            $("#content-form-adicionar-experiencia").hide();

            if (contadorExperiencias < 2)
                $("#btn-show-form-experiencia").show();
            else
                $("#btn-show-form-experiencia").hide();

        });

        $("#lista-experiencias").on('click', '.dismiss-line', function() {
            let valor = $(this).attr('_id');
            $("#" + valor).remove();
            delete experiencias[valor];
            contadorExperiencias--;
            if (contadorExperiencias < 2)
                $("#btn-show-form-experiencia").show();
        });

        $("#btn-show-form-formacao").click(function() {
            $("#formacao-certificado-input").val('');
            $("#formacao-area-formacao-input").val('');
            areaFormacaoItemClicked = false;
            certificadoItemClicked = false;

            $("#content-form-adicionar-formacao").show();
            $("#content-form-adicionar-experiencia").hide();

            if (contadorExperiencias < 2)
                $("#btn-show-form-experiencia").show();


            $(this).hide();
        });

        $("#btn-show-form-experiencia").click(function() {
            $("#experiencia-funcao-input").val('');
            $("#experiencia-instituicao-input").val('');
            $("#content-form-adicionar-experiencia").show();
            $("#content-form-adicionar-formacao").hide();
            if (contadorFormacoes < 2)
                $("#btn-show-form-formacao").show();

            $(this).hide();
        });

        $("#btn-cancelar-add-formacao").click(function() {
            $("#content-form-adicionar-formacao").hide();
            if (contadorFormacoes < 2)
                $("#btn-show-form-formacao").show();
        });

        $("#btn-cancelar-add-experiencia").click(function() {
            $("#content-form-adicionar-experiencia").hide();
            if (contadorExperiencias < 2)
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


        });

        $(".btn-remove-img-membro-equipa").click(function() {

            let userCode = codigoStartup;
            let srcDaImg = $("#img-membro-equipa-add").attr('src');
            let novaSrc = srcDaImg.substring(0, srcDaImg.indexOf("armazenamento")) + 'armazenamento/startups/img/membros/img_standard_membro_equipa.png';
            $("#img-membro-equipa-add").attr('src', novaSrc);
            $("#load_img-membro-equipa-add").val('');
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
            form.append('haveImg', true);
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

                    formacaoString = formacoes['line' + iterador]['certificado'] + '|' + formacoes['line' + iterador]['areaformacao'];
                    formacoesVetor.push(formacaoString);
                }
            }


            for (let iterador = 0; iterador <= contadorExperiencias; iterador++) {
                if (experiencias['line_experiencia' + iterador] != undefined) {
                    experienciaString = experiencias['line_experiencia' + iterador]['funcao'] + '|' + experiencias['line_experiencia' + iterador]['idFuncao'] + '|' + experiencias['line_experiencia' + iterador]['instituicao'] + '|' + experiencias['line_experiencia' + iterador]['idInstituicao'];
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
                    loadMembrosEquipa();
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


        //----------------------CHAT--------------------------




        $("#content-oferta").on('click', '.btn-item-conversa', function() {



            destinatarioMessageChat = $(this).attr("investidor");
            getInfoDestinatario();
            getMessages();


        });



        $("#content-oferta").on('click', '#btn-enviar-message-chat', function() {

            let remetente = "{{$code}}";
            let distinatario = destinatarioMessageChat;
            let conteudoMessage = $("#conteudo-message-chat").val().trim();

            if (conteudoMessage.length == 0)
                return false;



            $.ajax({
                url: '/send_message',
                type: 'get',
                data: {
                    'remetente': remetente,
                    'distinatario': distinatario,
                    'conteudoMessage': conteudoMessage
                },
                success: function(response) {
                    $("#conteudo-message-chat").val('');
                    getMessages();
                },
                error: function(error) {
                    console.log("Erro a enviar mensagem");
                    console.log(error);
                }
            });

        });

        $("#container-membros-equipa").on('click', '.btn-editar', function() {
            deleteMembroEquipa();
        });


        //--------------------------POPUP CHAT

        $("#content-intro-startup").on('click', '#btn-meeting', function() {

            var codeStartup = "{{$codigoStartup}}";
            var idUser = "{{$idUser}}";

            if (popupChatOpen == true) {
                $("#popup-chat-container").empty();
                popupChatOpen = false;
                return false;
            }

            $.ajax({
                url: '/load_popup_chat',
                type: 'get',
                data: {
                    'codeUser': codeStartup
                },
                success: function(response) {
                    $("#popup-chat-container").append(response['html']);
                    popupChatOpen = true;
                    loadScrollBarToBottom();
                    setStatusMessage(idUser);

                },
                error: function(error) {
                    console.log("Erro ao carregar popup-chat");
                }
            });


        });

        $("#popup-chat-container").on('click', '#btn-enviar-popup-chat', function() {
            var mensagem = $("#textarea").val().trim();
            if (mensagem.length == 0)
                return true;

            var codeStartup = "{{$codigoStartup}}";



            $.ajax({
                url: '/send_message',
                type: 'post',
                data: {
                    'codeUser': codeStartup,
                    'mensagem': mensagem
                },
                success: function(response) {

                    $("#textarea").val('');

                    getNewMessage(response['messageId']);

                    loadScrollBarToBottom();

                },
                error: function(error) {
                    console.log("Erro ao enviar mensagem");
                    console.log(error);
                }
            });
        });

        $("#popup-chat-container").on('click', "#btn-close-chatmeeting", function() {
            $("#popup-chat-container").empty();
            popupChatOpen = false;
        });

        //-------------------------------------------------------
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

        ///---------------------------------------------------OUVINTES---------




        Echo.private('permitir-ver-pitch-channel.' + '{{$code}}')
            .listen('PermitirVerPitch', function(e) {
                loadOferta();
            });

        Echo.private('send-message-channel.' + '{{$code}}')
            .listen('SendMessage', function(e) {
                getNewMessage(e.messageId);
            });

        Echo.private('atualizar-estado-oferta')
            .listen('AtualizarEstadoRodada', function(e) {
                loadOferta();
                $("#modal-investir .close").click();

            });

        //------------------------EXPLICIT FUNCTIONS-----------------------------


        function resetarFormularioAdicionarMembro() {

            let dataAtual = consultarDataAtual();
            let valorAtualAtributoSrcDaImagemMembro = $("#img-membro-equipa-add").attr('src');
            let novoValorAtributoSrcDaImagemMembro = valorAtualAtributoSrcDaImagemMembro.substring(0, valorAtualAtributoSrcDaImagemMembro.indexOf("armazenamento")) + 'armazenamento/startups/img/membros/img_standard_membro_equipa.png';


            $("#img-membro-equipa-add").attr('src', novoValorAtributoSrcDaImagemMembro);

            $("#load_img-membro-equipa-add").val('');
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



        function getMessages() {

            let remetente = "{{$code}}";
            let distinatario = destinatarioMessageChat;

            $.ajax({
                url: '/get_messages',
                type: 'get',
                data: {
                    'remetente': remetente,
                    'distinatario': distinatario

                },
                success: function(response) {
                    heightComponenteMessage = heightComponenteMessage + 100;
                    let alturaScroll = heightComponenteMessage + 198;
                    $("#bady-chat").empty();
                    $("#bady-chat").append(response['html']);

                    $("#bady-chat").scrollTop(alturaScroll);


                },
                error: function(error) {
                    console.log("Erro ao carregar conversas");
                    console.log(error);
                }

            });

            verificarPermissaoParaEnviarMensagem();
        }

        function getInfoDestinatario() {
            let distinatario = destinatarioMessageChat;

            $.ajax({
                url: '/get_info_destinatario',
                type: 'get',
                data: {
                    'distinatario': distinatario
                },
                success: function(response) {
                    $("#container-info-destinatario").empty();
                    $("#container-info-destinatario").prepend(response['html']);
                },
                error: function(error) {
                    console.log("Erro a enviar mensagem");
                    console.log(error);
                }
            });

        }

        function verificarPermissaoParaEnviarMensagem() {

            let remetente = "{{$code}}";
            let destinatario = destinatarioMessageChat;

            $.ajax({
                url: '/verificar_permissao_para_enviar_mensagem',
                type: 'get',
                data: {
                    'remetente': remetente,
                    'destinatario': destinatario
                },
                success: function(response) {

                    $("#conteudo-message-chat").prop('disabled', !response['permissao']);
                    $("#btn-enviar-message-chat").prop('disabled', !response['permissao']);
                },
                error: function(error) {
                    console.log("Erro ao verificar permissao para enviar mensagem");
                    console.log(error);
                }
            });
        }

        function loadMembrosEquipa() {
            var codeStartup = "{{$codigoStartup}}";

            $.ajax({
                url: "/load_membros_equipa",
                type: "get",
                data: {
                    "codeStartup": codeStartup
                },
                success: function(response) {

                    $("#container-membros-equipa").empty();
                    $("#container-membros-equipa").append(response['html']);
                },
                error: function(error) {
                    console.log("Erro ao carregar membros");
                    console.log(error);
                }
            });
        }

        function deleteMembroEquipa() {
            var idMembro = 3;

            $.ajax({
                url: "/delete_membros_equipa",
                type: "get",
                data: {
                    "idMembro": idMembro
                },
                success: function(response) {
                    loadMembrosEquipa();
                },
                error: function(error) {
                    console.log("Erro ao deletar membros");
                    console.log(error);
                }
            });
        }

        function getNewMessage(idMessage) {
            $.ajax({
                async: false,
                url: "/get_new_message",
                type: "get",
                data: {
                    "idMessage": idMessage
                },
                success: function(response) {


                    $("#chat").append(response['html']);
                },
                error: function(error) {
                    console.log("Erro ao carregar nova mensagem startup");
                    console.log(error);
                }
            });
        }

        function loadScrollBarToBottom() {
            $("#chat").scrollTop($("#chat").prop('scrollHeight'));

        }

        function setStatusMessage(idOtherUser) {
            $.ajax({
                url: "/set_status_message",
                type: "get",
                data: {
                    "idOtherUser": idOtherUser
                },
                success: function(response) {

                },
                error: function(error) {
                    console.log("Erro ao carregar ao alterar status das mensagens");
                    console.log(error);
                }
            });
        }

        function convertStringInArray(caracterSequence) {
            let sequenceArray = new Array();
            for (let i = 0; i < caracterSequence.length; i++) {
                sequenceArray.push(caracterSequence[i]);
            }

            return sequenceArray;
        }

        function convertArrayInString(sequenceArray) {
            let caracterSequence = sequenceArray.toString();
            return caracterSequence.replace(/\,/g, "");
        }


        function apagarVirgulaEPonto(valor) {
            while (valor.indexOf('.') != -1) {
                valor = valor.replace('.', '');
            }
            valor = valor.replace(',', '');

            return valor;
        }

        function show_valor_a_acrescer(valor) {
            valor = set_format(valor);
            while (valor.indexOf('.') != -1) {
                valor = valor.replace('.', '');
            }
            valor = valor.replace(',', '.');

            let valor_acrescer = (valor * 25 / 100).toFixed(2) + ''; // o paypal desconsta 25 em cada valor transacionado
            valor_acrescer = set_format(valor_acrescer);
            $("#montante-acrescer").val(valor_acrescer);
        }

        function set_format(valor) {
            let valor_formatado = [];
            let contador = 0;
            let valor2;
            valor = apagarVirgulaEPonto(valor);

            if (valor.length > 17)
                valor = valor.slice(0, 17);

            ////O erro de 9999999999999999999999999999 para 100000000000000000000000000
            if (isNaN(valor)) {
                return false;
            } else
                valor = (valor - 0) + '';
            ///-------------------------


            for (let i = valor.length - 1; i >= 0; i--) {
                valor_formatado.push(valor[i]);

                if ((valor.length - 1) - i == 1) {
                    valor_formatado.push(',');
                    contador = 0;
                }

                if (contador % 3 == 0 && contador != 0 && i > 0) {
                    valor_formatado.push('.');
                }

                contador++;
            }

            for (let i = valor.length; i < 3; i++) {

                valor_formatado.push(0);

                if (i == 1 && valor_formatado.indexOf(',') == -1) {
                    valor_formatado.push(',');
                }
            }
            valor2 = valor_formatado.reverse().join('');

            return (valor2);
        }

        function check_empty_field(myForm) {
            let find_error = 0;

            $(".is-invalid").removeClass("is-invalid");
            $(".alert-adicionar-oferta").html('');
            if (!myForm.get('meta')) {
                $("#alert-meta").html("Meta não informada");
                $("#meta-oferta").addClass("is-invalid");
                find_error = 1;
            }

            if (!myForm.get('termino')) {
                $("#alert-data-angariacao").html("Data não informada");
                $("#termino-oferta").addClass("is-invalid");
                find_error = 1;
            } else if (new Date(new Date(myForm.get('termino')).toDateString()) - new Date(new Date().toDateString()) < 604800000) {
                $("#alert-data-angariacao").html("O tempo para angariação deve ser de (1) uma semana no mínimo");
                $("#termino-oferta").addClass("is-invalid");
                find_error = 1;
            } else if (new Date(new Date(myForm.get('termino')).toDateString()) - new Date(new Date().toDateString()) > 16070400000) //milisegundos = 6meses com 31 dias cada
            {
                $("#alert-data-angariacao").html("O tempo para angariação deve ser de (6) seis meses no máximo");
                $("#termino-oferta").addClass("is-invalid");
                find_error = 1;
            }
            if (!myForm.get('max_investidores')) {
                $("#alert-n-investidor").html("Número máximo de investidores não informado");
                $("#max-investidores").addClass("is-invalid");
                find_error = 1;
            } else if (myForm.get('max_investidores') < 1) {
                $("#alert-n-investidor").html("Número de investidores deve ser igual ou maior que 1(um)");
                $("#max-investidores").addClass("is-invalid");
                find_error = 1;
            }

            if (myForm.get('pitch_video').size == 0) {
                $("#alert-pitch").html("Pitch não carregado");
                $("#input-pitch-video").addClass("is-invalid");
                find_error = 1;
            } else if ((myForm.get('pitch_video').size / 1000000) >= 65) {
                $("#alert-pitch").html("Tamanho máximo do arquivo pitch deck deve ser de 64MB");
                $("#input-pitch-video").addClass("is-invalid");
                find_error = 1;
            }

            if (!myForm.get('porcentagem')) {
                $("#alert-porcentagem").html("Porcentagem não informada");
                $("#porcentagem-oferta").addClass("is-invalid");
                find_error = 1;
            }

            if (find_error)
                return false;
            return true;
        }

        function loadAvaluationContent()
        {
            var codeStartup = "{{$codigoStartup}}";
            
            $.ajax({
                url:'/get_avaluation',
                type:'get',
                data:
                {
                    "codeStartup": codeStartup
                },
                success:function(response)
                {
                    $("#content-avalutation").empty();
                    $("#content-avalutation").append(response['html']);
                },
                error:function(error){
                    console.log("Erro ao obter avaliação");
                    console.log(error);
                }
            });
        }
    });
</script>
@endsection