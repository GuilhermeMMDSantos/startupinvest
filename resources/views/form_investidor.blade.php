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

            <!--<div class="row  mb-3">
                <div class="col-12">
                    <label for="tipo-investidor-fisico">Pessoa física</label> <input type="radio" value="1" name="tipo_investidor" id="tipo-investidor-fisico" @if(old('tipo_investidor')==false || old('tipo_investidor')==1 ) checked @endif>
                    <label for="tipo-investidor-juridico" class="ml-4">Pessoa Jurídica</label> <input type="radio" value="2" name="tipo_investidor" id="tipo-investidor-juridico" @if(old('tipo_investidor')==2 ) checked @endif>
                </div>
            </div>-->

            <div class="row mb-3">

                <div class="col-6">
                    <label for="nome-investidor" class="label_inv"><span id="nome-investidor-label"> Nome</span> </label>
                    <input type="text" name="nome" class=" form-control" value="{{old('nome')}}" id="nome-investidor" autocomplete="off" placeholder="Joel"/>
                </div>
                <div class="col-6">
                    <label for="sobrenome-investidor" class="label_inv"><span id="sobrenome-investidor-label"> Sobrenome</span> </label>
                    <input type="text" name="sobrenome" class=" form-control" value="{{old('sobrenome')}}" id="sobrenome-investidor" placeholder="Martins" autocomplete="off"/>
                </div>

            </div>



            <div class="row mb-3">

                <div class="col-12 col-lg-6">
                    <label for="bi-investidor" class="label_inv">Bilhete de Identidade - Frente e Verso(.PDF)</label>
                    <input type="file" accept=".pdf" name="bi_investidor" class="form-control" id="bi-investidor" autocomplete="off">
                </div>
                <div class="col-12 col-lg-6">
                    <label for="email-investidor" class="label_inv">Email</label>
                    <input type="email" name="email_investidor" value="{{old('email_investidor')}}" class="form-control" id="email-investidor" placeholder="joelmartins@hotmail.com" autocomplete="off">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="video-investor">Experiência e ciência sobre equity crowdfunding(.MP4, .MKV)</label>
                    <input class="form-control" type="file" accept=".MP4,.MKV" id="video-investor" name="video_investidor">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="lead">Submeta um vídeo onde respondes as seguintes questões:</p>
                            <p>Qual a Data de gravação do vídeo</p>
                            <p>Já administrou alguma empresa(nome e durante quanto tempo administrou)</p>
                            <p>Já fundou alguma empresa(nome e tempo de operação da empresa)</p>
                            <p>Já investiu alguma empresa</p>
                            <p>Como funciona o envestimento coletivo</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <button id="btn-cadastrar-investidor"  class="btn btn-lg btn-block">
                        <span class="spinner-border spinner-border-sm" id="btn-spinner-investidor" role="status" aria-hidden="true"></span>
                        <span> Cadastrar</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>