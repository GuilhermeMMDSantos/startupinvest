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
<div id="form-container" class="w-100">

    <div class="card">
        <div class="card-header">
            <h4>Entrar</h4>
        </div>
        <div class="card-body">
            @if(!empty(Session::get('error')))

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                
                {{Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif
            <form method="POST" action="{{route('user.login')}}" id="form-login">
                @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email_login" placeholder="Email" autocomplete="off" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div id="label-password">
                            <label>Password</label>
                            <a href="#">
                                Esqueci a senha!
                            </a>
                        </div>
                        <input type="password" class="form-control" name="password_login" placeholder="Senha" autocomplete="off" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button id="btn-entrar" type="submit" class="btn btn-lg btn-block">
                            Entrar
                        </button>
                    </div>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection