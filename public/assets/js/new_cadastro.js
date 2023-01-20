$(function () {

    $("#entity-startup").change(function () {
        $("#form_startup").show(300);
        $("#formInvestidor").hide(300);
        resetarFormularios();
       
    });

    $("#entity-investor").change(function () {
        $("#form_startup").hide(300);
        $("#formInvestidor").show(300);
        resetarFormularios();
    });
    
    $(".input-type-entity").click(function(){
        $("#container-alert-form-startup").hide();
        $("#container-alert-form-investidor").hide();
    });
    

    $("#tipo-investidor-juridico").change(function(){
        $("#container-input-nif-investor").show(300);
        $("#container-input-nif-investor input").prop('required',true);
        
    });

    $("#tipo-investidor-fisico").change(function(){
        $("#container-input-nif-investor").hide(300);
        $("#container-input-nif-investor input").prop('required',false);
       
    });


    function resetarFormularios(){
        $("#form_startup").get(0).reset();
        $("#formInvestidor").get(0).reset();
    }

});
