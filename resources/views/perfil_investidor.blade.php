@extends('inicio_base')
@section('stylesheets_base_inicio')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/perfil_investidor.css') }}" />
@endsection

@section('contentBody_base_inicio')
    <style type="text/css">
        /* Layout Principal */
        .profile-container {
            padding: 40px 6.5%;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Introdução do Investidor */
        #container-introducao-investidor {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 20px 0;
        }

        #container-introducao-investidor .photo-container {
            width: 110px;
            height: 110px;
            border: 1px solid #ccc;
            border-radius: 50%;
            overflow: hidden;
            margin: auto;
        }

        #container-introducao-investidor .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #container-introducao-investidor .investor-details {
            flex-grow: 1;
            margin-left: 20px;
        }

        #container-introducao-investidor .investor-details h1 {
            font-size: 20px;
            color: #333;
            margin-bottom: 5px;
        }

        #container-introducao-investidor .investor-details span {
            font-size: 15px;
            color: #666;
        }

        #container-introducao-investidor .video-container {
            width: 100%;
            max-width: 700px;
            margin-top: 20px;
        }

        #container-introducao-investidor .video-container video {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        #portifolio-investidor-container  header {
            margin-top: 40px;
        }

        #portifolio-investidor-container header h1 {
            font-size: 28px;
            color: #333;
        }

        #portifolio-investidor-container header h6 {
            font-size: 14px;
            color: #666;
        }

        #portifolio-investidor-container ul {
            list-style: none;
            padding: 0;
        }

        #portifolio-investidor-container .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }

        #portifolio-investidor-container .list-group-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #portifolio-investidor-container .list-group-item a {
            text-decoration: none;
            font-size: 18px;
            color: #333;
        }

        #portifolio-investidor-container .list-group-item span {
            font-size: 14px;
            color: #666;
        }

        .empty-portfolio {
            text-align: center;
            padding: 50px;
            color: #999;
            font-size: 20px;
        }

      
        .btn-outline-secondary {
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 14px;
            padding: 5px 15px;
            color: #333;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #f0f0f0;
            color: #000;
        }
    </style>

    <section class="profile-container container-fluid">

        <div id="container-introducao-investidor">
            <div class="d-flex justify-content-center " style="width:100%;height:120px;">
                <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div id="portifolio-investidor-container">
          <div class="d-flex justify-content-center " style="width:100%;height:120px;">
            <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        </div>

    </section>


    @include('modais/adicionar_experiencia_investidor')
    @include('modais/adicionar_formacao_investidor')
@endsection



@section('scripts_base_inicio')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var popupChatOpen = false;

        $(function() {

            getIntroducaoInvestidor();
            getStartupsNoPortifolio();



            $("#container-introducao-investidor").on('click', '#btn-pode-assistir-pitch', function() {
                
                $.ajax({
                    url: "/set_permissao_ver_pitch",
                    type: "get",
                    data: {
                        codeUser: '{{ $codigoInvestidor }}'
                    },
                    success: function(response) {
                        getIntroducaoInvestidor();
                    },
                    error: function(error) {
                        console.log("Erro ao dar permissao ver pitch");
                        console.log(error);
                    }
                });
            });
            //--------------------chat
            $("#container-introducao-investidor").on('click', '#btn-meeting-investor', openMeetingChat)
            //----------------------------------------------------



            $("#popup-chat-container-investor").on('click', '#btn-enviar-popup-chat-investor', function() {



                var mensagem = $("#textarea").val().trim();
                if (mensagem.length == 0)
                    return true;

                var codeInvestor = "{{ $codigoInvestidor }}";



                $.ajax({
                    url: '/send_message',
                    type: 'post',
                    data: {
                        'codeUser': codeInvestor,
                        'mensagem': mensagem
                    },
                    success: function(response) {
                        $("#textarea").val('');
                        getNewMessage(response['messageId']);
                        //ATENÇÃO!
                        /*
                         Deve ser posto uma especie de wait. 
                         a funcao loadScrollBarToBottom 
                         somente deve executar apos o termino 
                         da funcao getNewMessage
                         */

                        loadScrollBarToBottom();

                    },
                    error: function(error) {
                        console.log("Erro ao enviar mensagem investidor");
                        console.log(error);
                    }
                });
            });

            $("#popup-chat-container-investor").on('click', "#btn-close-chatmeeting", function() {
                $("#popup-chat-container-investor").empty();
                popupChatOpen = false;

            });



            $(document).click(function(elemento) {
                $(".my-select-input").hide(100);
            });

            //--------------------------------------OUVINTES
            Echo.private('send-message-channel.' + '{{ $code }}')
                .listen('SendMessage', function(e) {

                    getNewMessage(e.messageId);

                });

            //---------------------------------------------------





            function getIntroducaoInvestidor() {
                $.ajax({
                    url: "/get_introducao_investidor",
                    type: "get",
                    data: {
                        codeUser: '{{ $codigoInvestidor }}',
                        myProfile: '{{ $myProfile }}'
                    },
                    success: function(response) {

                        $("#container-introducao-investidor").empty();
                        $("#container-introducao-investidor").append(response['html']);
                    },
                    error: function(error) {
                        console.log("Erro ao carregar introdução investidor");
                        console.log(error);
                    }
                });
            }

            function getStartupsInvestidas() {
                $.ajax({
                    url: "/get_startups_investidas",
                    type: "get",
                    success: function(response) {

                        $("#container-startups-investidas").empty();
                        $("#container-startups-investidas").append(response['html']);
                    },
                    error: function(error) {
                        console.log("Erro ao carregar startups investidas");
                        console.log(error);
                    }
                });
            }


            function openMeetingChat() {
                var codeinvestor = "{{ $codigoInvestidor }}";
                var idUser = "{{ $idUser }}";

                if (popupChatOpen == true) {
                    $("#popup-chat-container-investor").empty();
                    popupChatOpen = false;
                    return false;
                }

                $.ajax({
                    url: '/load_popup_chat',
                    type: 'get',
                    data: {
                        'codeUser': codeinvestor
                    },
                    success: function(response) {
                        $("#popup-chat-container-investor").append(response['html']);
                        popupChatOpen = true;
                        loadScrollBarToBottom();
                        setStatusMessage(idUser);
                    },
                    error: function(error) {
                        console.log("Erro ao carregar popup-chat");
                    }
                });
            }

            function getNewMessage(idMessage) {
                $.ajax({
                    async: false,
                    url: "/get_new_message",
                    type: "get",
                    data: {
                        "idMessage": idMessage
                    },
                    success: function(response) {
                        $("#chat").append(response['html']);

                    },
                    error: function(error) {
                        console.log("erro ao carregar nova mensagem investidor");
                        console.log(error);
                    }
                });
            }


            function loadScrollBarToBottom() {

                $("#chat").scrollTop($("#chat").prop('scrollHeight'));
            }

            function setStatusMessage(idOtherUser) {

                $.ajax({
                    url: "/set_status_message",
                    type: "get",
                    data: {
                        "idOtherUser": idOtherUser
                    },
                    success: function(response) {

                    },
                    error: function(error) {
                        console.log("Erro ao carregar ao alterar status das mensagens");
                        console.log(error);
                    }
                });
            }

            function getStartupsNoPortifolio() {
                $.ajax({
                    url: "/get_startups_no_portifolio",
                    type: "get",
                    data: {
                        codeUser: '{{ $codigoInvestidor }}',
                        myProfile: '{{ $myProfile }}'
                    },
                    success: function(response) {

                        $("#portifolio-investidor-container").empty();
                        $("#portifolio-investidor-container").append(response['html']);
                    },
                    error: function(error) {
                        console.log("Erro ao carregar startups no portifolio");
                        console.log(error);
                    }
                });
            }

        });
    </script>
@endsection
