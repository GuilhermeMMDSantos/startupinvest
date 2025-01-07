<style type="text/css">
    .link-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: #333;
    }

    .link-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        text-decoration: none;
    }

    .card-container .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s;
    }

    .card-container .card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        border-bottom: 1px solid #ddd;
        object-fit: contain;
        background-color: #f9f9f9;
    }

    .card-container .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .card-container .card-text {
        font-size: 14px;
        color: #555;
    }

    .badge {
        background: #f8f9fa;
        color: #6c757d;
        font-size: 12px;
        margin-right: 5px;
        padding: 3px 7px;
        border-radius: 5px;
    }

    .progress {
        height: 6px;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: #ffc107;
    }

    .card-container .card-footer {
        background-color: #f9f9f9;
        border-top: 1px solid #ddd;
    }
</style>

<div class="row" style="padding-top:20px;">
    @forelse($startupsCards as $startupCard)
    <div class="col-sm-6 col-md-4 mb-4 card-container">
        <a href="{{ route('startup.perfil', $startupCard->user->code_user) }}" class="link-card">
            <div class="card h-100">
                <div style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('storage/' . $startupCard->logotipo) }}" class="card-img-top" style="max-width: 100%; max-height: 100%;">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $startupCard->nome }}</h5>
                    <p>
                        <span class="badge">{{ $startupCard->fase->nome }}</span>
                        <span class="badge">{{ $startupCard->setor->nome }}</span>
                    </p>
                    <p class="card-text">{{ str_replace('##', ' ', $startupCard->pitch_elevator) }}</p>
                </div>
                @if($startupCard->rodadaAtual)
                <div class="card-footer">
                    <p style="font-size: 14px;">
                        {{ number_format(($startupCard->rodadaAtual->valor_obtido * 100) / $startupCard->rodadaAtual->valor_objetivo, 2) }}%
                        <i style="font-size: 15px; margin: 0 4px; color: #ccc;">•</i>
                        {{ $startupCard->rodadaAtual->tempo_restante }} Dias Restantes
                    </p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ ($startupCard->rodadaAtual->valor_obtido * 100) / $startupCard->rodadaAtual->valor_objetivo }}%;"></div>
                    </div>
                    <div class="mt-3">
                        <p><strong>Objectivo:</strong> {{ number_format($startupCard->rodadaAtual->valor_objetivo, 2, ',', '.') }} AOA</p>
                        <p><strong>Atingido:</strong> {{ number_format($startupCard->rodadaAtual->valor_obtido, 2, ',', '.') }} AOA</p>
                        <p><strong>Investidores:</strong> {{ count($startupCard->rodadaAtual->investidores) }}</p>
                    </div>
                </div>
                @endif
            </div>
        </a>
    </div>
    @empty
    <div class="d-flex justify-content-center align-items-center col-12">
        <h4 style="font-size: 25px; color: #545b62;">Nenhuma Startup Buscando Financiamento</h4>
    </div>
    @endforelse
</div>
