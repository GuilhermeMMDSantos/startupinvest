@php
    $img = null;
    $tipoUser = Auth::user()->tipo;
    if ($tipoUser == 'startup') {
        $img = Auth::user()->startup->logotipo;
    } elseif ($tipoUser == 'investidor') {
        $img = Auth::user()->investidor->foto;
    }
    $code = Auth::user()->id;
@endphp

<header class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="header">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" id="logo" href="{{ url('stackholder_startup') }}">
            startup<strong>Investe</strong>
        </a>

        <nav class="d-none d-lg-flex align-items-center gap-4 me-4" id="headMenu">
            <a href="{{ route('rodadas.page') }}" class="nav-link text-white-50">
                <i class="fa fa-snowflake me-1"></i>Rodadas
            </a>

            @if (Auth::user()->tipo == 'investidor')
                <a href="{{ route('investidor.menu') }}" class="nav-link text-white-50">
                    <i class="fa fa-users me-1"></i>Investidores
                </a>
            @endif

            <a href="{{ route('startup.menu') }}" class="nav-link text-white-50">
                <i class="fa fa-rocket me-1"></i>Startups
            </a>
        </nav>

        <div data-react-component="HeaderStatus" data-react-props='@json([
                "code" => $code,
                "initialNotifications" => $qtdnotifications,
                "initialUnreadMessages" => $qtdMessageUnview,
                "profileUrl" => route("startup.perfil", Auth::user()->code_user),
                "profileLabel" => $tipoUser,
                "settingsUrl" => route("config_privacidade"),
                "logoutUrl" => url("userout"),
                "avatarUrl" => asset("storage/" . $img),
                "notificationsUrl" => route("notificacao.menu"),
                "messagesUrl" => route("mensagens.menu"),
            ])'></div>
    </div>
</header>

<div style="height: 84px;"></div>
