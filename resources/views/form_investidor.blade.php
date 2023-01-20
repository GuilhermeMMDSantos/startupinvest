@if($errors->any())

<div class="alert alert-danger alert-dismissible fade show" id="container-alert-form-investidor" role="alert">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

<form method="POST" action="{{route('cadastro.investidor')}}" enctype="multipart/form-data" class="formInvestidor" id="formInvestidor">
    @csrf

    <div class="row  mb-3">
        <div class="col-12">
            <label for="tipo-investidor-fisico">Pessoa física</label> <input type="radio" value="1" name="tipo_investidor" id="tipo-investidor-fisico" checked>
            <label for="tipo-investidor-juridico" class="ml-4">Pessoa Jurídica</label> <input type="radio" value="2" name="tipo_investidor" id="tipo-investidor-juridico">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-lg-6">
            <label for="nome-legal-investidor" class="label_inv">Nome <span id="complemento-nome">legal</span> </label>
            <input type="text" name="nome_legal_investidor" class=" form-control" id="nome-legal-investidor" required />
        </div>
        <div class="col-12 col-lg-6">
            <label for="email-investidor" class="label_inv">Email</label>
            <input type="email" name="email_investidor" class="form-control" id="email-investidor" autocomplete="off" required>
        </div>
    </div>

    <div class="row  mb-3" id="container-input-nif-investor">
        <div class="col-12">
             <label for="nif-investidor-juridico">NIF da entidade jurídica</label>
             <input class="form-control" type="text"  id="nif-investidor-juridico" name="nif_investidor_juridico">
        </div>
    </div>

    <div class="row  mb-3">
        <div class="col-12">
            <!--<div class="jumbotron" style="padding-left: 1rem;padding-right: 1rem;padding-top: 0.5rem;padding-bottom: 0.5rem;font-size: 15px;color: #212529cf;">
                                        <span>Somente Pessoa fisica ou jurídica que tenha sido fundador/investidor(Já antes empreendeu-investiu, trazem algum know how tal alem de dinheiro) de alguma empresa</span>
                                    </div>-->
            <label for="contrato-sociedade">
                Contrato de sociedade (PDF) de uma das empresas investidas com antiguidade máxima de 3 (três) anos
                <!--(Tempo médio para as empresa se estabelecerem)-->
            </label><input class="form-control" type="file" id="contrato-sociedade" accept=".pdf" name="contrato_sociedade" required>

        </div>
    </div>


    <div class="row">
        <div class="col-12 text-right">
            <button id="btn-cadastrar" type="submit" class="btn btn-lg btn-block">Cadastrar</button>
        </div>
    </div>

</form>