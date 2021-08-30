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

    $(document).click(function(element){
      
      if($(element.target).attr('id') != 'myself_img'){
        $(".submenu").hide(100);
      }
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
        $.ajax({
            url: "/startup/load",
            type: "get",
            data: {
                '_token': '{{csrf_token()}}'
            },
            success: function (response) {
                $("#startup_cards_container").empty();
                $("#startup_cards_container").html(response);

                $("#startup_cards_container div").first().show(300,function showNext(){
                    $(this).next("div").show(200,showNext);
                }
                );
                
            },
            error: function (error) {
                console.log("Erro ao carregar startups cards");
                console.log(error);
            }

        });
    }

    $("._checkbox").change(function () {
        filtrar();
    });

    $("#search_filtro").keyup(function () {
        filtrar();
    });

    $(".filtroall").change(function () {
        filtrar();
    });


    function filtrar() {
        var fasesSelecionadas = Array();
        var setoresSelecionados = Array();
        var tiposNegocioSelecionados = Array();
        var value_search_filtro = undefined;

        $(".faseFiltro").each(function () {
            if ($(this).prop('checked'))
                fasesSelecionadas.push($(this).attr("value"));
        });

        $(".setorFiltro").each(function () {
            if ($(this).prop('checked'))
                setoresSelecionados.push($(this).attr("value"));
        });

        $(".tiponegocioFiltro").each(function () {
            if ($(this).prop('checked'))
                tiposNegocioSelecionados.push($(this).attr("value"));
        });

        value_search_filtro = $("#search_filtro").val();

        $.ajax({
            url: "/startup/filter",
            type: "get",
            data: {
                '_token': '{{csrf_token()}}',
                'fases': fasesSelecionadas,
                'setores': setoresSelecionados,
                'typeBusness': tiposNegocioSelecionados,
                'search': value_search_filtro
            },
            success: function (response) {
                $("#startup_cards_container").html('');
                $("#startup_cards_container").html(response);
                $("#startup_cards_container div").first().show(300,function showNext(){
                    $(this).next("div").show(200,showNext);
                }
                );
            },
            error: function (error) {
                console.log("Erro ao filtrar startups");
                console.log(error);
            }

        });
    }

})
