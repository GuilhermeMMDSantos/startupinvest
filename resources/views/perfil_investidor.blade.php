@extends('inicio_base')
@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/perfil_investidor.css')}}" />
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
  .investor-intro {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    padding: 20px 0;
  }

  .investor-intro .photo-container {
    width: 110px;
    height: 110px;
    border: 1px solid #ccc;
    border-radius: 50%;
    overflow: hidden;
    margin: auto;
  }

  .investor-intro .photo-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .investor-intro .investor-details {
    flex-grow: 1;
    margin-left: 20px;
  }

  .investor-intro .investor-details h1 {
    font-size: 20px;
    color: #333;
    margin-bottom: 5px;
  }

  .investor-intro .investor-details span {
    font-size: 15px;
    color: #666;
  }

  .investor-intro .video-container {
    width: 100%;
    max-width: 700px;
    margin-top: 20px;
  }

  .investor-intro .video-container video {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 10px;
  }

  /* Portfólio */
  .portfolio-container header {
    margin-top: 40px;
  }

  .portfolio-container header h1 {
    font-size: 28px;
    color: #333;
  }

  .portfolio-container header h6 {
    font-size: 14px;
    color: #666;
  }

  .portfolio-container ul {
    list-style: none;
    padding: 0;
  }

  .portfolio-container .list-group-item {
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

  .portfolio-container .list-group-item:hover {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .portfolio-container .list-group-item a {
    text-decoration: none;
    font-size: 18px;
    color: #333;
  }

  .portfolio-container .list-group-item span {
    font-size: 14px;
    color: #666;
  }

  .empty-portfolio {
    text-align: center;
    padding: 50px;
    color: #999;
    font-size: 20px;
  }

  /* Botões */
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
  <!-- Introdução do Investidor -->
  <div class="investor-intro">

    <div class="photo-container">
      <img src="{{ asset('storage/' . $investidor->foto) }}" alt="Foto do Investidor">
    </div>
    <div class="investor-details">
      <h1>{{ $investidor->nome_completo }}</h1>
      <span>Investidor • Pessoa Física</span>
      <div id="container-btn-introducao-investidor" class="mt-3">
        @if($myProfile != true)
        <button id="btn-pode-assistir-pitch" class="btn btn-outline-secondary">Permitir ver pitch</button>
        @elseif(isset($permissoesVerPitch) && $permissoesVerPitch->estado == 'ativo')
        <span>Solicitação atendida...</span>
        @endif
      </div>
    </div>
    
    <div class="card shadow-sm video-container">

      <div class="card-body ">
      <h5 class="card-title decoration-underline badge badge-warning ml-2" style="font-size:20px; float:right;">Apresentação</h5>
        <video class="w-100 rounded" controls>

          <source src="{{ asset('storage/' . $investidor->video_investidor) }}" type="video/mp4">
          Seu navegador não suporta vídeos.
        </video>
      </div>
    </div>
  </div>

  <!-- Portfólio -->
  <div class="portfolio-container">
    <header>
      <h1>Portfólio</h1>
      <h6>Startups investidas na plataforma</h6>
    </header>
    <section id="portifolio-investidor-body">
      @if(count($rodadas) > 0)
      <ul class="list-group list-group-flush">
        @foreach($rodadas as $rodada)
        <li class="list-group-item">
          <span>
            <a href="{{ route('startup.perfil', $rodada->rodada->startup->user->code_user) }}">
              {{ $rodada->rodada->startup->nome }}
            </a>
          </span>
          <span>{{ $rodada->acoes_adquirida }}% de Participação</span>
          <span>{{ $rodada->valor_investido }} AOA Investidos</span>
        </li>
        @endforeach
      </ul>
      @else
      <div class="empty-portfolio">Nenhuma startup no portfólio</div>
      @endif
    </section>
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