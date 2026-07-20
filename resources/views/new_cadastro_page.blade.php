@extends('layout')

@section('contentBody')
<nav class="navbar navbar-dark landing-nav">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand fw-bold" id="logo" href="{{ route('new_home_page') }}">
            startup<strong>Investe</strong>
        </a>
    </div>
</nav>

<div class="container py-5">

    @if ($errors->any())
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
            @foreach ($errors->all() as $error)
                <div class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
                    <div class="toast-header">
                        <i class="fa fa-bell me-2"></i>
                        <strong class="me-auto">Validação</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="text-center mb-4" id="header-card">
        <h2 class="fw-bold mb-3">Cadastro</h2>
        <a role="button" class="input-type-entity @if(session('tipo') == false || session('tipo') == 'startup') input-type-entity-ativo @endif" id="entity-startup">Startup</a>
        &nbsp;&nbsp;
        <a role="button" class="input-type-entity @if(session('tipo') == 'investidor') input-type-entity-ativo @endif" id="entity-investor">Investidor</a>
        @if (session('tipo'))
            <input id="type-entity" value="{{ session('tipo') }}" hidden>
        @endif
    </div>

    <div class="auth-card auth-card--wide">
        @include('form_startup')
        @include('form_investidor')
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/new_cadastro.js') }}"></script>
@endsection
