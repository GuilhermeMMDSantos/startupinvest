<div class="card formEmpreendedor formShow" id="card-form-startup" @if(session("tipo")==false || session("tipo")=='startup' ) style="display:block;" @endif>
    <div class="card-body">

    

        <form method="POST" action="{{route('cadastro.startup')}}" enctype="multipart/form-data" id="form-startup">
            @csrf
            <div class="row row-cols-1 row-cols-dm-1 row-cols-lg-2 mb-3">
                <div class="col">
                    <label for="nome_emp" class="label_emp">Nome startup</label>
                    <input class="form-control" type="text" name="nome" class="typeNormal" id="nome_emp" placeholder="ecostartup" value="{{old('nome')}}" autocomplete="off">

                </div>
                <div class="col">
                    <label for="nif_emp" class="label_emp">NIF da Startup(.PDF)</label>
                    <input class="form-control" type="file" name="nif" accept=".pdf" placeholder="12009384200LA098" class="typeNormal" id="nif_emp" autocomplete="off">

                </div>
            </div>

            <div class="row row-cols-1 row-cols-dm-1 row-cols-lg-2 mb-3">
                <div class="col">


                    <label for="email_emp" class="label_emp">Email</label>
                    <input class="form-control" type="email" name="email" class="typeNormal" id="email_emp" value=" {{old('email')}}" placeholder="ecostartup@hotmail.com" autocomplete="off">

                </div>
                <div class="col">
                    <label for="sectores" class="label_emp">Sector de actividade</label>
                    <select class="form-control selectpicker" name="sector" id="sectores" data-size="5" data-live-search="true">
                        @foreach($setores as $setor)
                        <option value="{{$setor->id}}" @if(old('sector')==$setor->id) selected @endif>{{$setor->nome}}</option>
                        @endforeach 
                    </select>

                </div>

            </div>

            <div class="row row-cols-1 row-cols-dm-1 row-cols-lg-2 mb-3">
                <div class="col">
                    <label for="fase-desenvolvimento" class="label_emp">Fase Desenvolvimento</label>
                    <select class="form-control" name="fase" id="fase-desenvolvimento">
                        @foreach($fases as $fase)
                        <option value="{{$fase->id}}" @if(old('fase')==$fase->id) selected @endif>{{$fase->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="mvp" class="label_emp" >Apresentação do MVP (Video - <span id="mvp-label-tamanho">max.64MB</span>)</label>
                    <input class="form-control" accept=".MP4,.MKV" type="file" id="mvp" name="mvp">
                </div>
            </div>




            <div class="row mb-3">
                <div class="col-12">
                    <label>A startup, está desenvolvendo</label>
                    <input type="text" class="form-control" placeholder="qual é o produto/serviço? ex: software, serviço de..." name="pitch_line1" value="{{old('pitch_line1')}}" autocomplete='off' maxlength="55">
                </div>
                <div class="col-12">
                    <label>para ajudar</label>
                    <input type="text" class="form-control" placeholder="qual é publico alvo?" name="pitch_line2" value="{{old('pitch_line2')}}" autocomplete='off' maxlength="55">

                </div>
                <div class="col-12">
                    <label>a</label>
                    <input type="text" class="form-control" placeholder="ajuda a fazer o quê?" name="pitch_line3" value="{{old('pitch_line3')}}" autocomplete='off' maxlength="55">

                </div>
                <div class="col-12">
                    <label>com</label>
                    <input type="text" class="form-control" placeholder="o que torna a tua solução única?" name="pitch_line4" value="{{old('pitch_line4')}}" autocomplete='off' maxlength="55">

                </div>


            </div>




            <div class="row">
                <div class="col-12 text-right">
                    <button id="btn-cadastrar-startup" type="submit" class="btn btn-lg btn-block">
                        <span class="spinner-border spinner-border-sm" id="btn-spinner-startup" role="status" aria-hidden="true"></span>
                        <span>Cadastrar</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>