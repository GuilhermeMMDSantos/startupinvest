$(function () {

    $("#entity-startup").click(function () {
        showFormStartup();
    });

    $("#entity-investor").click(function () {
        showFormInvestidor();
    });

    $(".input-type-entity").click(function () {
        hideAllAlert();
        resetForms();
    });

    $("input[name='tipo_investidor']").click(function () {
        hideAllAlert();

    });

    $("button[class='btn dropdown-toggle btn-light']").click(function () {
        $(".my-btn-container").remove();
    });
    $(".bs-searchbox input[type='search']").keyup(function () {
        var valor = $(this).val();
        var elemento = "<div class='pl-2 pt-2 my-btn-container'><button type='button' class='btn btn-outline-primary' id='btn-add-novo-sector'>Adicionar sector</button><div>"
        $(".my-btn-container").remove();
        if (valor.length > 0)
            $("div[class='dropdown-menu show']").append(elemento);


    });

    $("div[class='dropdown bootstrap-select form-control']").on('click', '#btn-add-novo-sector', function () {
        var valor = $(".bs-searchbox input[type='search']").val();
        $(".filter-option-inner-inner").html(valor);
        $("#sectores").append("<option value='"+valor+" addxx' selected hidden></option>");
    });

    $("#mvp").change(function () {
        if (($(this)[0].files[0].size / 1000000) < 65) {
            $("#mvp-label-tamanho").css({
                'color': 'black'
            });
        } else {
            $("#mvp-label-tamanho").css({
                'color': 'red'
            });
        }
    });

    $("#video-investor").change(function () {
        if (($(this)[0].files[0].size / 1000000) < 65) {
            $("#video-investor-label-tamanho").css({
                'color': 'black'
            });
        } else {
            $("#video-investor-label-tamanho").css({
                'color': 'red'
            });
        }
    });

    $("#btn-cadastrar-investidor").click(function () {
        $("#form-investidor").submit();
        $(this).prop("disabled", true);
        $("#btn-spinner-investidor").removeClass('d-none');
        true;
    });

    $("#btn-cadastrar-startup").click(function () {
        $("#form-startup").submit();
        $(this).prop("disabled", true);
        $("#btn-spinner-startup").removeClass('d-none');
        true;
    });

    $('.toast').toast('show');

    function shoeEntityAtivo(node) {
        $(".input-type-entity-ativo").removeClass("input-type-entity-ativo");
        node.addClass("input-type-entity-ativo");
    }

    function showFormStartup() {
        $("#card-form-startup").show(300);
        $("#card-form-investidor").hide(300);
        shoeEntityAtivo($("#entity-startup"));
    }

    function showFormInvestidor() {
        $("#card-form-startup").hide(300);
        $("#card-form-investidor").show(300);
        shoeEntityAtivo($("#entity-investor"));
    }

    function hideAllAlert() {
        $("#container-alert-form-startup").hide();
        $("#container-alert-form-investidor").hide();
    }

    function resetForms() {
        $("#form-startup").get(0).reset();
        $("#form-investidor").get(0).reset();
    }
});
