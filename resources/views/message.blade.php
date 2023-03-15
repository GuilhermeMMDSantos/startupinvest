@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/message.css')}}">
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:10px;">

    <div class="card">
        <div class="card-body">
            <div id="tolkeed-to" style="width:400px;border:1px solid #ccc;">


            </div>
            <div id="message-contaner" style="border:1px solid #ccc;width:65%;min-height:500px;">

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

    $(function() {

        var userIdClicked = undefined;
        loadMeetings();



        $("#tolkeed-to").on("click", ".meeting", function() {
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
                },
                error: function(error) {
                    console.log("Erro ao enviar mensagem");
                    console.log(error);
                }
            });


        });


        //------------------------OUVINTES
        Echo.private('send-message-channel.' + '{{$code}}')
            .listen('SendMessage', function(e) {
                getNewMessage(e.messageId);
            });
        //----------------------------------------------
        function loadMeetings() {
            $.ajax({
                url: 'load_meetings',
                type: 'get',
                data: {},
                success: function(response) {
                    $("#tolkeed-to").empty();
                    $("#tolkeed-to").append(response['html']);

                    loadMessagesMeeting ( $("#first_meeting").html() );
                },
                error: function(error) {
                    console.log("Erro ao carregar meetings");
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
    });
</script>
@endsection