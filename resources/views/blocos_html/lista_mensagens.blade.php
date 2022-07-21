@forelse($mensagens as $mensagem)

@php
$imagem = '';
$nome = '';
if($mensagem->remetente->tipo == 'investidor'){
$imagem = $mensagem->remetente->investidor->foto;
$nome = $mensagem->remetente->investidor->nome;
if($mensagem->remetente->investidor->sobrenome != null){
$nome = $nome .' '.$mensagem->remetente->investidor->sobrenome;
}
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

  <div style="padding-left:5px;">
    <h6 style="font-weight:bold;font-size:14px;"> {{$nome}} </h6>
    <p>{{$mensagem->conteudo}}</p>
  </div>



</div>
@empty
<p style="text-align:center;">...</p>
@endforelse