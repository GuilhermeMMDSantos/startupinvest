<ul style="list-style:none;">
    @forelse($conversas as $conversa)
    <li style="border:1px solid #ccc;padding:6px;background: #f8f9fa;" role="button" class="btn-item-conversa" investidor="{{$conversa->fk_investidor}}">
        <div style="width:50px;height:50px;border:1px solid #ccc;border-radius:50%;margin:auto;display:inline-block;">
            <img src="{{asset('storage/'.$conversa->investidor->foto)}}" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
        </div>
        <h6 style="display:inline-block;">{{$conversa->investidor->nome}} @if($conversa->investidor->sobrenome != null) {{$conversa->investidor->sobrenome}} @endif </h6>
    </li>
    @empty
    <li style="border:1px solid #ccc;padding:6px;background: #f8f9fa;">Sem conversas</li>
    @endforelse

</ul>