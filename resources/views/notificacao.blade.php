@extends('inicio_base')

@section('contentBody_base_inicio')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Notificações</h2>

    <div class="list-group">
        @forelse($notificacoes as $notificacao)
            <a href="{{ route('showownernotification', $notificacao->id) }}" class="list-group-item list-group-item-action d-flex gap-3 py-3 @if($notificacao->status != 'clicado') bg-primary bg-opacity-10 @endif">
                <img src="{{ asset('assets/img/investment-model-svgrepo-com.svg') }}" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;">
                <div>
                    <div>{{ $notificacao->message }}</div>
                    <small class="text-muted">{{ $notificacao->data }}</small>
                </div>
            </a>
        @empty
            <div class="list-group-item text-center text-muted py-4">
                Ainda não possui nenhuma notificação!
            </div>
        @endforelse
    </div>
</div>
@endsection
