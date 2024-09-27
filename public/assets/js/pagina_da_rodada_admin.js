$(function () {
    $("#btn-send-amount-to-startup").click(function () {
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

                $.ajax({
                    url: '/create_orders_payment_to_startup',
                    type: 'get',
                    data: {
                        'idRodada': idRodada
                    },
                    success: function (response) {
                        if (capturePayment(response['orderId'])) {
                            Swal.fire({
                                title: "Transferido!",
                                text: "Investimento Realizado.",
                                allowOutsideClick: false,
                                icon: "success"
                            });
                        }
                        else {
                            Swal.fire({
                                title: "Atenção!",
                                text: "Erro ao processar transferência.",
                                allowOutsideClick: false,
                                icon: "error"
                            });
                        }
                    },
                    error: function (response) { }
                });
            }
        });
    });

    function capturePayment(orderId) {
        $.ajax({
            url: '/create_payment_to_startup',
            type: 'get',
            data: {
                'orderId': orderId
            },
            success: function (response) {
                return (1);
            },
            error: function (error) {
                return (0);
            }
        });
    }
});