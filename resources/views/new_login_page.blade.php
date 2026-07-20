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
    <h2 class="text-center fw-bold mb-4">Entrar</h2>

    <div class="card auth-card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('user.login') }}" id="form-login">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email_login') is-invalid @enderror" name="email_login" value="{{ old('email_login') }}" id="email-login" placeholder="startupinvest@hotmail.com" autocomplete="off">
                    @error('email_login')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Palavra-passe</label>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_login') is-invalid @enderror" id="password-login" name="password_login" value="{{ old('password_login') }}" placeholder="*******" autocomplete="off">
                        <span class="input-group-text" role="button" id="show-password">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('password_login')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button id="btn-entrar" type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                    <span class="spinner-border spinner-border-sm d-none" id="btn-spinner-user" role="status" aria-hidden="true"></span>
                    <span>Entrar</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function() {
        $("#show-password").click(function() {
            if ($("#password-login").attr('type') == 'password') {
                $("#password-login").attr('type', 'text');
                $("#show-password i").attr('class', 'fa fa-eye');
            } else {
                $("#password-login").attr('type', 'password');
                $("#show-password i").attr('class', 'fa fa-eye-slash');
            }
        });

        $("#form-login").submit(function() {
            $("#btn-spinner-user").removeClass('d-none');
        });
    });
</script>
@endsection
