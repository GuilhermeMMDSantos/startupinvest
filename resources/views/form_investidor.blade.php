<div class="card formInvestidor" id="card-form-investidor" @if(session("tipo")=='investidor' ) style="display:block;" @endif>
    <div class="card-body">
       


        <form method="POST" action="{{route('cadastro.investidor')}}" enctype="multipart/form-data" id="form-investidor">
            @csrf

            <div class="row mb-3">

                <div class="col-12">
                    <label for="nome-completo-investidor" class="label_inv"><span id="nome-completo-investidor-label"> Nome Completo</span> </label>
                    <input type="text" name="nome_completo" class=" form-control" value="{{old('nome_completo')}}" id="nome-completo-investidor" autocomplete="off" placeholder="Joel" />
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
                    <label for="video-investor">Experiência e ciência sobre equity crowdfunding (Video - <span id="video-investor-label-tamanho">max.64MB</span>)</label>
              <input class="form-control" type="file" accept=".MP4,.MKV" id="video-investor" name="video_investidor" >

                    <div class="bg-light rounded-3 p-3 mt-3">
                            <p class="fw-bold">Submeta um vídeo onde respondes as seguintes questões:</p>
                            <p>Qual a Data de gravação do vídeo</p>
                            <p>Já administrou alguma empresa(nome e durante quanto tempo administrou)</p>
                            <p>Já fundou alguma empresa(nome e tempo de operação da empresa)</p>
                            <p>Já investiu alguma empresa</p>
                            <p>Como funciona o envestimento coletivo</p>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button id="btn-cadastrar-investidor" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                        <span class="spinner-border spinner-border-sm d-none" id="btn-spinner-investidor" role="status" aria-hidden="true"></span>
                        <span>Cadastrar</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>