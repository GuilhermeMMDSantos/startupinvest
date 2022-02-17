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

        if (parseFloat($(this)[0].files[0].size / 1048576) > 30) {
            $(this).val('');
            $("#my-input-file-disabled-inv").attr("placeholder", "Nenhuma imagem selecionado");
            $(".label_max_size").css({
                'color': 'red',
                'transition': '0.5s'
            });
        } else {
            $("#my-input-file-disabled-inv").attr("placeholder", $(this)[0].files[0].name);
            $(".label_max_size").css({
                'color': 'grey',
                'transition': '0.5s'
            });
        }

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
      <input type='text' name='segundo_nome' value='" + old_value_sobrenome_js + "' placeholder='Tunga' class='form-control yesForStyle' id='nome2_inv' required>\
      </div>";

        } else if ($("#juridico").prop('checked')) {

            content = "<div class='nif_pessoa_juridica'>\
          <label class='label_inv'>NIF da pessoa jurídica</label>\
          <input type='text' name='nif' value='" + old_value_nif_js + "' class='form-control yesForStyle' id='nif_inv' placeholder='95003ASD22234567999' required>\
          </div>";

        }

        $("#divs_concorrentes").append(content);

    }

})
