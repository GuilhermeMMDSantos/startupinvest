@extends('layout')

@section('stylesheets')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/new_login_page.css')}}">
@endsection

@section('contentBody')
<div id="header" class="w-100">
    <div class="container-fluid">
        <h1 id="logo"><a href="{{route('new_home_page')}}">startup<strong style="color:white !important;">Investe</strong></a></h1>

    </div>
</div>
<div id="form-container" class="w-100" style="padding-top:40px;position:relative;">

    @if($errors->any())
    <div style="position:absolute;right:10px;top:10px;z-index:10;">
        @foreach ($errors->all() as $error)
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay=5000 data-animation=true style="z-index:10;background:#dc354554;width:250px;">
            <div class="toast-header">
                <i class="fa fa-bell rounded mr-2"></i>
                <strong class="mr-auto">Validação</strong>
                <small>...</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{ $error }}
            </div>
        </div>
        @endforeach

    </div>
    @elseif(!empty(Session::get('error')))
    <div style="position:absolute;right:10px;top:10px;z-index:10;">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay=5000 data-animation=true style="z-index:10;background:#dc354554;width:250px;">
            <div class="toast-header">
                <i class="fa fa-bell rounded mr-2"></i>
                <strong class="mr-auto">Validação</strong>
                <small>...</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{Session::get('error')}}
            </div>
        </div>
    </div>
    @endif


    <h2 id="header-card">Entrar</h2>
    <div class="card">

        <div class="card-body">

            <form method="POST" action="{{route('user.login')}}" id="form-login">
                @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email_login" placeholder="Email" autocomplete="off">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div id="label-password">
                            <label>Password</label>

                        </div>
                        <input type="password" class="form-control" name="password_login" placeholder="Senha" autocomplete="off">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button id="btn-entrar" type="submit" class="btn btn-lg btn-block">
                            <span class="spinner-border spinner-border-sm" id="btn-spinner-user" role="status" aria-hidden="true"></span>
                            <span> Entrar</span>
                        </button>
                    </div>
                </div>



            </form>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function() {
        $('.toast').toast('show');
        $("#btn-entrar").click(function() {
            $("#form-login").submit();
            $(this).prop("disabled", true);
            $("#btn-spinner-user").css({
                'opacity': 1
            });
            true;
        });
    });
</script>
@endsection