<ul class="my-select-input">
    @foreach($instituicoes as $instituicao)
    <li><a role="button" valor="{{$instituicao->id}}">{{$instituicao->nome}}</a></li>
    @endforeach
</ul>