<div class="card formInvestidor" id="card-form-investidor" @if(session("tipo")=='investidor' ) style="display:block;" @endif>
    <div class="card-body">
        @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show" id="container-alert-form-investidor" role="alert">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
            @if(old('tipo_investidor') == 1)
            <p>Volte a informar o 'Bilhete de Identidade(.PDF)' e o 'Porquê quero investir(.MP4, .MKV)', por favor!</p>
            @elseif(old('tipo_investidor') == 2)
            <p>Volte a informar o 'NIF da entidade jurídica(.PDF)' e o 'Porquê quero investir(.MP4, .MKV)', por favor!</p>
            @endif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @endif

        <form method="POST" action="{{route('cadastro.investidor')}}" enctype="multipart/form-data" id="form-investidor">
            @csrf

            <div class="row  mb-3">
                <div class="col-12">
                    <label for="tipo-investidor-fisico">Pessoa física</label> <input type="radio" value="1" name="tipo_investidor" id="tipo-investidor-fisico" @if(old('tipo_investidor')==false || old('tipo_investidor')==1 ) checked @endif>
                    <label for="tipo-investidor-juridico" class="ml-4">Pessoa Jurídica</label> <input type="radio" value="2" name="tipo_investidor" id="tipo-investidor-juridico" @if(old('tipo_investidor')==2 ) checked @endif>
                </div>
            </div>

            <div class="row mb-3" >

                <div class="col-12">
                    <label for="nome-legal-investidor" class="label_inv"><span id="nome-completo-id" @if(old('tipo_investidor') == 1 || old('tipo_investidor') == false) style="display:block;" @endif> Nome Completo</span>  <span id="nome-legal-id" @if(old('tipo_investidor') == 2) style="display:block;" @endif>Nome Legal</span> </label>
                    <input type="text" name="nome_legal_investidor" class=" form-control" value="{{old('nome_legal_investidor')}}" id="nome-legal-investidor" required/>
                </div>

            </div>



            <div class="row mb-3">

                <div class="col-12 col-lg-6 field-for-pessoa-juridica" @if(old('tipo_investidor')==2 ) style="display:block;" @endif>
                    <label for="nif-investidor-juridico">NIF da entidade jurídica(.PDF)</label>
                    <input class="form-control" type="file" id="nif-investidor-juridico" name="nif_investidor_juridico">
                </div>

                <div class="col-12 col-lg-6 field-for-pessoa-fisica" @if(old('tipo_investidor')==false || old('tipo_investidor')==1 ) style="display:block;" @endif>
                    <label for="bi-investidor" class="label_inv">Bilhete de Identidade(.PDF)</label>
                    <input type="file" name="bi_investidor" class="form-control" id="bi-investidor" autocomplete="off" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label for="email-investidor" class="label_inv">Email</label>
                    <input type="email" name="email_investidor" value="{{old('email_investidor')}}" class="form-control" id="email-investidor" autocomplete="off" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-lg-6 ">
                    <label for="video-investor">Porquê quero investir(.MP4, .MKV)</label>
                    <input class="form-control" type="file" id="video-investor" name="video_investor">
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <button id="btn-cadastrar" type="submit" class="btn btn-lg btn-block">Cadastrar</button>
                </div>
            </div>

        </form>
    </div>
</div>