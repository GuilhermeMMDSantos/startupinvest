@if(count($rodadas) > 0)
<table class="table">
    <thead>

        <tr class="no-mobile-table-rodadas">
            <th scope="col">Rodada ID</th>
            @if($tipoUser != 'startup')<th scope="col">Startup</th>@endif
            <th scope="col">Valor Captado</th>
            <th scope="col">Data inicio</th>
            <th scope="col">Data Fim</th>
            <th scope="col">Status</th>
            <th scope="col">Acção</th>
        </tr>

        <tr class="mobile-table-rodadas">
            <th>Rodadas</th>
        </tr>

    </thead>
    <tbody>
        @foreach($rodadas as $rodada)
        <tr class="no-mobile-table-rodadas">
            <td>{{$rodada->id}}</td>
            @if($tipoUser != 'startup')<td>{{$rodada->startup->nome}}</td>@endif
            <td>{{number_format($rodada->valor_obtido,2,',','.')}} AOA</td>
            <td>{{$rodada->data_inicio}}</td>
            <td>@if($rodada->estado == 'aberta') - @else {{$rodada->data_fim}} @endif</td>
            <td>{{$rodada->estado}}</td>
            <td><a href="{{route('rodada.page',$rodada->id)}}" rule="button" class="btn btn-outline-primary" style="height:33px;font-size:14px;border-radius: 30px">Visualizar</a></td>
        </tr>
        <tr class="mobile-table-rodadas" style="font-size:12px;">
            <td>
                Ref:{{$rodada->id}}; @if($tipoUser != 'startup') startup: {{$rodada->startup->nome}} @endif<br>
                valor obtido: {{number_format($rodada->valor_obtido,2,',','.')}} AOA<br>
                incio:{{$rodada->data_inicio}}; fim:@if($rodada->estado == 'aberta') - @else {{$rodada->data_fim}} @endif<br>
                estado: {{$rodada->estado}}<br>
                <div class="d-flex justify-content-end">
                    <a href="{{route('rodada.page',$rodada->id)}}" rule="button" class="btn btn-outline-primary" style="height:33px;font-size:14px;border-radius: 30px">Visualizar</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div id="pagination">
    {{ $rodadas->links() }}
</div>

@else
<div class="d-flex align-items-center justify-content-center" style="min-height:200px;">
    <h2>Nenhuma Rodada</h2>
</div>
@endif