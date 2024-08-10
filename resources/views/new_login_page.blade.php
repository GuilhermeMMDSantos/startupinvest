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
    <h2 id="header-card">Entrar</h2>
    <div class="card">

        <div class="card-body">

            <form method="POST" action="{{route('user.login')}}" id="form-login">
                @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email_login') is-invalid @enderror" name="email_login" value="{{old('email_login')}}" id="email-login" placeholder="startupinvest@hotmail.com" autocomplete="off">
                        @error('email_login')
                        <span style="margin-top:1px;font-size: .875em;color: #dc3545;display:block;" id="alert-login-email" class="alert-login">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div id="label-password">
                            <label>Palavra-passe</label>
                        </div>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password_login') is-invalid @enderror" id="password-login" name="password_login" value="{{old('password_login')}}" placeholder="*******" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text" role="button" id="show-password" style="background-color:#e9ecef5c"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        @error('password_login')
                        <span style="margin-top:1px;font-size: .875em;color: #dc3545;display:block;" id="alert-login-password" class="alert-login">{{$message}}</span>
                        @enderror
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
        $("#show-password").click(function() {
            console.log("clicou");
            if ($("#password-login").attr('type') == 'password') {
                $("#password-login").attr('type', 'text');
                $("#show-password i").attr('class', 'fa fa-eye');
            } else {
                $("#password-login").attr('type', 'password');
                $("#show-password i").attr('class', 'fa fa-eye-slash');
            }
        });

        $("#form-login").submit(function() {
            $("#btn-spinner-user").css({
                'opacity': 1
            });
            return true;
        });
    });
</script>
@endsection