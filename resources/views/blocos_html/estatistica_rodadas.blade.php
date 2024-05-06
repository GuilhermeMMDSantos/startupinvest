<div class="row mb-3">
<div class="col-12 col-sm-4">
    <div class="card h-100">
        <div class="card-body">
            <h5>Total Rodadas</h5>
            <h6>{{$qtdRodadas}}</h6>
        </div>
    </div>
</div>

<div class="col-12 col-sm-4">
    <div class="card h-100">
        <div class="card-body">
            <h5>Rodadas Sucedidas</h5>
            <h6>{{$qtdRodadasSucedidas}}</h6>
        </div>
    </div>
</div>

<div class="col-12 col-sm-4">
    <div class="card h-100">
        <div class="card-body">
            <h5>Rodadas Abertas</h5>
            <h6>{{$qtdRodadasAbertas}}</h6>
        </div>
    </div>
</div>

</div>

<div class="row">

<div class="col-12 col-sm-4">
    <div class="card h-100">
        <div class="card-body">
            <h5>Rodadas Fechadas</h5>
            <h6>{{$qtdRodadasFechadas}}</h6>
        </div>
    </div>
</div>

<div class="col-12 col-sm-4">
    <div class="card h-100">
        <div class="card-body">
            <h5>Rodadas Canceladas</h5>
            <h6>{{$qtdRodadasAnuladas}}</h6>
        </div>
    </div>
</div>

<div class="col-12 col-sm-4">
    <div class="card h-100">
        <div class="card-body">
            <h5>Total de valor @if($tipoUser == 'investidor') investido @else Captado @endif</h5>
            <h6>{{number_format($totalValorInvestidoOuCaptado,2,',','.')}} AOA</h6>
        </div>
    </div>
</div>
</div>