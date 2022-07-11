<ul class="my-select-input">
    @foreach($funcoes as $funcao)
    <li><a role="button" valor="{{$funcao->id}}">{{$funcao->nome}}</a></li>
    @endforeach
</ul>