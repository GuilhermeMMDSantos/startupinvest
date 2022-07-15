<div style="width:110px;height:110px;border:1px solid #ccc;border-radius:50%;">
  <img src="{{asset('storage/'.$investidor->foto)}}" style="width:100%;height:100%;border-radius:50%;object-fit:cover !important;">
</div>



<div style="width:87%;padding-left:15px;padding-right:5px;">
  <p>
    <span style="font-size:25px;margin-right:15px;">{{$investidor->nome}} @if($investidor->sobrenome!=null){{$investidor->sobrenome}}@endif</span>
  </p>
  <p style="margin-top:-15px;color:#0c141bb3;">
    Entidade: {{$investidor->tipo_entidade}}
  </p>
  <div style="text-align:right;;margin-top:-13px;">
    @if(isset($permissoesVerPitch) && $permissoesVerPitch->estado == 'espera')
    <button type="button" id="btn-pode-assistir-pitch" class="btn btn-outline-secondary" style="height:33px;font-size:14px;">Pode assistir pitch</button>

    @elseif(isset($permissoesVerPitch) && $permissoesVerPitch->estado == 'ativo')
    
    <button type="button" class="btn btn-outline-secondary"  style="height:33px;font-size:14px;">Solicitação atendida...</button>
       
    @endif

  </div>
</div>