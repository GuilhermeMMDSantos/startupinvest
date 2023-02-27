 <li @if($message->fk_remetente == Auth::user()->id)class="me" @else class="you" @endif>
     <div class="entete">
         @if($message->fk_remetente == Auth::user()->id)
         <h3>10:12AM, Today</h3>
         <h2>Eu</h2>
         @else
         <h2>{{$message->remetente->tipo}}</h2>
         <h3>10:12AM, Today</h3>
         @endif

     </div>
     @if($message->fk_remetente != Auth::user()->id) <div class="triangle"></div>@endif
     <div class="message">
         {{$message->conteudo}}
     </div>
 </li>