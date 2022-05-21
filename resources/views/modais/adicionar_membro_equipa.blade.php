<div class="modal fade" id="modal-adicionar-membro-equipa" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Adionar Membro Equipa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-adionar-membro-equipa-body" style="font-size:14px;">
                <form enctype="multipart/form-data">

                    <div style="width:120px;height:120px;border:1px solid #ccc;border-radius:50%;margin:auto;">
                        <img src="{{asset('storage/armazenamento/startups/img/membros/img_standard_membro_equipa.png')}}" id="img-membro-equipa-add" accept=".jpg,.png" style="width:100%;height:100%;border-radius:50%;">
                    </div>

                    <div style="text-align:center;">
                        <input type="file" name="img-membro-equipa-add" id="load_img-membro-equipa-add" hidden>
                        <label for="load_img-membro-equipa-add" class="btn-add-img-membro-equipa" style="cursor:pointer;color:#007bff;">Adicionar foto</label>

                        <span class="content-btn-remove-img-membro-equipa" style="display:none;">| <a role="button" class="btn-remove-img-membro-equipa">Remover foto</a></span>



                    </div>


                    <div class="form-group group-nome-sobrenome">
                        <label>Nome</label>
                        <input type="text" name="nome" id="nome-membro-equipa" class="form-control" placeholder="ex.: Dário" autocomplete="off">
                        <span style="font-size:10px;color:red;" id="content-alert-unselected-nome-membro"></span>
                    </div>

                    <div class="form-group group-nome-sobrenome">
                        <label>Sobrenome</label>
                        <input type="text" name="sobrenome" id="sobrenome-membro-equipa" class="form-control" placeholder="ex.: Dário" autocomplete="off">
                        <span style="font-size:10px;color:red;" id="content-alert-unselected-sobrenome-membro"></span>
                    </div>

                    <div class="form-group">
                        <label>Cargo Executivo</label>
                        <select class="form-control" name="cargo" id="cargos-executivo">
                        </select>
                    </div>



                    <div class="form-group">
                        <label style="display: inline-block;background: #adb5bd54;width: 100%;padding: 5px;">Lista de Formações</label>
                        <ul id="lista-formacoes" style="list-style:none;padding-left:5px;padding-right:5px;">
                        </ul>
                        <div id="content-form-adicionar-formacao" style="border:1px solid #ccc;padding-top:8px; padding-left:7px; padding-right:7px;padding-bottom:10px; display:none;">

                            <div>
                                <label>Certificado</label>
                                <input type="text" id="formacao-certificado-input" class="form-control" autocomplete="off">
                                <span style="font-size:10px;color:red;" id="content-alert-unselected-certificado"></span>
                                <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-certificado">
                                </div>
                            </div>

                            <div>
                                <label>Área De Formação</label>
                                <input type="text" id="formacao-area-formacao-input" class="form-control" autocomplete="off">
                                <span style="font-size:10px;color:red;" id="content-alert-unselected-area-formacao"></span>
                                <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-area-formacao">
                                </div>
                            </div>

                            <div>
                                <label>Data inico</label>
                                <input type="Month" id="formacao-mes-ano-inicio" class="form-control">
                                <span style="font-size:10px;color:red;" id="content-alert-unselected-data-formacao-inicio"></span>
                            </div>

                            <div>
                                <label>Data Fim/Prevista</label>
                                <input type="Month" id="formacao-mes-ano-fim" class="form-control">
                                <span style="font-size:10px;color:red;" id="content-alert-unselected-data-formacao-fim"></span>
                            </div>

                            <div style="margin-top:5px;">
                                <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-salvar-formacao" style="height:30px;font-size:11px;border-radius:0px;">Adicionar formação</button>
                                <button type="button" class="btn btn-secondary btn-lg btn-block" id="btn-cancelar-add-formacao" style="height:30px;font-size:11px;border-radius:0px;">Cancelar</button>
                            </div>

                        </div>
                        <a role="button" style="color:blue;" id="btn-show-form-formacao">Adicionar formação</a>
                    </div>




                    <div class="form-group">
                        <label style="display: inline-block;background: #adb5bd54;width: 100%;padding: 5px;">Lista de Experiências</label>
                        <ul id="lista-experiencias" style="list-style:none;padding-left:5px;padding-right:5px;">
                        </ul>
                        <div id="content-form-adicionar-experiencia" style="border:1px solid #ccc; padding:8px 7px; padding-bottom:10px; display:none;">
                            <div>
                                <label>Função que exerce(u)</label>
                                <input type="text" id="experiencia-funcao-input" name="experiencia-funcao-input" class="form-control" placeholder="Informe o Outro">
                                <span style="font-size:10px;color:red;" id="content-alert-emptyfield-funcao-experiencia"></span>
                            </div>

                            <div>
                                <label>Instituição</label>
                                <input type="text" id="experiencia-instituicao-input" name="experiencia-instituicao-input" class="form-control" placeholder="Informe o Outro">
                                <span style="font-size:10px;color:red;" id="content-alert-emptyfield-instituicao-experiencia"></span>
                            </div>

                            <div>
                                <label>Data inico</label>
                                <input type="Month" id="experiencia-mes-ano-inicio" class="form-control">
                                <span style="font-size:10px;color:red;" id="content-alert-emptyfield-datainico-experiencia"></span>
                            </div>

                            <div style="margin-top:5px;">
                                <button type="button" id="btn-salvar-experiencia" class="btn btn-primary btn-lg btn-block" style="height:30px;font-size:11px;border-radius:0px;">Adicionar experiência</button>
                                <button type="button" class="btn btn-secondary btn-lg btn-block" id="btn-cancelar-add-experiencia" style="height:30px;font-size:11px;border-radius:0px;">Cancelar</button>
                            </div>

                        </div>
                        <a role="button" id="btn-show-form-experiencia" style="color:blue;">Adicionar experiência</a>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-adionar-membro-equipa">Salvar</button>
            </div>
        </div>
    </div>
</div>

@php
$userStartupCode = $startup->user->code_user;
@endphp

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var formacoes = [];
    var experiencias = [];
    var contadorFormacoes = 0;
    var contadorExperiencias = 0;
    var certificadoInputFocus = false;
    var certificadoItemClicked = false;
    var areaFormacaoInputFocus = false;
    var areaFormacaoItemClicked = false;
    var contaItensFormacaoAdded = 0;
    var contaItensExperienciaAdded = 0;

    $(function() {

        $("#modal-adicionar-membro-equipa").on('show.bs.modal', function() {

            let dataNow = new Date();
            let mes = dataNow.getMonth() < 10 ? '0' + (dataNow.getMonth() + 1) : (dataNow.getMonth() + 1);
            let dataNowFormated = dataNow.getFullYear() + '-' + mes;

            if ($("#img-membro-equipa-add").attr('src').indexOf("img_standard_membro") != -1) {

            }

            contadorFormacoes = 0;
            contadorExperiencias = 0;

            $("#formacao-mes-ano-inicio").attr('value', '1975-11');
            $("#formacao-mes-ano-inicio").attr('min', '1975-11');
            $("#formacao-mes-ano-inicio").attr('max', dataNowFormated);

            $("#formacao-mes-ano-fim").attr('value', dataNowFormated);
            $("#formacao-mes-ano-fim").attr('max', dataNowFormated);
            $("#formacao-mes-ano-fim").attr('min', '1975-11');

            $("#experiencia-mes-ano-inicio").attr('value', dataNowFormated);
            $("#experiencia-mes-ano-inicio").attr('min', '1975-11');
            $("#experiencia-mes-ano-inicio").attr('max', dataNowFormated);

            $.ajax({
                url: '/buscar_cargos_executvo',
                type: 'get',
                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(response) {
                    $("#cargos-executivo").append(response);
                },
                error: function(error) {
                    console.log("ERRO AO BUSCAR CARGOS EXECUTIVO");
                    console.log(error);
                }
            });

        });

        // TRATAMENTO DA BUSCA E SELECAO DO CERTIFICADO-FORMACAO

        $("#formacao-certificado-input").keyup(function() {

            let valorCertificadoInput = $(this).val().trim();
            certificadoInputFocus = true;
            certificadoItemClicked = false;

            $("#content-alert-unselected-certificado").html('');

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
            certificadoItemClicked = true;
        });

        //-------------------------------------------------------------------------

        // TRATAMENTO DA BUSCA DA AREA DE FORMACAO

        $("#formacao-area-formacao-input").keyup(function() {

            let valorAreaFormacaoInput = $(this).val().trim();
            areaFormacaoInputFocus = true;
            areaFormacaoItemClicked = false;

            $("#content-alert-unselected-area-formacao").html('');

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
            areaFormacaoItemClicked = true;
        });

        //--------------------------------------------------------------------------

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
            let areaFormacaoValue = $("#formacao-area-formacao-input").val();
            let dataInicioValue = $("#formacao-mes-ano-inicio").val();
            let dataFimValue = $("#formacao-mes-ano-fim").val();

            let formacao = {
                certificado: certificadoValue,
                areaformacao: areaFormacaoValue,
                datainicio: dataInicioValue,
                datafim: dataFimValue
            };



            contaItensFormacaoAdded++;

            formacoes['line' + contaItensFormacaoAdded] = formacao;

            let htmlElement = "<li id='line" + contaItensFormacaoAdded + "'>" + certificadoValue + " em " + areaFormacaoValue + " (" + dataInicioValue + "-" + dataFimValue + ")<i class='fa fa-bell dismiss-line' _id='line" + contaItensFormacaoAdded + "' style='float:right;' role='button'></i></li>";

            $("#lista-formacoes").append(htmlElement);

            $("#content-form-adicionar-formacao").hide();



            contadorFormacoes++;

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


        //------------------------------


        $("#nome-membro-equipa").keypress(function() {
            $("#content-alert-unselected-nome-membro").html();
        });

        $("#sobrenome-membro-equipa").keypress(function() {
            $("#content-alert-unselected-sobrenome-membro").html();
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
            let instituicaoValue = $("#experiencia-instituicao-input").val();
            let dataInicioValue = $("#experiencia-mes-ano-inicio").val();

            let experiencia = {
                funcao: funcaoValue,
                instituicao: instituicaoValue,
                datainicio: dataInicioValue
            };



            contaItensExperienciaAdded++;

            experiencias['line_experiencia' + contaItensExperienciaAdded] = experiencia;

            let htmlElement = "<li id='line_experiencia" + contaItensExperienciaAdded + "'>" + funcaoValue + " na  " + instituicaoValue + " desde " + dataInicioValue + "<i class='fa fa-bell dismiss-line' _id='line_experiencia" + contaItensExperienciaAdded + "' style='float:right;' role='button'></i></li>";

            $("#lista-experiencias").append(htmlElement);

            $("#content-form-adicionar-experiencia").hide();

            contadorExperiencias++;

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

        //---------------------------------------------------------------- show and hedden of subforms

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
            let userCode = '{{$userStartupCode}}';
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

            $(".content-btn-remove-img-membro-equipa").show();
        });


        $(".btn-remove-img-membro-equipa").click(function() {

            let userCode = '{{$userStartupCode}}';
            let srcDaImg = $("#img-membro-equipa-add").attr('src');
            let novaSrc = srcDaImg.substring(0, srcDaImg.indexOf("armazenamento")) + 'armazenamento/startups/img/membros/img_standard_membro_equipa.png';
            $("#img-membro-equipa-add").attr('src', novaSrc);

            $(".content-btn-remove-img-membro-equipa").hide();
        });

        $("#btn-adionar-membro-equipa").click(function() {
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
            let haveImg = ($("#load_img-membro-equipa-add").val().length == 0) ? false : true;
            let nomeMembroEquipa = $("#nome-membro-equipa").val();
            let sobrenome = $("#sobrenome-membro-equipa").val();
            let cargoExecutivo = $("#cargos-executivo").val();

            let form = new FormData();
            form.append('csrfmiddlewaretoken', csrf_code);
            form.append('imagem', img);
            form.append('haveImg', haveImg);
            form.append('nome', nomeMembroEquipa);
            form.append('sobrenome', sobrenome);
            form.append('cargo', cargoExecutivo);
            form.append('formacao', formacoes);
            form.append('experiencia', experiencias);
            let formacaoString = '';
            var formacoesVetor = [];

            for (let iterador = 0; iterador <= contaItensFormacaoAdded; iterador++) {
                if (formacoes['line' + iterador] != undefined) {
                    formacaoString = formacoes['line' + iterador]['certificado']+'-'+formacoes['line' + iterador]['areaformacao']+'-'+formacoes['line' + iterador]['datainicio']+'-'+formacoes['line' + iterador]['datafim'];
                    formacoesVetor.push(formacaoString);
                }
            }

            form.append('formacao',formacoesVetor);
            
            $.ajax({
                url: '/add_membro_equipa',
                type: 'POST',
                contentType: false,
                processData: false,
                data: form,
                success: function(response) {
                     console.log(response);
                },
                error: function(error) {
                    console.log("ERRO");
                    console.log(error);
                }
            });
        });

    });
</script>