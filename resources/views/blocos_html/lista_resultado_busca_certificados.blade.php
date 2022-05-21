<ul class="my-select-input">
    @forelse($certificados as $certificado)
    <li><a role="button">{{$certificado->nome}}</a></li>
    @empty
    <li>Sem correspondência</li>
    @endforelse
</ul>