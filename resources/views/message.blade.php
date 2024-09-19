@extends('inicio_base')
@section('stylesheets_base_inicio')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/message.css') }}">
@endsection

@section('contentBody_base_inicio')
    <section id="body-section" class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:10px;">

        <div class="card">
            <div class="card-body">
                <div id="tolkeed-to" style="width:400px;border:1px solid #ccc;">
                    <header style="border:1px solid #ccc;">
                        <h5 style="padding:7px 16px;">
                            Meetings
                        </h5>
                    </header>
                    <div id="tolkeed-to-body">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>


                </div>
                <div id="message-contaner">

                </div>
            </div>
        </div>

    </section>
@endsection



@section('scripts_base_inicio')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var userIdClicked = undefined;

        $(function() {


            loadMeetings();





            $("#tolkeed-to-body").on("click", ".meeting", function() {
                var idUser = $(this).attr("guito");
                userIdClicked = idUser;
                loadMessagesMeeting(idUser);

            });

            $("#message-contaner").on("click", "#btn-enviar-message", function() {
                var message = $("#textarea").val().trim();


                $.ajax({
                    url: '/send_message_page',
                    type: 'post',
                    data: {
                        'codeUser': userIdClicked,
                        'mensagem': message
                    },
                    success: function(response) {

                        $("#textarea").val('');

                        getNewMessage(response['messageId']);

                        loadScrollBarToBottom();
                    },
                    error: function(error) {
                        console.log("Erro ao enviar mensagem");
                        console.log(error);
                    }
                });


            });

            $(".card-body").on("click", ".meeting", function() {
                if (window.innerWidth <= 930) {
                    $("#tolkeed-to").hide();
                    $("#message-contaner").show();
                }
            });
            $(".card-body").on("click", "#btn-back-to-meetings", function() {
                if (window.innerWidth <= 930) {
                    $("#tolkeed-to").show();
                    $("#message-contaner").hide();
                }
            });

            //------------------------OUVINTES
            Echo.private('send-message-channel.' + '{{ $code }}')
                .listen('SendMessage', function(e) {
                    getNewMessage(e.messageId);
                });
            //----------------------------------------------




            function loadMeetings() {
                var secondOriginRequest = "{{ $userIdPostRequest }}";
                $.ajax({
                    url: 'load_meetings',
                    type: 'get',
                    data: {},
                    success: function(response) {
                        $("#tolkeed-to-body").empty();
                        $("#tolkeed-to-body").append(response['html']);
                        if (userIdClicked == undefined)
                            userIdClicked = $("#first_meeting").html();
                        if (secondOriginRequest)
                            userIdClicked = secondOriginRequest;
                        if (response['count'] > 0)
                            loadMessagesMeeting(userIdClicked);
                        else
                            showMeetingEmpty();
                    },
                    error: function(error) {
                        console.log("Erro ao carregar meetings");
                        console.log(error);
                    }
                });
            }

            function loadMessagesMeeting(idUser) {

                $.ajax({
                    url: 'load_messages_meeting',
                    type: 'get',
                    data: {
                        'idUser': idUser
                    },
                    success: function(response) {

                        $("#message-contaner").empty();
                        $("#message-contaner").append(response['html']);
                        loadScrollBarToBottom();


                        setStatusMessage(idUser);
                    },
                    error: function(error) {
                        console.log("Erro ao carregar meeting");
                    }

                });

            }

            function getNewMessage(idMessage) {
                $.ajax({
                    url: "/get_new_message",
                    type: "get",
                    data: {
                        "idMessage": idMessage
                    },
                    success: function(response) {


                        $("#chat").append(response['html']);
                        loadMeetings();
                    },
                    error: function(error) {
                        console.log("Erro ao carregar nova mensagem startup");
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
                        $("#marcador_" + idOtherUser).hide();
                    },
                    error: function(error) {
                        console.log("Erro ao carregar ao alterar status das mensagens");
                        console.log(error);
                    }
                });
            }

            function showMeetingEmpty() {
                $.ajax({
                    url: "/show_meeting_empty",
                    type: "get",
                    success: function(response) {
                        $("#tolkeed-to-body").empty();
                        $("#tolkeed-to-body").append(response['html']);
                    },
                    error: function(error) {
                        console.log("Erro ao carregar empty meeting");
                        console.log(error);
                    }
                });
            }


        });
    </script>
@endsection
