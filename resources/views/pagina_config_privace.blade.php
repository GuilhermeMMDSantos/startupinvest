@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/pagina_config_privace.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:50px;">

    <h2 class="mb-4" id="title-page">Configurações</h2>
    <h6>Alterar senha</h6>
    @if (session('success'))
    <script>
        Swal.fire({
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif
    <div class="container-form">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('user_change_password')}}">
                @csrf
                    <div class="form-group">
                        <label for="senha-atual">Senha atual</label>
                        <input type="password" class="form-control  @error('senha_atual') is-invalid @enderror" id="senha-atual" name="senha_atual" placeholder="********" autocomplete="off">
                        @error('senha_atual')
                        <span style="margin-top:1px;font-size: .875em;color: #dc3545;display:block;">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nova-senha">Nova senha</label>
                        <input type="password" class="form-control @error('nova_senha') is-invalid @enderror" id="nova-senha" name="nova_senha" placeholder="********" autocomplete="off">
                        @error('nova_senha')
                        <span style="margin-top:1px;font-size: .875em;color: #dc3545;display:block;">{{$message}}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Alterar</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts_base_inicio')
<script src="{{asset('assets/js/pagina_config_privace.js')}}">
</script>
@endsection