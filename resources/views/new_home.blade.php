@extends('layout')

@section('contentBody')
<nav class="navbar navbar-expand-lg navbar-dark landing-nav">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand fw-bold" id="logo" href="{{ route('new_home_page') }}">
            startup<strong>Investe</strong>
        </a>

        <div class="d-flex gap-3">
            <a class="btn btn-outline-light" href="{{ route('new_login_page') }}">Entrar</a>
            <a class="btn btn-primary" href="{{ route('new_cadastro_page') }}">Cadastrar</a>
        </div>
    </div>
</nav>

<section class="landing-hero">
    <div class="container px-4 px-lg-5">
        <div class="row align-items-center gy-5">
            <div class="col-lg-5">
                <h1 class="display-5 mb-3">
                    Encontre potenciais investidores &amp; oportunidades de investimento em startups angolanas
                </h1>
                <p class="lead mb-4">Plataforma de equity-crowdfunding</p>
                <a href="{{ route('new_cadastro_page') }}" class="btn btn-primary btn-lg">Começar agora</a>
            </div>
            <div class="col-lg-7">
                <img src="{{ asset('assets/img/3081627.jpg') }}" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h2 class="text-center fw-bold mb-5">startupInveste oferece</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-hover h-100 text-center p-4">
                    <img src="{{ asset('assets/img/investment-model-svgrepo-com.svg') }}" class="landing-feature-icon">
                    <p class="mb-0">Redução do risco de investimento através da colaboração com outros investidores</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover h-100 text-center p-4">
                    <img src="{{ asset('assets/img/startup-svgrepo-com.svg') }}" class="landing-feature-icon">
                    <p class="mb-0">Empresas angolanas inovadoras e com alto potencial de crescimento</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover h-100 text-center p-4">
                    <img src="{{ asset('assets/img/team-svgrepo-com.svg') }}" class="landing-feature-icon">
                    <p class="mb-0">Possibilidade de ser accionista de empresas com potencial de transformar seus mercados</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover h-100 text-center p-4">
                    <img src="{{ asset('assets/img/money-svgrepo-com.svg') }}" class="landing-feature-icon">
                    <p class="mb-0">Captação de investimento financeiro</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover h-100 text-center p-4">
                    <img src="{{ asset('assets/img/team-svgrepo-com.svg') }}" class="landing-feature-icon">
                    <p class="mb-0">Possibilidade de escolher parceiros para a jornada empreendedora</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white-50 py-3">
    <div class="container px-4 px-lg-5">
        <p class="mb-0 small">2026 &copy; STARTUPINVEST - Todos os direitos reservados.</p>
    </div>
</footer>
@endsection
