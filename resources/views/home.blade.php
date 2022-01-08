@extends('layout')

@section('stylesheets')
<link rel="stylesheet" type="text/css" href="assets/css/home.css" />
@endsection

@section('contentBody')
<div class="container-fluid" id="page">

    <header class="row" id="header">
        <div class=" col-sm-5 headerCol1">
            <h1>ecoStartup</h1>
        </div>
        <div class=" col-sm headerCol2">
            <form method="POST" action="{{route('user.login')}}" style="float:right;">
                @csrf
                <input type="email" name="email_login" placeholder="Email" autocomplete="off" required>
                <input type="password" name="password_login" placeholder="Senha" autocomplete="off" required>
                <button type="submit" class="btnEntrar btn-click-efect">
                    Entrar
                </button>
                <a href="#">
                    Esqueci a senha!
                </a>
            </form>
        </div>
    </header>

    @if($errors->any())
    <div class=" row alert alert-danger" id="div_message_error">
        <div class="col-sm-12">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </div>
    </div>
    @endif
    @if(!empty(Session::get('error')))
    <div class="row alert alert-danger" id="div_message_error">
        <div class="col-sm-12">
            <li>{{Session::get('error')}}</li>
        </div>
    </div>
    @endif

    <section class="row" id="content">

        <div class="col-sm contentCol1">
            <p class="dizeres">
                Encontre<br>
                Potenciais investidores<br>
                & Oportunidades de<br>
                investimento em startups angolanas
            </p>
        </div>

        <div class=" col-sm-5 contentCol2">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="contentCol2-header">Faça parte</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="contentCol2-escolheUser">
                        <form>
                            <select class="form-control">
                                <option @if(old('user')=='empreendedor' ) value="Empreendedor" selected @endif>Empreendedor</option>
                                <option @if(old('user')=='investidor' ) value="Investidor" selected @endif>Investidor</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <div class="forms">
                        <form method="POST" action="{{route('cadastro.startup')}}" enctype="multipart/form-data" class="formEmpreendedor formShow" id="form_startup">
                            @csrf
                            <div class="row row-cols-1 row-cols-dm-1 row-cols-lg-2 ">
                                <div class="col">
                                    <label for="nome_emp" class="label_emp">Nome startup</label>
                                    <input class="form-control" type="text" name="nome" placeholder="ecostartup" class="typeNormal" id="nome_emp" value="{{old('nome')}}" autocomplete="off" required>

                                </div>
                                <div class="col">
                                    <label for="email_emp" class="label_emp">Email</label>
                                    <input class="form-control" type="email" name="email" placeholder="nome@provedor.tipo" class="typeNormal" id="email_emp" value="{{old('email')}}" autocomplete="off" required>

                                </div>
                            </div>

                            <div class="row row-cols-1 row-cols-dm-1 row-cols-lg-2 ">
                                <div class="col">
                                    <label for="sectores" class="label_emp">Sector de actividade</label>
                                    <select class="form-control" name="sector" id="sectores" required>
                                        @foreach($setores as $setor)
                                        <option value="{{$setor->id}}" @if(old('fase')==$setor->id) selected @endif>{{$setor->nome}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col">
                                    <label for="fases" class="label_emp">Fase de Desenvolvimento</label>
                                    <select class="form-control" name="fase" id="fases" required>
                                        @foreach($fases as $fase)
                                        <option value="{{$fase->id}}" @if(old('fase')==$fase->id) selected @endif>{{$fase->nome}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="row busnessType">
                                <div class="col-12">
                                    <label class="label_emp">Tipo de Negócio</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="busnessType1" name="busnessType" value="1" @if(old('busnessType')!=2 && old('busnessType')!=3) checked @endif>
                                        <label class="form-check-label" for="busnessType1">B2B</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="busnessType2" name="busnessType" value="2" @if(old('busnessType')==2) checked @endif>
                                        <label class="form-check-label" for="busnessType2">B2C</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="busnessType3" name="busnessType" value="3" @if(old('busnessType')==3) checked @endif>
                                        <label class="form-check-label" for="busnessType3">B2B2C</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="my-input-file-emp" class="label_emp">Comprovativo de registro da empresa</label>
                                    <div class="content-my-input-file-emp">
                                        <label for="my-input-file-emp" class="btn-select-file-emp">Selecionar</label>
                                        <div>
                                            <input class="form-control" type="text" placeholder="Nenhum arquivo selecionado" id="my-input-file-disabled-emp" disabled>
                                            <input type="file" id="my-input-file-emp" accept=".jpg,.png" name="comprovativo_registo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="pitch">
                                <label for="pitch_line1" class="label_emp">Pitch Elevator</label>
                                <p>A startup, está desenvolvendo </p>
                                <input type="text" id="pitch_line1" class="elevator" placeholder="qual é o produto/serviço? ex: software, serviço de..." name="pitch_line1" value="{{old('pitch_line1')}}" autocomplete='off' maxlength="51" required>
                                <p> para ajudar</p>
                                <input type="text" class="elevator" placeholder="qual é publico alvo?" name="pitch_line2" value="{{old('pitch_line2')}}" autocomplete='off' maxlength="55" required>
                                <p>a</p>
                                <input type="text" class="elevator" placeholder="ajuda a fazer o quê?" name="pitch_line3" value="{{old('pitch_line3')}}" autocomplete='off' maxlength="55" required>
                                <p> com </p>
                                <input type="text" class="elevator" placeholder="o que torna a tua solução única?" name="pitch_line4" value="{{old('pitch_line4')}}" autocomplete='off' maxlength="55" required>

                            </div>

                            <div class="content-btn-fazer-parte">
                                <input type="hidden" value="empreendedor" name="user">
                                <button type="submit" class="btnFazerParte btn-click-efect">Fazer Parte</button>
                            </div>
                        </form>



                        <form method="POST" action="{{route('cadastro.investidor')}}" enctype="multipart/form-data" class="formInvestidor" id="formInvestidor">
                            @csrf
                            <div class="tipo_investidor">
                                <label for="singular">Pessoa física</label> <input type="radio" value="2" name="tipo_investidor" id="singular" @if(old('tipo_investidor')!=1 ) checked @endif>
                                <label for="juridico">Pessoa Jurídica</label> <input type="radio" value="1" name="tipo_investidor" id="juridico" @if(old('tipo_investidor')==1 ) checked @endif>
                            </div>
                            <div>
                                <label for="nome1_inv" class="label_inv">Nome</label>
                                <input type="text" name="primeiro_nome" value="{{old('primeiro_nome')}}" placeholder="Emanuel" class=" form-control yesForStyle" id="nome1_inv" autocomplete="off" required />
                            </div>
                            <div id="divs_concorrentes">

                            </div>

                            <div>
                                <label for="nacionalidade_inv" class="label_inv">Nacionalidade</label>
                                <select class="form-control" id="nacionalidade_inv" name="nacionalidade_inv">
                                    @foreach($nacionalidades as $nacionalidade)
                                    <option value="{{$nacionalidade->id}}">{{$nacionalidade->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="email_inv" class="label_inv">Email</label>
                                <input type="email" placeholder="nome@provedor.tipo" name="email_investidor" value="{{old('email_investidor')}}" class="form-control yesForStyle" id="email_inv" autocomplete="off" required>

                            </div>


                            <div class="content-btn-fazer-parte">
                                <input type="hidden" id="input_hidden" value="investidor" name="user" old_value_sobrenome="{{old('segundo_nome')}}" old_value_nif="{{old('nif')}}">
                                <button type="submit" class="btnFazerParte">Fazer Parte</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>


    </section>

</div>

<footer>
    <p>2021©by guitoCode - Todos os direitos reservados.</p>
    <p><a href="#">Politica de Privacidade </a>. <a href="#">Termos de Uso </a>. <a href="#">Política de Cookies</a></p>
</footer>

@endsection
@section('scripts')
<script src="assets/js/script1.js"></script>

@endsection