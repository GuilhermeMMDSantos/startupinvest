$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var contagem;
    var ligarContagem = true;
    var objects = []; // array que tem os elementos html com a a contagem a decorrer
    var num_objects_out = 0;
    var num_objects_in = 0;

    $(".btn_aceitar").click(function () {



        var id_user_in_idAttr = parseInt($(this).attr('id').substring(12));
        var id_btnRegeitar = "btn_regeitar_" + id_user_in_idAttr;

        if ($('#' + id_btnRegeitar).html().length > 8) {
            return false;
        } // alternativa a simular inativadade do botao


        if ($(this).html() == 'Aceitar') {

            $(this).html("Aceitar 10");

            objects[id_user_in_idAttr - 1] = $(this);
            num_objects_in = num_objects_in + 1;




            $('#' + id_btnRegeitar).css({ // para mudar a cor do botao Regeitar dando a entender que enquanto a contagem aceitar decorre o botao regeitar fica inativo
                'background-color': '#dad8d5',
                'transition': 'all 0.3s'
            });


        } else if ($(this).html().length > 7) {

            $(this).html("Aceitar");

            let index = id_user_in_idAttr - 1;

            objects[index] = undefined;

            num_objects_out = num_objects_out + 1;


            $('#' + id_btnRegeitar).css({ // dar a entedender que o botao regeitar voltou a estar activo
                'background-color': '#e8bd63',
                'transition': 'all 0.3s'
            });

        }

        if (ligarContagem) {

            ligarContagem = false;
            contagem = setInterval(funContadora, 1000);

        }


    });

    $(".btn_regeitar").click(function () {

        var id_user_in_idAttr = parseInt($(this).attr('id').substring(13));
        var id_btnaceitar = "btn_aceitar_" + id_user_in_idAttr;

        if ($('#' + id_btnaceitar).html().length > 7) {
            return false;
        } // alternativa a simular inativadade do botao

        if ($(this).html() == 'Regeitar') {

            $(this).html("Regeitar 10");

            objects[id_user_in_idAttr - 1] = $(this);
            num_objects_in = num_objects_in + 1

            $('#' + id_btnaceitar).css({ // para mudar a cor do botao aceitar dando a entender que enquanto a contagem regeitar decorre o botao aceitar fica inativo
                'background-color': '#dad8d5',
                'transition': 'all 0.3s'
            });


        } else if ($(this).html().length > 8) {

            $(this).html("Regeitar");

            let index = id_user_in_idAttr - 1;

            objects[index] = undefined;

            num_objects_out = num_objects_out + 1;

            $('#' + id_btnaceitar).css({ // dar a entedender que o botao aceitar voltou a estar activo
                'background-color': '#e8bd63',
                'transition': 'all 0.3s'
            });


        }

        if (ligarContagem) {

            ligarContagem = false;
            contagem = setInterval(funContadora, 1000);

        }


    });


    function funContadora() {

        objects.forEach((item, index) => {

            var segundos;
            var action;
            var id_user_in_idAttr_local;

            if (item != undefined) {

                if (item.html().substring(0, 1) == 'A') { //A-Aceitar

                    segundos = parseInt(item.html().substring(8)) - 1;
                    item.html("Aceitar " + segundos);
                    action = "Aceitar";
                    id_user_in_idAttr_local = item.attr('id').substring(12);

                } else if (item.html().substring(0, 1) == 'R') { //R-Regeitar
                    segundos = parseInt(item.html().substring(9)) - 1;
                    item.html("Regeitar " + segundos);
                    action = "Regeitar";
                    id_user_in_idAttr_local = item.attr('id').substring(13);
                }



                if (segundos == 0) {

                   

                    let id_cartao_user = "cartao_user" + id_user_in_idAttr_local;
                    let id_user = parseInt(id_user_in_idAttr_local);

                    num_objects_out = num_objects_out + 1;

                     

                     $('#'+id_cartao_user).hide(1000);
                     $('#'+id_cartao_user).css({
                         'display':'none'
                     });
                   
 
                    $.ajax({
                        method: 'post',
                        url: 'atualizar_stado',
                        data: {
                            id: id_user,
                            action_: action
                        },
                        success: function (retorno) {
                            console.log("sucesso");
                        },
                        error: function (retorno) {
                            console.log("erro");
                        }
                    });


                }

            }

        });



        

        if (num_objects_out == num_objects_in) {
            clearInterval(contagem);
            ligarContagem = true;
        }
    }


});
