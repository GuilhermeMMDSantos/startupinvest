@extends('inicio_base')

@section('contentBody_base_inicio')
<div class="container py-4" style="max-width: 480px;">
    <div class="card card-hover">
        <div class="list-group list-group-flush">
            <a href="{{ route('startup.perfil', Auth::user()->code_user) }}" class="list-group-item list-group-item-action py-3">
                <i class="fa fa-user me-2 text-muted"></i>Perfil {{ Auth::user()->tipo }}
            </a>
            @if (Auth::user()->tipo == 'investidor')
                <a href="{{ route('investidor.menu') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa fa-users me-2 text-muted"></i>Investidores
                </a>
            @endif
            <a href="{{ route('startup.menu') }}" class="list-group-item list-group-item-action py-3">
                <i class="fa fa-rocket me-2 text-muted"></i>Startups
            </a>
            <a href="{{ route('config_privacidade') }}" class="list-group-item list-group-item-action py-3">
                <i class="fa fa-gear me-2 text-muted"></i>Configurações e privacidade
            </a>
            <a href="{{ url('userout') }}" class="list-group-item list-group-item-action py-3 text-danger">
                <i class="fa fa-right-from-bracket me-2"></i>Sair
            </a>
        </div>
    </div>
</div>
@endsection
