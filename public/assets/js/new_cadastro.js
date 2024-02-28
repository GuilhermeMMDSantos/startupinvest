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

    $("#tipo-investidor-juridico").change(function () {
        $(".field-for-pessoa-juridica").show();
        $(".field-for-pessoa-juridica input").prop('required', true);
        $(".field-for-pessoa-fisica").hide();
        $(".field-for-pessoa-fisica input").prop('required', false);

        $("#nome-completo-id").hide();
        $("#nome-legal-id").show();
         
    });

    $("#tipo-investidor-fisico").change(function () {
        $(".field-for-pessoa-juridica").hide();
        $(".field-for-pessoa-juridica input").prop('required', false);
        $(".field-for-pessoa-fisica").show();
        $(".field-for-pessoa-fisica input").prop('required', true);
        
        $("#nome-completo-id").show();
        $("#nome-legal-id").hide();
    });
    
  

    function shoeEntityAtivo(node) {
        $(".input-type-entity-ativo").removeClass("input-type-entity-ativo");
        node.addClass("input-type-entity-ativo");
    }

    function showFormStartup(){
        $("#card-form-startup").show(300);
        $("#card-form-investidor").hide(300);
        shoeEntityAtivo($("#entity-startup"));
    }

    function showFormInvestidor(){
        $("#card-form-startup").hide(300);
        $("#card-form-investidor").show(300);
        shoeEntityAtivo($("#entity-investor"));
    }

    function hideAllAlert(){
        $("#container-alert-form-startup").hide();
        $("#container-alert-form-investidor").hide();
    }

    function resetForms(){
        $("#form-startup").get(0).reset();
        $("#form-investidor").get(0).reset();
    }
});
