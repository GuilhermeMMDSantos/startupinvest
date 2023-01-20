@extends('layout')

@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/new_home.css')}}">

@endsection

@section('contentBody')
<div id="header" class="w-100">
    <div class="container-fluid">

        <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
            <h1 id="logo"><a href="{{route('new_home_page')}}">startup<strong style="color:white !important;">Investe</strong></a></h1>

            <div class=" flex-grow-0" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('new_login_page')}}">Entrar</a>
                    </li>
                    <li class="nav-item ml-4">
                        <a class="nav-link " href="{{route('new_cadastro_page')}}">Cadastrar</a>
                    </li>
                </ul>
            </div>
        </nav>


    </div>
</div>

<div id="slide" class="w-100 mb-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 align-self-center">
                <h1 style="font-size:30px;" class="mb-4">
                    Encontre
                    potenciais investidores
                    & oportunidades de
                    investimento em startups angolanas
                </h1>
                <p style="font-size:20px;">Plataforma de equity-crowdfunding</p>
            </div>
            <div class="col-md-8 align-self-center text-center">
                <img src="{{asset('assets/img/3081627.jpg')}}" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div id="why-crowdfunding-content">
    <div class="container-fluid">
        <h1 class="mb-5 text-center">ecoStartup oferece</h1>
        <div class="row">
            <div class="col-md-4 align-self-center">
                <figure>
                    <img class="img-fluid" src="{{asset('assets/img/startup-svgrepo-com.svg')}}">
                </figure>
                <p>Empresas angolanas inovadoras e com alto potencial de crescimento</p>
            </div>
            <div class="col-md-4 align-self-center">
                <figure>
                    <img class="img-fluid" src="{{asset('assets/img/hand-holding-money-bills-svgrepo-com.svg')}}">
                </figure>
                <p>Potencias investidores com experiência em empreendedorismo e investimento</p>
            </div>

            <div class="col-md-4 align-self-center">
                <figure>
                    <img class="img-fluid" src="{{asset('assets/img/investment-model-svgrepo-com.svg')}}">
                </figure>
                <p>Redução do risco de investimento através da colaboração com outros investidores</p>
            </div>
            <div class="col-md-4 align-self-center">
                <figure>
                    <img class="img-fluid" src="{{asset('assets/img/team-svgrepo-com.svg')}}">
                </figure>
                <p>Possibilidade de ser accionista de empresas com potencial de tranformar seus mercados</p>
            </div>
            <div class="col-md-4 align-self-center">
                <figure>
                    <img class="img-fluid" src="{{asset('assets/img/money-svgrepo-com.svg')}}">
                </figure>
                <p>Captação de investimento</p>
            </div>
        </div>
    </div>
</div>

<div id="footer">
    <div class="container-fluid">
    </div>
</div>

@endsection

@section('scripts')
@endsection