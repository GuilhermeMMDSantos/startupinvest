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
        font-size: 24px;
        color: #333;
        margin-bottom: 5px;
    }

    .investor-intro .investor-details span {
        font-size: 15px;
        color: #666;
    }

    .investor-intro .video-container {
        width: 100%;
        max-width: 600px;
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
  <div class="video-container">
    <video src="{{ asset('storage/' . $investidor->video_investidor) }}" controls></video>
  </div>
</div>