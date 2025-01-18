<header>
    <h1>Portifólio</h1>
    <h6>Startups investidas na plataforma</h6>
</header>
<section id="portifolio-investidor-body">
    @if (count($rodadas) > 0)
        <ul class="list-group list-group-flush">
            @foreach ($rodadas as $rodada)
                <li class="list-group-item">
                    <span>
                        <a href="{{ route('startup.perfil', $rodada->rodada->startup->user->code_user) }}">
                            {{ $rodada->rodada->startup->nome }}
                        </a>
                    </span>
                    <span>{{ $rodada->acoes_adquirida }}% de Participação</span>
                    <span>{{ $rodada->valor_investido }} AOA Investidos</span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="empty-portfolio">Nenhuma startup no portfólio</div>
    @endif
</section>