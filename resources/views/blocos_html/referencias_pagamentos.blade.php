@forelse($pagamentos as $referenciaPagamento)
@php
$sobreNome = ($referenciaPagamento->investidor->nif != null)?'':' '.$referenciaPagamento->investidor->sobrenome;
$nome = $referenciaPagamento->investidor->nome.''.$sobreNome;
@endphp
<tr>
    <td>{{$referenciaPagamento->referencia}}</td>
    <td>{{$nome}}</td>
    <td>{{$referenciaPagamento->valor_monetario}}</td>
    <td>{{$referenciaPagamento->status}}</td>
    <td>
        @if($referenciaPagamento->status == 'confirme')
        <button type="button" class="btn btn-primary" id="btn-confirmar-pagamento" ref="{{$referenciaPagamento->paymentId}}">Confirmar</button>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5">
        <div class="jumbotron jumbotron-fluid">
            <div class="container" style="text-align: center;">
                <h1 class="display-4">Nenhuma referência gerada</h1>
                <p class="lead">Ninguem interessou-se em investir em startup alguma!!!</p>
            </div>
        </div>
    </td>
</tr>
@endforelse