<header style="border:1px solid #ccc;padding:7px 16px;">

    <div style="display:flex;">
        @php
        $nome = null;
        if($otherUser->tipo == 'startup')
        $nome = $otherUser->startup->nome;
        else
        $nome = $otherUser->investidor->nome.' '.$otherUser->investidor->sobrenome;
        @endphp
        <a rule="button" style="margin-right:30px;font-size:20px;display:none;" id="btn-back-to-meetings"><i class="fa fa-arrow-left"></i></a>
        <div style="display: inline-block;">
            <h6 style="margin-bottom: -2px;">{{$nome}}</h6>
            <span style="font-size:13px;">Ativo</span>
        </div>
    </div>
    
        <a href="{{route('startup.perfil',$otherUser->code_user)}}" style="font-size:20px;"><i class="fa fa-link"></i></a>
   

</header>
<section>
    <div id="message-sended" style="border-top:2px solid green;border-bottom:2px solid green;height:300px;">
        <ul id="chat">

            @foreach($mensagens as $message)
            <li @if($message->fk_remetente == Auth::user()->id)class="me" @else class="you" @endif>
                <div class="entete">
                    @if($message->fk_remetente == Auth::user()->id)
                    <h3>{{ \Carbon\Carbon::parse($message->created_at)->format('h:s')}}, {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y')}}</h3>
                    <h2>Eu</h2>
                    @else
                    <h2>{{$message->remetente->tipo}}</h2>
                    <h3>{{ \Carbon\Carbon::parse($message->created_at)->format('h:s')}}, {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y')}}</h3>
                    @endif

                </div>
                @if($message->fk_remetente != Auth::user()->id) <div class="triangle"></div>@endif
                <div class="message">
                    {{$message->conteudo}}
                </div>
            </li>
            @endforeach


        </ul>
    </div>
    <div id="form-to-message" style="padding-left:10px;padding-right:10px;">
        <textarea class="form-control" id="textarea" placeholder="Escreva uma mensagem"></textarea>
        <button type="button" class="btn btn-primary btn-sm" style="float:right;" id="btn-enviar-message">Enviar</button>
    </div>
</section>