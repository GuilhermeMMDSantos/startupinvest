$(function () {

    var contadoresChecados = [3, 6, 3];

    loadStartupCards();

    $("#faseFiltroall").prop('checked', true);
    $(".faseFiltro").prop('checked', true);

    $("#faseFiltroall").click(function () {
        alterCheckboxStatus1("faseFiltro", 0, 3);
    });
    $(".faseFiltro").click(function () {
        alterCheckboxStatus2(this, "faseFiltro", 0, 3);
    });

    $("#setorFiltroall").prop('checked', true);
    $(".setorFiltro").prop('checked', true);

    $("#setorFiltroall").click(function () {
        alterCheckboxStatus1("setorFiltro", 1, 6);
    });
    $(".setorFiltro").click(function () {
        alterCheckboxStatus2(this, "setorFiltro", 1, 6);
    });

    $("#tiponegocioFiltroall").prop('checked', true);
    $(".tiponegocioFiltro").prop('checked', true);

    $("#tiponegocioFiltroall").click(function () {
        alterCheckboxStatus1("tiponegocioFiltro", 2, 3);
    });
    $(".tiponegocioFiltro").click(function () {
        alterCheckboxStatus2(this, "tiponegocioFiltro", 2, 3);
    });


    $("#input-busca-startup").click(function () {
        $("#input-busca-startup input").focus();
    });

    $("#fase-desenvolvimento-filter").change(loadStartupCards);
    $("#sector-economico-filter").change(loadStartupCards);
    $("#tipo-negocio-filter").change(loadStartupCards);
    $("#nome-startup-filter").keyup(loadStartupCards);


    Echo.private('abrir-rodada-channel')
        .listen('AbrirRodada', function (e) {
            loadStartupCards();
        });

    Echo.private('anular-rodada-channel')
        .listen('AnularRodada', function (e) {
            loadStartupCards();
        });


    function alterCheckboxStatus1(nomeFiltro, contador, limite) {
        $("#" + nomeFiltro + "all").prop('checked', true);
        $("." + nomeFiltro).prop('checked', true);
        contadoresChecados[contador] = limite;
    }

    function alterCheckboxStatus2(ckeckboxObj, nomeFiltro, contador, limite) {
        if ($(ckeckboxObj).prop('checked')) {
            contadoresChecados[contador]++;
            if (contadoresChecados[contador] == limite) {
                $("#" + nomeFiltro + "all").prop('checked', true);
            }
        } else {
            contadoresChecados[contador]--;
            if (contadoresChecados[contador] < limite && contadoresChecados[contador] > 0) {
                $("#" + nomeFiltro + "all").prop('checked', false);
            } else if (contadoresChecados[contador] == 0) {
                $(ckeckboxObj).prop('checked', true);
                contadoresChecados[contador] = 1;
            }
        }
    }


    function loadStartupCards() {

        let faseDesenvolvimento = $("#fase-desenvolvimento-filter").val();
        let setorEconomico = $("#sector-economico-filter").val();
        let tipoNegocio = $("#tipo-negocio-filter").val();
        let nomeStartup = $("#nome-startup-filter").val().trim();


        $.ajax({
            url: "/startup/load",
            type: "get",
            data: {
                '_token': '{{csrf_token()}}',
                'faseDesenvolvimento': faseDesenvolvimento,
                'setorEconomico': setorEconomico,
                'tipoNegocio': tipoNegocio,
                'nomeStartup': nomeStartup
            },
            success: function (response) {
                $("#startup_cards_container").empty();
                $("#startup_cards_container").html(response);

                $("#startup_cards_container div").first().show(300, function showNext() {
                    $(this).next("div").show(200, showNext);
                });

            },
            error: function (error) {
                console.log("Erro ao carregar startups cards");
                console.log(error);
            }

        });
    }







})
