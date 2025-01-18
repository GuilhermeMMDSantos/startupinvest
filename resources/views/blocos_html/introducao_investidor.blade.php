
<div class="photo-container">
    <img src="{{ asset('storage/' . $investidor->foto) }}" alt="Foto do Investidor">
  </div>
  <div class="investor-details">
    <h1>{{ $investidor->nome_completo }}</h1>
    <span>Investidor • Pessoa Física</span>
    <div id="container-btn-introducao-investidor" class="mt-3">
      @if($myProfile != true && $permissoesVerPitch != null && $permissoesVerPitch->estado == 'espera')
      <button id="btn-pode-assistir-pitch" class="btn btn-outline-secondary">Permitir ver pitch</button>
      @elseif($myProfile != true && $permissoesVerPitch != null && ($permissoesVerPitch->estado == 'ativo' || $permissoesVerPitch->estado == 'livre'))
      <span>Solicitação atendida</span>
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