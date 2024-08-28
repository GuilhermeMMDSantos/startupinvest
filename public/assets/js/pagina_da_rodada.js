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

    $(".situation-container").on('click', '.btn-eliminar-contrato', function () {

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
                $.ajax({
                    url: '/rm_contrato',
                    type: 'get',
                    data: {
                        'idInvestor': idInvestidor,
                        ' rodadaId': rodadaId
                    },
                    success: function (response) {
                        $("#situation-container" + idInvestidor).empty();
                        $("#situation-container" + idInvestidor).append(response['html']);
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

    $(".situation-container").on('change', '.field-contract-2', function () {


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
                $("#situation-container" + idInvestidor).empty();
                $("#situation-container" + idInvestidor).append(response['html']);
            },
            error: function (error) {
                console.log(error);
                console.log("Erro ao carregar contrato.");
            }
        });
    });


    function updateInvestSituation1() {
        let rodadaId = $("#title-page").attr('val');
        $("#investor-invest-situation-container").empty();
        $("#investor-invest-situation-container").append(loader);
        $.ajax({
            url: '/update_iinvest_situation',
            type: 'get',
            data: {
                'rodadaId': rodadaId
            },
            sucess: function (response) {
                $("#investor-invest-situation-container").empty();
                $("#investor-invest-situation-container").append(response['html']);
            },
            error: function (error) {
                console.log("Erro");
                console.log(error);

            }
        });
    }

    //---------------Js DA MODAL

    var scrollToTopBtn = document.getElementById('scrollToTopBtn');
    var modalBody = document.querySelector('#pdfModal');

    modalBody.addEventListener('scroll', function() {
        if (modalBody.scrollTop > 50) {
            scrollToTopBtn.style.display = 'block';
        } else {
            scrollToTopBtn.style.display = 'none';
        }
    });


    scrollToTopBtn.addEventListener('click', function() {
        modalBody.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

});