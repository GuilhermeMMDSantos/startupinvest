<header class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="header">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('admin.stackholders') }}">
            startup<strong>Investe</strong>-Adm
        </a>

        <nav class="d-none d-lg-flex align-items-center gap-4">
            <a href="{{ route('admin.stackholders') }}" class="nav-link text-white-50">
                <i class="fa fa-bell me-1"></i>Stackholders
            </a>
            <a href="{{ route('rodadas.page.admin') }}" class="nav-link text-white-50">
                <i class="fa fa-snowflake me-1"></i>Rodadas
            </a>
            <a id="btn_sair" href="{{ url('userout') }}" class="nav-link text-warning">Sair</a>
        </nav>
    </div>
</header>

<div style="height: 84px;"></div>
