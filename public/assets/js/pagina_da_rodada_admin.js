$(function () {
    var loader = "<div class='d-flex flex-column justify-content-center align-items-center' style='min-height:240px;'>\
    <div class='spinner-border' role='status' style='width:50px;height:50px;'>\
    </div>\
</div>";

    $("#container-btn-send-amount").on('click', '#btn-send-amount-to-startup', function () {
        Swal.fire({
            title: "Transferir Investimento",
            text: "Confirma que deseja transferir investimento para startup!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            allowOutsideClick: false,
            confirmButtonText: "Sim, Tranferir."
        }).then((result) => {
            if (result.isConfirmed) {
                var idRodada = $(this).attr('value');

                $("#container-btn-send-amount").empty();
                $("#container-btn-send-amount").append(loader);
                $.ajax({
                    url: '/payouts',
                    type: 'get',
                    data: {
                        'idRodada': idRodada
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Transferido!",
                            text: "Investimento Realizado.",
                            allowOutsideClick: false,
                            icon: "success"
                        });
                        $("#container-btn-send-amount").empty();
                        $("#container-btn-send-amount").hide();
                        $("#title-page").html("Rodada <i\
                style='font-size:20px;margin-right:2px;color:#818182;'>•</i><span\
                style='font-size:15px;font-weight:bold;color:#818182;'> sucedida</span>");
                    },
                    error: function (response) {
                        Swal.fire({
                            title: "Atenção!",
                            text: "Erro ao processar transferência.",
                            allowOutsideClick: false,
                            icon: "error"
                        });
                        var rodadaId = $("#title-page").attr('val');
                        $("#container-btn-send-amount").empty();
                        $("#container-btn-send-amount").append("<div class='card-body d-flex justify-content-center'>\
                    <button type='button' class='btn btn-primary' id='btn-send-amount-to-startup' value="+rodadaId+">Transferir Montante</button>\
                </div>");
                        console.log(response);
                    }
                });
            }
        });
    });

});