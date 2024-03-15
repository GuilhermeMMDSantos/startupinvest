$(function () {

    var contadoresChecados = [3, 6, 3];

    loadStartupCards();

    

    $("#input-busca-startup").click(function () {
        $("#input-busca-startup input").focus();
    });

    $("#fase-desenvolvimento-filter").change(loadStartupCards);
    $("#sector-economico-filter").change(loadStartupCards);
    $("#nome-startup-filter").keyup(loadStartupCards);

//----------------------------------------OUVINTES

    Echo.private('abrir-rodada-channel')
        .listen('AbrirRodada', function (e) {
            loadStartupCards();
        });

    Echo.private('anular-rodada-channel')
        .listen('AnularRodada', function (e) {
            loadStartupCards();
        });

//-----------------------------------------------


    function loadStartupCards() {


       let faseDesenvolvimento = $("#fase-desenvolvimento-filter").val();
        let setorEconomico = $("#sector-economico-filter").val();
        let nomeStartup = $("#nome-startup-filter").val().trim();

       

        $.ajax({
            url: "/startup/load",
            type: "get",
            data: {
                '_token': '{{csrf_token()}}',
                'faseDesenvolvimento': faseDesenvolvimento,
                'setorEconomico': setorEconomico,
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
