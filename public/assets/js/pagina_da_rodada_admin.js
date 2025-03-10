$(function () {


    var loader = "<div class='d-flex flex-column justify-content-center align-items-center' style='min-height:240px;'>\
    <div class='spinner-border' role='status' style='width:50px;height:50px;'>\
    </div>\
</div>";

loadBtnTransferOurComprovativo();

    $("#send-money-to-startup").on("shown.bs.modal", function (event) {
        var btn = $(event.relatedTarget);

        var valorCaptado = new Intl.NumberFormat('pt-BR', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(btn.data("valorcaptado"));

        var valorATransferir = new Intl.NumberFormat('pt-BR', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(btn.data("valoratransferir"));

        var custo = new Intl.NumberFormat('pt-BR', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format((btn.data("valorcaptado") - btn.data("valoratransferir")));

        var idRodada = btn.data("rodada");

        $("#valor-captado-form-send-money-to-startup").html(valorCaptado + " AOA");
        $("#valor-custo-form-send-money-to-startup").html(custo + " AOA");
        $("#valor-a-tranferir-form-send-money-to-startup").html(valorATransferir + " AOA");
        $("#indentify").val(idRodada);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#form-send-money-to-startup").submit(function (event) {
        event.preventDefault();
        var myForm = new FormData($(this)[0]);
        var inputFile = $("input[name = 'comprovativo_transferencia']")[0].files[0];

        if (!inputFile) {
            $("#send-money-to-startup").attr('inert', '');
            swal.fire({
                title: "Validação",
                icon: "warning",
                text: "Informa o Comprovativo da Transferência.",
                confirmButtonText: "Ok"
            }).then((clicked) => {
                if (clicked.isConfirmed)
                    $("#send-money-to-startup").removeAttr('inert');

            });;
            return false;
        }
        $.ajax({
            url: '/send_money_to_startup',
            type: 'POST',
            contentType: false,
            processData: false,
            data: myForm,
            success: function (response) {
                $("#container-btn-send-amount").hide();
                $("#rodada-status").html("sucedida");
                $("#send-money-to-startup").attr('inert', '');
                $("#send-money-to-startup").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Tranferência Confirmada",
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#send-money-to-startup").removeAttr('inert');
                loadBtnTransferOurComprovativo();
            },
            error: function (error) {
                console.log("Erro ao Submeter Comprovativo de Transferência");
                console.log(error);
            }
        });

        return false;
    });

    function loadBtnTransferOurComprovativo() {

        var rodadaId = $("#element-pass1").data('value');

        $.ajax({
            url: '/load_btnTransfer_comprovativo',
            type: 'GET',
            data: {
                'rodadaId': rodadaId
            },
            success: function (response) {
                if (response['case'] == 0) {
                    $("#container-transfer-our-comprovativo").empty();
                    $("#container-transfer-our-comprovativo").append(response['html']);
                }
            },
            error: function (error) {
                console.log("Erro na Requisição loadBtnTransferOurComprovativo");
                console.log(error);
             }
        });
    }

});