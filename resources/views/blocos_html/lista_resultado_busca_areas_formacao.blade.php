<ul class="my-select-input">
    @forelse($areas as $area)
    <li><a role="button" valor="{{$area->id}}">{{$area->nome}}</a></li>
    @empty
    <li>Sem correspondência</li>
    @endforelse
</ul>