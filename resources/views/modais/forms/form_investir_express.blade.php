<form enctype="multipart/form-data" id="form-investir-express" class="mb-4">
    @csrf
    <div class="row">

        <div class="col-12" style="padding-top:10px;">
            <label for="numero-telefone">Telefone associado ao express</label>
            <input class="form-control" type="number" id="numero-telefone" name="numero_telefone" placeholder="não podes investir um montante que faça restar menos que o valor mínimo  ">
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="padding-top:10px;">
            <label for="valor-a-investir">montante a Investir(AOA)</label>
            <input type="number" class="form-control" name="valor_a_investir" id="valor-a-investir" value="{{$rodada->valor_minimo_investimento}}" min="{{$rodada->valor_minimo_investimento}}" step="{{$rodada->valor_minimo_investimento}}" max="{{$rodada->valor_objetivo - $rodada->valor_obtido}}">
            <p><span class="badge badge-primary">valor mínimo:{{$rodada->valor_minimo_investimento}}AOA</span>&nbsp;<span class="badge badge-secondary">Valor máximo: {{$rodada->valor_objetivo - $rodada->valor_obtido}} AOA</span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="padding-top:10px;">
            <label for="porcentagem-por-valor">Porcentagem pelo montante</label>
            <input type="number" class="form-control" name="porcentagem_por_valor" id="porcentagem-por-valor" value="2" disabled>
        </div>
    </div>

</form>
<button type="button" class="btn btn-primary" id="btn-investir-express" >Investir</button>