@extends('inicio_base')

@section('contentBody_base_inicio')
<div class="container py-4" style="max-width: 560px;">
    <h2 class="fw-bold mb-4">Configurações</h2>

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

    <div class="card">
        <div class="card-body p-4">
            <h6 class="mb-3">Alterar senha</h6>
            <form method="POST" action="{{ route('user_change_password') }}">
                @csrf
                <div class="mb-3">
                    <label for="senha-atual" class="form-label">Senha atual</label>
                    <input type="password" class="form-control @error('senha_atual') is-invalid @enderror" id="senha-atual" name="senha_atual" placeholder="********" autocomplete="off">
                    @error('senha_atual')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nova-senha" class="form-label">Nova senha</label>
                    <input type="password" class="form-control @error('nova_senha') is-invalid @enderror" id="nova-senha" name="nova_senha" placeholder="********" autocomplete="off">
                    @error('nova_senha')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Alterar</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts_base_inicio')
<script src="{{ asset('assets/js/pagina_config_privace.js') }}"></script>
@endsection
