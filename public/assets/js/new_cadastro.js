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

   $("#btn-cadastrar-investidor").click(function(){
    $("#form-investidor").submit();
    $(this).prop("disabled",true);
    $("#btn-spinner-investidor").css({
        'opacity':1 
    });
    true;
   });

   $("#btn-cadastrar-startup").click(function(){
    $("#form-startup").submit();
    $(this).prop("disabled",true);
    $("#btn-spinner-startup").css({
        'opacity':1 
    });
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
