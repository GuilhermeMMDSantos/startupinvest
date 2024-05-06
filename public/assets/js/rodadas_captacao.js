$(function () {
    const loader = "<div class='d-flex justify-content-center' style='width:100%;height:100%;'>\
    <div class='spinner-border align-self-center' style='width: 7rem; height: 7rem;' role='status'>\
        <span class='sr-only'>Loading...</span>\
    </div>\
</div>";

    loadEstatisicas();
    loadListaCaptacoes();

    $("#filtro-estado-rodada").change(loadListaCaptacoes);

    $("#container-lista-rodadas").on("click", "#pagination a,#search_btn", function() {

        var url = $(this).attr("href");
        var finalURL = url;
        let filtro = $("#filtro-estado-rodada").val();

        $.ajax({
            url: finalURL,
            type: 'get',
            data: {
                'filtro': filtro
            },
            success: function(response) {
                $("#container-lista-rodadas").empty();
                $("#container-lista-rodadas").append(response['html']);
           },
            error: function(error) {
                console.log("Erro ao carregar lista capatação next");
                console.log(error);
            }
        });
        return false;
    });

    function loadEstatisicas() {

        $.ajax({
            url: "/load_estatistica_rodadas",
            type: "get",
            data: {},
            success: function (response) {
                $("#container-filtro").show();
                $("#estatistica").empty();
                $("#estatistica").append(response['html']);
            },
            error: function (error) {
                console.log("Erro ao carregar estatistica");
                console.log(error);
            }
        });
    }

    function loadListaCaptacoes() {

        $("#container-lista-rodadas").empty();
        $("#container-lista-rodadas").append(loader);

        let filtro = $("#filtro-estado-rodada").val();

        $.ajax({
            url: "/load_lista_rodadas",
            type: "get",
            data: {
                'filtro': filtro
            },
            success: function (response) {
                $("#container-lista-rodadas").empty();
                $("#container-lista-rodadas").append(response['html']);
            },
            error: function (error) {
                console.log("Erro ao carregar lista capatação");
                console.log(error);
            }
        });

    }
})