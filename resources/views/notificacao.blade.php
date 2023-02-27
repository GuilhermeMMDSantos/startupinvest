@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/notificao.css')}}" />
@endsection

@section('contentBody_base_inicio')
<h2 class="title-notifications mb-4">Notificações</h2>
<ul class="list-group">
    @forelse($notificacoes as $notificacao)
    <li class="list-group-item" @if($notificacao->status != 'clicado') style="background:#007bff1a;" @endif>
        <a href="{{route('showownernotification',$notificacao->id)}}">

            <div class="profile-notification">
                <img src="{{asset('assets/img/investment-model-svgrepo-com.svg')}}">
            </div>
            <div>
                <ul style="list-style:none;">
                    <li style="border:none;">{{$notificacao->message}}</li>
                    <li style="font-size:14px;color:#343a40b8;border:none;">{{$notificacao->data}}</li>
                </ul>
            </div>


        </a>
    </li>
    @empty
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>Ainda não possui nenhuma notificação!</span>
    </li>
    @endforelse
</ul>

@endsection



@section('scripts_base_inicio')
@endsection