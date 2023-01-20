@if($errors->any())

<div class="alert alert-danger alert-dismissible fade show" id="container-alert-form-startup" role="alert">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

<form method="POST" action="{{route('cadastro.startup')}}" enctype="multipart/form-data" class="formEmpreendedor formShow" id="form_startup">
    @csrf
    <div class="row row-cols-1 row-cols-dm-1 row-cols-lg-2 mb-3">
        <div class="col">
            <label for="nome_emp" class="label_emp">Nome startup</label>
            <input class="form-control" type="text" name="nome" class="typeNormal" id="nome_emp" value=" " autocomplete="off" required>

        </div>
        <div class="col">
            <label for="email_emp" class="label_emp">Email</label>
            <input class="form-control" type="email" name="email" class="typeNormal" id="email_emp" value=" " autocomplete="off" required>

        </div>
    </div>

    <div class="row row-cols-1 row-cols-dm-1 row-cols-lg-2 mb-3">
        <div class="col">
            <label for="sectores" class="label_emp">Sector de actividade</label>
            <select class="form-control" name="sector" id="sectores" required>
                @foreach($setores as $setor)
                <option value="{{$setor->id}}">{{$setor->nome}}</option>
                @endforeach
            </select>

        </div>
        <div class="col">
            <label for="fases" class="label_emp">Fase de Desenvolvimento</label>
            <select class="form-control" name="fase" id="fases" required>
            @foreach($fases as $fase)
                <option value="{{$fase->id}}">{{$fase->nome}}</option>
                @endforeach
            </select>

        </div>
    </div>


    <div class="row mb-3">
        <div class="col-12">
            <label>A startup, está desenvolvendo</label>
            <input type="text" class="form-control" placeholder="qual é o produto/serviço? ex: software, serviço de..." name="pitch_line1" autocomplete='off' maxlength="55" required>
        </div>
        <div class="col-12">
            <label>para ajudar</label>
            <input type="text" class="form-control" placeholder="qual é publico alvo?" name="pitch_line2" autocomplete='off' maxlength="55" required>

        </div>
        <div class="col-12">
            <label>a</label>
            <input type="text" class="form-control" placeholder="ajuda a fazer o quê?" name="pitch_line3" autocomplete='off' maxlength="55" required>

        </div>
        <div class="col-12">
            <label>com</label>
            <input type="text" class="form-control" placeholder="o que torna a tua solução única?" name="pitch_line4" autocomplete='off' maxlength="55" required>

        </div>


    </div>


    <div class="row mb-3">
        <div class="col-12">
            <label class="label_emp">Nome Aceleradora/Incubadora</label>
            <input type="text" id="nome-incubadora-aceleradora" name="nome_incubadora_aceleradora" class="form-control" autocomplete="off" required>
        </div>
    </div>


    <div class="row mb-3">

        <div class="col-sm-12">
            <label for="nif-incubadora-aceleradora" class="label_emp">NIF Aceleradora/Incubadora</label>
            <input class="form-control" type="number" name="nif_incubadora_aceleradora" id="nif-incubadora-aceleradora" autocomplete="off" required>

        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="my-input-file-emp" class="label_emp">Contrato Startup e Aceleradora/Incubadora (PDF)</label>
            <input type="file" class="form-control" id="my-input-file-emp" accept=".pdf" name="contrato_aceleracao_incubacao" required>

        </div>
    </div>

    <div class="row">
        <div class="col-12 text-right">
            <button id="btn-cadastrar" type="submit" class="btn btn-lg btn-block">Cadastrar</button>
        </div>
    </div>

</form>