@forelse($mensagens as $mensagem)

@php
$imagem = '';
$nome = '';
if($mensagem->remetente->tipo == 'investidor'){
$imagem = $mensagem->remetente->investidor->foto;
$nome = $mensagem->remetente->investidor->nome_completo;

}
else{
$imagem = $mensagem->remetente->startup->logotipo;
$nome = $mensagem->remetente->startup->nome;
}
@endphp
<div style="display:flex;padding:13px 8px;background:#fff;">



  <div style="width:50px;height:50px;border:1px solid #ccc;border-radius:50%;">
    <img src="{{asset('storage/'.$imagem)}}" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
  </div>

  <div style="padding-left:5px; background:#6c757d3d; margin-left:5px; padding:10px; border-radius:10px;">
    <h6 style="font-weight:bold;font-size:14px;"> {{$nome}} <span style="font-size:12px;color:#6c757d69;">•</span>&nbsp; <span style="font-size:12px;color:#6c757d69;">{{$mensagem->dataenvio}}</span></h6>
    <p style="max-width:500px;">{{$mensagem->conteudo}}</p>
  </div>



</div>
@empty
<p style="text-align:center;">...</p>
@endforelse