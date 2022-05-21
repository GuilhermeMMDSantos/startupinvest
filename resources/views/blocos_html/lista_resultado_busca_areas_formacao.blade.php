<ul class="my-select-input">
    @forelse($areas as $area)
    <li><a role="button">{{$area->nome}}</a></li>
    @empty
    <li>Sem correspondência</li>
    @endforelse
</ul>