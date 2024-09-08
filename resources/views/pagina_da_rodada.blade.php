@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/pagina_da_rodada.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid" style="padding-left:6.5% !important;padding-right:6.5% !important; padding-bottom:50px;">



    <h2 class="mb-4" id="title-page" val="{{$rodada->id}}">Rodada <i style="font-size:20px;margin-right:2px;color:#818182;">•</i><span style="font-size:15px;font-weight:bold;color:#818182;"> {{$rodada->estado}}</span></h2>

    <div class="card" style="margin-bottom:15px;" id="intro-rodada">

        <div class="card-body row">
            <div class="col-sm-3 col-12">
                <h5>Rodada</h5>
                <h6>{{$rodada->id}}</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor objectivo</h5>
                <h6>{{number_format($rodada->valor_objetivo,2,',','.')}} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor Captado</h5>
                <h6>{{number_format($rodada->valor_obtido,2,',','.')}} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Participação Oferecida</h5>
                <h6>{{$rodada->oferta_acoes}}%</h6>
            </div>

        </div>
    </div>
    @if($investidor != NULL)
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-sm-6 col-12">
                        <p>
                            <span class="badge badge-primary">Startup</span>&nbsp;<a href="{{route('startup.perfil',$investidor->rodada->startup->user->code_user)}}" style="font-size:20px;">{{$investidor->rodada->startup->nome}}</a>

                        </p>
                        <p>
                            <span class="badge badge-primary">Aportado</span>&nbsp;<span style="font-size:20px;"> {{number_format($investidor->valor_investido,2,',','.')}} AOA</span>
                        </p>
                        <p>
                            <span class="badge badge-primary">Porcentagem</span>&nbsp;<span style="font-size:20px;"> {{$investidor->acoes_adquirida}}%</span>
                        </p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <p><span class="badge badge-primary">Situação</span></p>
                        <div id="investor-invest-situation-container">
                            @if($investidor->status_investimento == 0)
                            @if ($rodada->estado == 'fechada' && $presentUser==$investidor->investidor->fk_user)
                            @if($investidor->contrato_mutou == NULL)
                            <p> Contracto de Investimento Pendente.</p>
                            @else
                            <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                            </div>
                            <button>Visualizar Contrato</button><br>
                            @if($investidor->status_contrato_investidor != 3 && $investidor->status_contrato_investidor != 4)
                            <button>Discordar Contrato</button>
                            @endif
                            @if($investidor->status_contrato_investidor == 1)
                            <p>Assinatura do Investidor em Falta.</p>
                            <button>Assinar Contrato</button>
                            @elseif($investidor->status_contrato_investidor == 3)
                            <p>Descordou Com os Termos do Contrato</p>
                            <button>Abrir Meeting</button>
                            @elseif($investidor->status_contrato_investidor == 4)
                            <p>Assinado Pelo Investidor</p>
                            @endif
                            @if($investidor->status_contrato_startup == 1)
                            <p>Assinatura do Sócio Fundador em Falta</p>
                            @elseif($investidor->status_contrato_startup == 4)
                            <p>Assinado Pelo Sócio Fundador</p>
                            @endif
                            @endif
                            @elseif($rodada->estado == 'aberta')
                            Investimento Captado.
                            @endif
                            @elseif($investidor->status_investimento == 1)
                            Investimento Reembolsado.
                            @elseif($investidor->status_investimento == 2)
                            Investimento Não Reembolsado
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <h5 style="color:#818182;">Investidores na Rodada</h5>
    <div class="container-fluid">
        <div class="row">
            @forelse($investidores as $investidor)
            <div class="col-sm-6 col-12">
                <div class="card  h-100">
                    <div class="card-body row card-investor-rodada">
                        <div class="col-12 col-sm-8">
                            <p>
                                <span class="badge badge-primary">Investidor</span>&nbsp;<a href="{{route('startup.perfil',$investidor->investidor->user->code_user)}}">{{$investidor->investidor->nome_completo}}</a>
                            </p>
                            <p>
                                <span class="badge badge-primary">Aportado</span>&nbsp;<span>{{number_format($investidor->valor_investido,2,',','.')}} AOA</span>
                            </p>
                            <p>
                                <span class="badge badge-primary">Porcentagem</span>&nbsp;<span> {{$investidor->acoes_adquirida}}%</span>
                            </p>
                        </div>
                        <div class="col-12 col-sm-4" style="text-align:center;">
                            <p><span class="badge badge-primary">Situação</span></p>
                            <div id="situation-container{{$investidor->fk_investidor}}" class="situation-container">
                                @if($investidor->status_investimento == 0)
                                @if ($rodada->estado == 'fechada' && $presentUser==$rodada->fk_startup)
                                @if($investidor->contrato_mutou == NULL)
                                <p> Contracto de Investimento Pendente.</p>
                                <input type="file" class="field-contract-2" linker="{{$investidor->fk_investidor}}" accept=".pdf" name="contrato_investimento" id="load-contrato-investimento{{$investidor->fk_investidor}}" hidden>
                                <label type="button" class="btn btn-primary" for="load-contrato-investimento{{$investidor->fk_investidor}}" style="font-size:14px;border-radius:20px;margin-top:5px;">Adicionar Contrato</label>
                                @else
                                <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                    <img src="{{asset('assets/img/contract.png')}}" class="w-100 h-100" />
                                </div>
                                <!--<a href="{{route('view_doc',[$rodada->id, $investidor->fk_investidor])}}" rule="button" class="btn btn-primary" style="font-size:12px;margin-top:5px;">Visualizar Contrato</a>-->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdfModal" data-doc="{{$investidor->contrato_mutou}}">
                                    Visualizar PDF
                                </button>
                                @include('modais/pdf_visualizer_m')
                                @include('modais/sign_m')
                                @if($investidor->status_contrato_investidor != 4)
                                <button class="btn btn-primary btn-eliminar-contrato" linker="{{$investidor->fk_investidor}}" style="font-size:12px;margin-top:5px;">Eliminar Contrato</button>
                                @endif

                                @if($investidor->status_contrato_investidor == 3)
                                <p>Investidor Discorda Com os Termos do Contrato.</p>
                                <button class="btn btn-primary" style="font-size:12px;margin-top:5px;">Abrir Meeting</button><br>

                                @elseif($investidor->status_contrato_investidor == 1)
                                <p>Assinatura do Investidor em Falta.</p>
                                @elseif($investidor->status_contrato_investidor == 4)
                                <p>Assinado Pelo Investidor</p>
                                @endif

                                @if($investidor->status_contrato_startup == 1)
                                <p>Assinatura do Sócio Fundador em Falta</p>
                                <button class="btn btn-primary" style="font-size:12px;margin-top:5px;">Assinar Contrato</button>
                                @elseif($investidor->status_contrato_startup == 4)
                                <p>Assinado Pelo Sócio Fundador</p>
                                @endif

                                @endif
                                @elseif($rodada->estado == 'aberta')
                                Investimento Captado.
                                @endif
                                @elseif($investidor->status_investimento == 1)
                                Investimento Reembolsado.
                                @elseif($investidor->status_investimento == 2)
                                Investimento Não Reembolsado
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class=" col-12 d-flex align-items-center justify-content-center" style="min-height:200px;">
                <h2 style="font-size:25px;">Nenhum @if($investidor !=NULL )outro @endif Investidor Participou da Rodada.</h2>
            </div>
            @endforelse
        </div>
    </div>

</section>
@endsection



@section('scripts_base_inicio')
<script src="{{asset('assets/js/pdfJS_2_16_105.min.js')}}"></script>
<script src="{{asset('assets/js/signature_pad.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/pagina_da_rodada.js')}}"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('assets/js/pdfJS_2_16_105.worker.min.js') }}";

    var canvas = null;
    var signaturePad = null;
    var urlDoc = null;
    var pdfDoc = null,
        pdfContainer = document.getElementById('pdf-container'),
        pageNumDisplay = document.getElementById('page_num'),
        pageCountDisplay = document.getElementById('page_count'),
        scale = (document.getElementById('body-section').clientWidth) / 800,
        scale = scale < 1 ? scale : 1.3,
        canvasList = [];

    $('#pdfModal').on('shown.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        urlDoc =  "{{ asset('storage/') }}/" + button.data('doc');
        $("#path_doc").val(button.data('doc'));
        
        pdfjsLib.getDocument(urlDoc).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            pageCountDisplay.textContent = pdfDoc.numPages;
            renderAllPages();
        });
    });

    $('#pdfModal').on('scroll', onScroll);

    $(window).on('resize', function() {
        scale = calculateScale();
        renderAllPages();
    });

    //-----------------------MODAL_SIGN
    $("#signModal").on('shown.bs.modal', function() {
        canvas = document.getElementById('signature-pad');
        signaturePad = new SignaturePad(canvas);
        resizeCanvas();
    });

    $("#clear-signature").click(function(){
        signaturePad.clear();
    });

    $("#signModal").on('hidden.bs.modal',function(){
        $('body').addClass('modal-open');
    });

    $("#add-sign").click(function(){
        if (!signaturePad.isEmpty()) {
            console.log("add sign");
            $("#signature").val(signaturePad.toDataURL());
            submitSign();
        }
    });
    //-----------------------END_MODAL_SIGN

    function renderPage(num) {
        pdfDoc.getPage(num).then(function(page) {
            var viewport = page.getViewport({
                scale: scale
            });
            var canvas = document.createElement('canvas');
            canvas.className = 'pdf-page';
            var ctx = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext).promise.then(function() {
                pdfContainer.appendChild(canvas);
                canvasList.push(canvas);
            });
        });
    }

    function getVisiblePageNumber() {
        let currentPage = 1;
        canvasList.forEach((canvas, index) => {
            const rect = canvas.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                currentPage = index + 1;
            }
        });
        return currentPage;
    }

    function onScroll() {
        const currentPage = getVisiblePageNumber();
        pageNumDisplay.textContent = currentPage;
    }

    function renderAllPages() {
        pdfContainer.innerHTML = '';
        canvasList = [];
        for (var i = 1; i <= pdfDoc.numPages; i++) {
            renderPage(i);
        }
    }

    function calculateScale() {
        var containerWidth = pdfContainer.clientWidth;
        var scaleFactor = containerWidth / 800;
        return scaleFactor < 1 ? scaleFactor : 1.3;
    }
    //-----------------------MODAL_SIGN
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1,1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        signaturePad.clear(); // Limpa a assinatura após redimensionar
    }

    function submitSign(){
        console.log("submiting");
        var formPointSigned = new FormData($("#point-to-insert-sign")[0]);
        $.ajax({
            url: '/add-signature',
            type: 'post',
            contentType:false,
            processData:false,
            data: formPointSigned,
            success:function(response){
                console.log("sucesso");
                console.log(response);
            },
            error:function(error){
                console.log("Erro");
                console.log(error);
            }
        });
    }
    //-----------------------END_MODAL_SIGN
</script>
@endsection