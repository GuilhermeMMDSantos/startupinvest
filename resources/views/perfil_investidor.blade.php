@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_investidor.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:10px;">

  <div class="row" id="container-introducao-investidor">

    <div class="d-flex justify-content-center " style="width:100%;height:100%;">
      <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

  </div>


  <div class="row">
    <div class="col-12">
      <header class="mb-3">
        <h1>Portifólio</h1>
        <h6>Startups investidas na plataforma</h6>
      </header>
      <section class="mb-3" id="portifolio-investidor-body">
        <div class="d-flex justify-content-center " style="width:100%;height:100%;">
          <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </section>
    </div>
  </div>

  <div id="popup-chat-container-investor">
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
          codeUser: '{{$codigoInvestidor}}'
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

      var codeInvestor = "{{$codigoInvestidor}}";



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
    Echo.private('send-message-channel.' + '{{$code}}')
      .listen('SendMessage', function(e) {

        getNewMessage(e.messageId);

      });

    //---------------------------------------------------





    function getIntroducaoInvestidor() {
      $.ajax({
        url: "/get_introducao_investidor",
        type: "get",
        data: {
          codeUser: '{{$codigoInvestidor}}',
          myProfile: '{{$myProfile}}'
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
      var codeinvestor = "{{$codigoInvestidor}}";
      var idUser = "{{$idUser}}";

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
          codeUser: '{{$codigoInvestidor}}',
          myProfile: '{{$myProfile}}'
        },
        success: function(response) {
         
          $("#portifolio-investidor-body").empty();
          $("#portifolio-investidor-body").append(response['html']);
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