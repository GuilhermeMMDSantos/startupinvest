@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_investidor.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:10px;">

  <div id="container-introducao-investidor" style="display:flex;padding-bottom:15px;border-bottom:2px solid #e9ecef;background: #f8f9fa;padding-left:5px;padding-top:5px;">



  </div>

  <div class="row">
    <div class="col-12" style="padding-top:10px;">
      <div class="card">
        <div class="card-header">
          <h3>Experiência
            @if($myProfile) <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-adicionar-experiencia-investidor">Adicionar</button>
            @endif
          </h3>
        </div>
        <div class="card-body" id="container-experiencias-investidor">

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12" style="padding-top:10px;">
      <div class="card">
        <div class="card-header">
          <h3>Formação
            @if($myProfile) <button type="button" class="btn btn-primary btn-editar" data-toggle="modal" data-target="#modal-adicionar-formacao-investidor">Adicionar</button>
            @endif
          </h3>
        </div>
        <div class="card-body" id="container-formacoes-investidor">

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12" style="padding-top:10px;">
      <div class="card">
        <div class="card-header">
          <h3>Startups Investidas</h3>
        </div>
        <div class="card-body" id="container-startups-investidas">

        </div>
      </div>
    </div>
  </div>


</section>

@include('modais/adicionar_experiencia_investidor')
@include('modais/adicionar_formacao_investidor')
@endsection



@section('scripts_base_inicio')

<script type="text/javascript">
  $experienciaIsClicked = false;

  $(function() {

    getIntroducaoInvestidor();
    getExperienciaInvestidor();
    getFormacaoInvestidor();
    //----------------------------FORMULARIO DE CADASTRO EXPERIENCIA INVESTIDOR


    //----FUNCAO
    $("#experiencia-funcao-input").keyup(function() {


      var wordsSearch = $(this).val().trim();
      $experienciaIsClicked = false;

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
      $experienciaIsClicked = true;
    });
    //---------------

    //----INSTITUICAO

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
    //----------------

    $("#form-cadastrar-experiencia").submit(function() {

      let funcaoIsEmpty = false;
      let instituicaoIsEmpty = false;
      let dataIsEmpty = false;

      let funcaoValue = $("#experiencia-funcao-input").val();
      let idFuncao = $("#experiencia-funcao-input-hide").val();
      let instituicaoValue = $("#experiencia-instituicao-input").val();
      let idInstituicao = $("#experiencia-instituicao-input-hide").val();
      let dataInicioValue = $("#experiencia-mes-ano-inicio").val();
      let dataFimValue = $("#experiencia-mes-ano-fim").val();

      if (funcaoValue.trim().length == 0) {
        $("#content-alert-emptyfield-funcao-experiencia").html('Não informou o função');
        funcaoIsEmpty = true;
      }

      if (instituicaoValue.trim().length == 0) {
        $("#content-alert-emptyfield-instituicao-experiencia").html('Não informou a instituição');
        instituicaoIsEmpty = true;
      }

      if (dataInicioValue.trim().length == 0) {
        $("#content-alert-emptyfield-datainico-experiencia").html('Não informou a data');
        dataIsEmpty = true;
      }

      if (funcaoIsEmpty || instituicaoIsEmpty || dataIsEmpty)
        return false;


      $.ajax({
        url: '/cadastrar_experiencia_investidor',
        type: 'post',
        data: $(this).serialize(),
        success: function(response) {
          $(this).get(0).reset();
          $("#modal-adicionar-experiencia-investidor").modal('hide');
          getExperienciaInvestidor();
        },
        error: function(error) {
          console.log("ERRO AO CADASTRAR EXPERIENCIA DO INVESTIDOR");
          console.log(error);
        }
      });


      return false;

    });

    $("#modal-adicionar-experiencia-investidor").on('show.bs.modal', function(event) {
      $("#form-cadastrar-experiencia").get(0).reset();
      $("#content-alert-emptyfield-funcao-experiencia").html('');
      $("#content-alert-emptyfield-instituicao-experiencia").html('');
      $("#content-alert-emptyfield-datainico-experiencia").html('');
    });

    //--------------------------------------------------------------------

    //------------------------------------FORMULARIO DE CADASTRO FORMACAO INVESTIDOR

    //---CERTIFICADO

    $("#formacao-certificado-input").keyup(function() {

      let valorCertificadoInput = $(this).val().trim();


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

    });

    //-------------


    //--AREAS DE FORMACAO

    $("#formacao-area-formacao-input").keyup(function() {

      let valorAreaFormacaoInput = $(this).val().trim();


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

    });


    $("#form-cadastrar-formacao").submit(function() {

      let certificadoValue = $("#formacao-certificado-input").val();
      let certificadoId = $("#formacao-certificado-input-hide").val();
      let areaFormacaoValue = $("#formacao-area-formacao-input").val();
      let areaFormacaoId = $("#formacao-area-formacao-input-hide").val();
      let dataInicioValue = $("#formacao-mes-ano-inicio").val();
      let dataFimValue = $("#formacao-mes-ano-fim").val();
      let haveEmptyField = false;

      if ($("#formacao-mes-ano-inicio").val().trim().length == 0) {
        $("#content-alert-unselected-data-formacao-inicio").html('Não selecionou uma data');
        haveEmptyField = true;
      }
      if ($("#formacao-mes-ano-fim").val().trim().length == 0) {
        $("#content-alert-unselected-data-formacao-fim").html('Não selecionou uma data');
        haveEmptyField = true;
      }

      if (areaFormacaoId.length == 0) {
        $("#content-alert-unselected-area-formacao").html('Não selecionou uma área de formação');
        haveEmptyField = true;
      }
      if (certificadoId.length == 0) {
        $("#content-alert-unselected-certificado").html('Não selecionou um certificado');
        haveEmptyField = true;
      }

      if (haveEmptyField) {
        return false;
      }



      $.ajax({
        url: '/cadastrar_formacao_investidor',
        type: 'post',
        data: $(this).serialize(),
        success: function(response) {
          $("#container-formacoes-investidor").empty();
          $("#container-formacoes-investidor").append(response['html']);
          $("#modal-adicionar-formacao-investidor").modal('hide');
          $("#form-cadastrar-formacao").get(0).reset();
          getFormacaoInvestidor();
        },
        error: function(error) {
          console.log("Erro ao cadastrar formacao");
          console.log(error);
        }
      });

      return false;

    });
    //----------------


    $("#modal-adicionar-formacao-investidor").on('show.bs.modal', function(event) {
      $("#form-cadastrar-formacao").get(0).reset();
      $("#content-alert-unselected-certificado").html('');
      $("#content-alert-unselected-area-formacao").html('');
      $("#content-alert-unselected-data-formacao-inicio").html('');
      $("#content-alert-unselected-data-formacao-fim").html('');
    });

    //-----------------------------------------------------------------------------

    //---------------------------ELIMINAR MENSAGEM DE CAMPO VAZIO

    $("#experiencia-funcao-input").focus(function() {
      $("#content-alert-emptyfield-funcao-experiencia").html('');
    });

    $("#experiencia-instituicao-input").focus(function() {
      $("#content-alert-emptyfield-instituicao-experiencia").html('');
    });

    $("#experiencia-mes-ano-inicio").focus(function() {
      $("#content-alert-emptyfield-datainico-experiencia").html('');
    });





    $("#formacao-certificado-input").focus(function() {
      $("#content-alert-unselected-certificado").html('');
    });

    $("#formacao-area-formacao-input").focus(function() {
      $("#content-alert-unselected-area-formacao").html('');
    });

    $("#formacao-mes-ano-inicio").focus(function() {
      $("#content-alert-unselected-data-formacao-inicio").html('');
    });

    $("#formacao-mes-ano-fim").focus(function() {
      $("#content-alert-unselected-data-formacao-fim").html('');
    });


    $("#container-introducao-investidor").on('click', '#btn-pode-assistir-pitch', function() {
      $.ajax({
        url: "/set_permissao_ver_pitch",
        type: "get",
        data: {
          codeUser: '{{$codigoInvestidor}}'
        },
        success: function(response) {

          console.log("Notificado");
          getIntroducaoInvestidor();
        },
        error: function(error) {
          console.log("Erro ao dar permissao ver pitch");
          console.log(error);
        }
      });
    });

    //----------------------------------------------------

    $(document).click(function(elemento) {
      $(".my-select-input").hide(100);
    });

    function getExperienciaInvestidor() {
      $.ajax({
        url: '/get_experiencia_investidor',
        type: 'get',
        data: {
          'codeUser': '{{$codeUser}}'
        },
        success: function(response) {
          $("#container-experiencias-investidor").empty();
          $("#container-experiencias-investidor").append(response['html']);
        },
        error: function(error) {
          console.log("Erro ao carregar experiencia investidor");
          console.log(error);
        }
      });
    }


    function getFormacaoInvestidor() {
      $.ajax({
        url: '/get_formacao_investidor',
        type: 'get',
        data: {
          'codeUser': '{{$codeUser}}'
        },
        success: function(response) {
          $("#container-formacoes-investidor").empty();
          $("#container-formacoes-investidor").append(response['html']);
        },
        error: function(error) {
          console.log("Erro ao carregar formacoes investidor");
          console.log(error);
        }
      });
    }

    function getIntroducaoInvestidor() {
      $.ajax({
        url: "/get_introducao_investidor",
        type: "get",
        data: {
          codeUser: '{{$codigoInvestidor}}'
        },
        success: function(response) {

          $("#container-introducao-investidor").empty();
          $("#container-introducao-investidor").append(response['html']);
        },
        error: function(error) {
          console.log("Erro ao carregar introdução investidor");
          console.log(error);
        }
      });
    }

    function getStartupsInvestidas() {
      $.ajax({
        url: "/get_startups_investidas",
        type: "get",
        success: function(response) {

          $("#container-startups-investidas").empty();
          $("#container-startups-investidas").append(response['html']);
        },
        error: function(error) {
          console.log("Erro ao carregar startups investidas");
          console.log(error);
        }
      });
    }

  });
</script>

@endsection