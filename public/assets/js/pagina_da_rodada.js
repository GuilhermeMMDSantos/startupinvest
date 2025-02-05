$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {

    const loader = "<div class='d-flex justify-content-center' style='width:100%;height:100%;'>\
        <div class='spinner-border align-self-center' style='width: 4rem; height: 4rem;' role='status'>\
            <span class='sr-only'>Loading...</span>\
        </div>\
    </div>";

    $("#container-investor-na-rodada").on('click', '.btn-eliminar-contrato', function () {

        let idInvestidor = $(this).attr('linker');
        let rodadaId = $("#title-page").attr('val');



        swal.fire({
            title: "Deseja eliminar contrato?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#c43333bf",
            cancelButtonColor: "#319c4ad4",
            confirmButtonText: "Desejo",
            cancelButtonText: "Não",
            customClass: {
                confirmButton: "btn-eliminar-contrato-alert",
                cancelButton: "btn-eliminar-contrato-alert"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $("#situation-container" + idInvestidor).empty();
                $("#situation-container" + idInvestidor).append(loader);

                Swal.fire({
                    icon: "success",
                    title: "Contrato Eliminado",
                    showConfirmButton: false,
                    timer: 1500
                });


                $.ajax({
                    url: '/rm_contrato',
                    type: 'get',
                    data: {
                        'idInvestor': idInvestidor,
                        ' rodadaId': rodadaId
                    },
                    success: function (response) {
                        /*$("#situation-container" + idInvestidor).empty();
                        $("#situation-container" + idInvestidor).append(response['html']);*/
                        loadInvestorsIntoTheRound();
                        Swal.fire({
                            icon: "success",
                            title: "Contrato Eliminado",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function (error) {
                        console.log("Error");
                        console.log(error);
                    }
                });
            }
        });


    });

    $("#container-investor-na-rodada").on('change', '.field-contract-2', function () {
        var myForm = new FormData();
        let contract_pdf = $(this).prop("files")[0];
        let idInvestidor = $(this).attr('linker');
        let rodadaId = $("#title-page").attr('val');

        $("#situation-container" + idInvestidor).empty();
        $("#situation-container" + idInvestidor).append(loader);
        myForm.append('file', contract_pdf);
        myForm.append('idInvestor', idInvestidor);
        myForm.append('csrftokenmiddlewaretoken', "{{csrf_token()}}");
        myForm.append('idRodada', rodadaId);

        $.ajax({
            url: '/save_contrato',
            type: 'POST',
            contentType: false,
            processData: false,
            data: myForm,
            success: function (response) {
                // $("#situation-container" + idInvestidor).empty();
                //$("#situation-container" + idInvestidor).append(response['html']);
                loadInvestorsIntoTheRound();
            },
            error: function (error) {
                console.log(error);
                console.log("Erro ao carregar contrato.");
            }
        });
    });


    $("#container-investor-into-the-round").on("click", "#btn-discordar-contrato", async function () {
        const { value: text } = await Swal.fire({
            input: "textarea",
            inputLabel: "Message",
            inputPlaceholder: "Escreva os pontos que descorda.",
            inputAttributes: {
                "aria-label": "Type your message here"
            },
            showCancelButton: true
        });
        if (text) {
            let rodadaId = $("#title-page").attr('val');
            let csrf_code = '{{csrf_token()}}';
            var form = new FormData();
            form.append('csrfmiddlewaretoken', csrf_code);
            form.append('message', text);
            form.append('rodadaId', rodadaId);
            $.ajax({
                url: '/discordar_contrato',
                type: 'post',
                contentType: false,
                processData: false,
                data: form,
                success: function (response) {
                    loadInvestorIntoTheRound();
                    Swal.fire({
                        icon: "success",
                        title: "Pontos enviados",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function (error) {
                    console.log("Discordar contrato");
                    console.log(error);
                }
            });
        }
    });
    //---------------MODAL_VISUALIZER

    var scrollToTopBtn = document.getElementById('scrollToTopBtn');
    var modalBody = document.querySelector('#pdfModal');

    $("#btn-assinar").click(function () {
        swal.fire({
            title: "Assinar",
            icon: "info",
            text: "Clique onde deseja adicionar a assinatura no documento.",
            confirmButtonText: "Ok"
        }).then((result) => {
            if (result.isConfirmed)
                $(".pdf-page").addClass('clik-area');
        });
    });

    $("#btn-feito").click(function () {
        var pathDoc = $("#path_doc").val();
        let rodadaId = $("#title-page").attr('val');
        $.ajax({
            url: '/confirmar_assinatura',
            type: 'get',
            data: {
                'pathDoc': pathDoc,
                'rodadaId':rodadaId
            },
            success: function (response) {
                $("#pdfModal").modal('hide');
                if (response['tipo'] == 'startup')
                    loadInvestorsIntoTheRound();
                else
                    loadInvestorIntoTheRound();
                Swal.fire({
                    icon: "success",
                    title: "Contrato Assinado",
                    showConfirmButton: false,
                    timer: 1500
                });
                $('body').removeClass('modal-open');
            },
            error: function (error) {
                console.log("Erro");
                console.log(error);

            }
        });
    });

    $("#pdf-container").on('click', '.clik-area', function (event) {
        $("#signModal").modal('show');
        getPointToSign(event);
        $(".pdf-page").removeClass('clik-area');

    });

    $("#pdfModal").on("hidden.bs.modal", function (e) {
        $(".pdf-page").removeClass('clik-area');
    });

    modalBody.addEventListener('scroll', function () {
        if (modalBody.scrollTop > 50) {
            scrollToTopBtn.style.display = 'block';
        } else {
            scrollToTopBtn.style.display = 'none';
        }
    });


    scrollToTopBtn.addEventListener('click', function () {
        modalBody.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });



    //---------------------------END_MODAL_VISUALIZER


    function updateInvestSituation1() {
        let rodadaId = $("#title-page").attr('val');
        $("#investor-invest-situation-container").empty();
        $("#investor-invest-situation-container").append(loader);
        $.ajax({
            url: '/update_iinvest_situation1',
            type: 'get',
            data: {
                'rodadaId': rodadaId
            },
            success: function (response) {
                $("#investor-invest-situation-container").empty();
                $("#investor-invest-situation-container").append(response['html']);
            },
            error: function (error) {
                console.log("Erro");
                console.log(error);

            }
        });
    }

    function updateInvestSituation2() {
        var idInvestidor = $("#id-investor").val();
        let rodadaId = $("#title-page").attr('val');
        $.ajax({
            url: '/update_iinvest_situation2',
            type: 'get',
            data: {
                'idIvestidor': idInvestidor,
                'rodadaId': rodadaId
            },
            success: function (response) {
                $("#situation-container" + idInvestidor).empty();
                $("#situation-container" + idInvestidor).append(response['html']);
            },
            error: function (error) {
                console.log(error);
                console.log("Erro updateInvestSituation2.");
            }
        });
    }
    //---------------MODAL_VISUALIZER
    function getPointToSign(event) {
        const viewer = document.getElementById('pdf-container');
        const rect = viewer.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        $("#point_x").val(x);
        $("#point_y").val(y);
    }
    //-----------------------------------------

});