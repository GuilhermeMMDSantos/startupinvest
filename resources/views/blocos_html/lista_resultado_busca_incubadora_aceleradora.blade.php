<ul class="my-select-input">
    @forelse($incubadorasAceleradoras as $valor)
    <li><a role="button" valor="{{$valor->id}}">{{$valor->nome}}</a></li>
    @empty
    <li style="cursor:pointer;">Sem correspondência</li>
    @endforelse
</ul>