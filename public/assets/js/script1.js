$(function () {
    /*
    about function identifyInvestorType:
    o terceiro parâmetro serve para identificar uma troca de tipo investidor e carregamento da pagina 

    1-troca de tipo investidor
    2-carregamento da pagina 

     */
    var old_value_sobrenome_js = $("#input_hidden").attr('old_value_sobrenome');
    var old_value_nif_js = $("#input_hidden").attr('old_value_nif');

    identifyInvestorType(old_value_sobrenome_js, old_value_nif_js, 2);


    identifyUserType();


    $('.contentCol2-escolheUser select').change(function () {
        $("#div_message_error").hide(400);
        identifyUserType();
    });

    $("#my-input-file-emp").change(function () {

        $("#my-input-file-disabled-emp").attr("placeholder", $(this)[0].files[0].name);

    });

    $("#my-input-file-inv").change(function () {

        $("#my-input-file-disabled-inv").attr("placeholder", $(this)[0].files[0].name);
    });

    $("#my-input-file-inv-bi").change(function () {

        $("#my-input-file-disabled-inv-bi").attr("placeholder", $(this)[0].files[0].name);
    });


    $("input[name='tipo_investidor']").click(function () {

        identifyInvestorType('', '', 1);
    });

    $(".btn-click-efect").on("mousedown", function () {
        $(this).css({
            "background": "#e8bd63cf"
        })
    });

    $(".btn-click-efect").on("mouseup", function () {
        $(this).css({
            "background": "#e8bd63"
        })
    });


    

    $("#nome-incubadora-aceleradora").keyup(function() {

        let valorNome = $(this).val().trim();
        $("#id_incubadora_aceleradora").val(0);

        if (valorNome == 0) {
            $("#lista-resultado-busca-incubadora-aceleradora").hide(400);
            return false;
        }
        $.ajax({
            url: '/buscar_incubadora_aceleradora',
            type: 'get',
            data: {
                '_token': '{{csrf_token()}}',
                'valorNome': valorNome
            },
            success: function(response) {
                $("#lista-resultado-busca-incubadora-aceleradora").empty();
                $("#lista-resultado-busca-incubadora-aceleradora").append(response);
                $("#lista-resultado-busca-incubadora-aceleradora").show(400);
            },
            error: function(error) {
                console.log("ERRO AO BUSCAR INCUBADORAS-ACELERADORAS");
                console.log(error);
            }
        });
    });


   $(document).click(function(){
    $("#lista-resultado-busca-incubadora-aceleradora").hide(400);
   });


   $("#lista-resultado-busca-incubadora-aceleradora").on('click','a',function(){
       $("#nome-incubadora-aceleradora").val($(this).html());
       $("#id_incubadora_aceleradora").val($(this).attr('valor'));
       
   });


    function identifyUserType() {
        let user = $('.contentCol2-escolheUser select').val();

        if (user == "Empreendedor") {


            $("#nome1_inv").val('');
            $("#nome2_inv").val('');
            $("#nif_inv").val('');
            $("#email_inv").val('');

            $('.formShow').removeClass("formShow");
            $('.formEmpreendedor').addClass("formShow");

        } else if (user == "Investidor") {


            $("#nome_emp").val('');
            $("#email_emp").val('');
            $("#my-input-file-emp").val('');
            $("input[name='pitch_line1']").val('');
            $("input[name='pitch_line2']").val('');
            $("input[name='pitch_line3']").val('');
            $("input[name='pitch_line4']").val('');


            $('.formShow').removeClass("formShow");
            $('.formInvestidor').addClass("formShow");
        }
    }


    function identifyInvestorType(old_value_sobrenome_js, old_value_nif_js, action) {

        var content = "";


        if (action == 1)
            $("#div_message_error").hide(400);

        $("#nome1_inv").val('');
        $("#nome2_inv").val('');
        $("#nif_inv").val('');
        $("#email_inv").val('');

        $("#divs_concorrentes").empty();

        if ($("#singular").prop('checked')) {

            content = "<div class='sobrenome_investidor_singular'>\
      <label for='nome2_inv' class='label_inv'>Sobrenome</label>\
      <input type='text' name='segundo_nome' value='" + old_value_sobrenome_js + "' placeholder='Tunga' class='form-control yesForStyle' id='nome2_inv'  >\
      </div>\
      \
      <div>\
      <label for='#' class='label_inv'>Bilhete De Identidade (PDF)</label>\
      <div class='content-my-input-file-inv-bi'>\
       <label for='my-input-file-inv-bi' class='btn-select-file-inv-bi'>Selecionar</label>\
         <div>\
            <input class='form-control' type='text' placeholder='Nenhum arquivo selecionado' id='my-input-file-disabled-inv-bi' disabled>\
            <input type='file' id='my-input-file-inv-bi' accept='.pdf' name='bilhete_identidade_investidor'>\
         </div>\
        </div>\
      </div>\
      ";

        } else if ($("#juridico").prop('checked')) {

            content = "<div class='nif_pessoa_juridica'>\
          <label class='label_inv'>NIF da pessoa jurídica</label>\
          <input type='text' name='nif' value='" + old_value_nif_js + "' class='form-control yesForStyle' id='nif_inv' placeholder='95003ASD22234567999'  >\
          </div>";

        }

        $("#divs_concorrentes").append(content);

    }

});
