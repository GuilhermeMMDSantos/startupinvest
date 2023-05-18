<div id="popup-chat">
	<div id="header-popup-chat">
		<h6>MeetingChat</h6>
		<h6 id="btn-close-chatmeeting"><i class="fa fa-envelope"></i></h6>
	</div>
	<div id="popup-chat-body">


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



		<div style="padding:10px;border-top:2px solid green;">
			<textarea class="form-control" id="textarea" placeholder="Escreva uma mensagem"></textarea>
			@if($userDestinatario->tipo == 'startup')
			<button type="button" class="btn btn-primary btn-sm" id="btn-enviar-popup-chat">Enviar</button>
			@else
			<button type="button" class="btn btn-primary btn-sm" id="btn-enviar-popup-chat-investor">Enviar</button>
			@endif
		</div>

	</div>

</div>