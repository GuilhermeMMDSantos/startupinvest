<div class="col-12 col-sm-4" style=" text-align:center;padding-bottom:7px;">

  <div style="width:110px;height:110px;border:1px solid #ccc;border-radius:50%;margin:auto;">
    <img src="{{asset('storage/'.$investidor->foto)}}" style="width:100%;height:100%;border-radius:50%;object-fit:cover !important;">
  </div>

  <p >
    <span style="font-size:25px;">{{$investidor->nome_completo}}</span>
  </p>
  <span style="display:block;margin-top:-17px;color:#545b62b0;font-size:15px;" >Investidor<i style="font-size:20px;margin-right:4px;margin-left:4px;">•</i>Pessoa Física</span>
  <div id="container-btn-introducao-investidor">
    @if($myProfile != true)
    <!--<button type="button" id="btn-meeting-investor" class="btn btn-outline-secondary " style="height:33px;font-size:14px;">Meeting</button>-->
    @else
    <!--<a role="button" href="{{route('rodadas.page')}}" class="btn btn-outline-secondary " style="height:33px;font-size:14px;border-radius: 30px">Rodadas de captação</a>
-->@endif

    @if(isset($permissoesVerPitch) && $permissoesVerPitch->estado == 'espera' && $myProfile != true)
    <button type="button" id="btn-pode-assistir-pitch" class="btn btn-outline-secondary" style="height:33px;font-size:14px;border-radius: 30px">Permitir ver pitch</button>

    @elseif(isset($permissoesVerPitch) && $permissoesVerPitch->estado == 'ativo' && $myProfile != true)

    <span style="font-size:14px;">Solicitação atendida...</span>

    @endif

  </div>

</div>
<div class="col-12 col-sm-8">
  <video src="{{asset('storage/'.$investidor->video_investidor)}}" style="border:1px solid #ccc;" width="100%" height="100%" controls="true">
  </video>
</div>