@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pagina_da_rodada.css') }}" />
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid"
    style="padding-left:6.5% !important;padding-right:6.5% !important; padding-bottom:50px;">



    <h2 class="mb-4" id="title-page" val="{{ $rodada->id }}">Rodada
        @if($rodada->estado == 'anulada')
        <span style="font-size:14px;" class="badge badge-danger ml-2"> {{ $rodada->estado }}</span>
        @elseif($rodada->estado == 'fechada' || $rodada->estado == 'sucedida')
        <span style="font-size:14px;" class="badge badge-success ml-2"> {{ $rodada->estado }}</span>
        @elseif($rodada->estado == 'aberta')
        <span style="font-size:14px;" class="badge badge-warning ml-2"> {{ $rodada->estado }}</span>
        @endif
    </h2>
    </br>

    <div class="card" style="margin-bottom:15px;" id="intro-rodada">

        <div class="card-body row">
            <div class="col-sm-3 col-12">
                <h5>Rodada</h5>
                <h6>{{ $rodada->id }}</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor objectivo</h5>
                <h6>{{ number_format($rodada->valor_objetivo, 2, ',', '.') }} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Valor Captado</h5>
                <h6>{{ number_format($rodada->valor_obtido, 2, ',', '.') }} AOA</h6>
            </div>

            <div class="col-sm-3 col-12">
                <h5>Participação Oferecida</h5>
                <h6>{{ $rodada->oferta_acoes }}%</h6>
            </div>

        </div>
    </div>
    @if ($investidor != null)
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-sm-6 col-12">
                        <p>
                            <span class="badge badge-primary">Startup</span>&nbsp;<a
                                href="{{ route('startup.perfil', $investidor->rodada->startup->user->code_user) }}"
                                style="font-size:20px;">{{ $investidor->rodada->startup->nome }}</a>

                        </p>
                        <p>
                            <span class="badge badge-primary">Aportado</span>&nbsp;<span style="font-size:20px;">
                                {{ number_format($investidor->valor_investido, 2, ',', '.') }} AOA</span>
                        </p>
                        <p>
                            <span class="badge badge-primary">Porcentagem</span>&nbsp;<span style="font-size:20px;">
                                {{ $investidor->acoes_adquirida }}%</span>
                        </p>
                    </div>
                    <div class="col-sm-6 col-12 ">
                        <p style="text-align:center;"><span class="badge badge-primary">Situação</span></p>
                        <div id="investor-invest-situation-container">
                            @if ($investidor->status_investimento == 0)
                            @if ($rodada->estado == 'fechada' && $presentUser == $investidor->investidor->fk_user)
                            @if ($investidor->contrato_mutou == null)
                            <p style="text-align:center;"> Contracto de Investimento Pendente.</p>
                            @else
                            <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                <img src="{{ asset('assets/img/contract.png') }}"
                                    class="w-100 h-100" />
                            </div>


                            @if ($investidor->status_contrato_investidor == 1)
                            <p style="text-align:center;">Assinatura do Investidor em Falta.</p>

                            @elseif($investidor->status_contrato_investidor == 2)
                            <p style="text-align:center;">Descordou Com os Termos do Contrato</p>

                            @elseif($investidor->status_contrato_investidor == 3)
                            <p style="text-align:center;">Assinado Pelo Investidor</p>
                            @endif
                            @if ($investidor->status_contrato_startup == 1)
                            <p style="text-align:center;">Assinatura do Sócio Fundador em Falta</p>
                            @elseif($investidor->status_contrato_startup == 2)
                            <p style="text-align:center;">Assinado Pelo Sócio Fundador</p>
                            @endif
                            @endif
                            @elseif($rodada->estado == 'aberta')
                            Captando...
                            @endif
                            @elseif($investidor->status_investimento == 1)
                            Investimento Reembolsado.
                            @elseif($investidor->status_investimento == 2)
                            Investimento Não Reembolsado
                            @endif



                        </div>
                    </div>
                </div>

                <div class="card-footer text-right bg-light">


                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#pdfModal" data-doc="{{ $investidor->contrato_mutou }}"
                        data-origin=1>
                        <i class="fas fa-file-contract"></i> Ler Contrato
                    </button>

                    @if ($investidor->status_contrato_investidor == 1)
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#pdfModal"
                        data-doc="{{ $investidor->contrato_mutou }}"
                        data-idinvestor="{{ $investidor->fk_investidor }}"
                        data-origin=2>
                        <i class="fas fa-pen"></i> Assinar Contrato
                    </button>
                    @elseif($investidor->status_contrato_investidor == 2)
                    <a rule="button" href="{{route('mensagens_post',['id_other' => $rodada->fk_startup])}}" class="btn btn-primary"><i class="fas fa-comments"></i> Iniciar Meeting</a>
                    @endif
                    @if ($investidor->status_contrato_investidor != 2 && $investidor->status_contrato_investidor != 3)
                    <button type="button" class="btn btn-outline-danger" id="btn-discordar-contrato"><i class="fas fa-ban"></i> Discordar Contrato</button>
                    @endif

                </div>

            </div>
        </div>
    </div>
    @endif
    <h5 style="color:#818182;">@if ($investidor != null) Outros @endif Investidores na Rodada</h5>

    <div class="row">
        @forelse($investidores as $investidor)
        <div class="col-sm-6 col-12">
            <div class="card  h-100">
                <div class="card-body row card-investor-rodada">
                    <div class="col-12 col-sm-8">
                        <p>
                            <span class="badge badge-primary">Investidor</span>&nbsp;<a
                                href="{{ route('startup.perfil', $investidor->investidor->user->code_user) }}">{{ $investidor->investidor->nome_completo }}</a>
                        </p>
                        <p>
                            <span
                                class="badge badge-primary">Aportado</span>&nbsp;<span>{{ number_format($investidor->valor_investido, 2, ',', '.') }}
                                AOA</span>
                        </p>
                        <p>
                            <span class="badge badge-primary">Porcentagem</span>&nbsp;<span>
                                {{ $investidor->acoes_adquirida }}%</span>
                        </p>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align:center;">
                        <p style="text-align:center;"><span class="badge badge-primary">Situação</span></p>
                        <div id="situation-container{{ $investidor->fk_investidor }}"
                            class="situation-container">
                            @if ($investidor->status_investimento == 0)
                            @if ($rodada->estado == 'fechada' && $presentUser == $rodada->fk_startup)
                            @if ($investidor->contrato_mutou == null)
                            <p style="text-align:center;"> Contracto de Investimento Pendente.</p>
                            <input type="file" class="field-contract-2"
                                linker="{{ $investidor->fk_investidor }}" accept=".pdf"
                                name="contrato_investimento"
                                id="load-contrato-investimento{{ $investidor->fk_investidor }}"
                                hidden>

                            @else
                            <div style="width:90px;height:90px;border:1px solid #ccc;margin:auto;">
                                <img src="{{ asset('assets/img/contract.png') }}"
                                    class="w-100 h-100" />
                            </div>


                            @if ($investidor->status_contrato_investidor == 2)
                            <p style="text-align:center;">Investidor Discorda Com os Termos do Contrato.</p>

                            @elseif($investidor->status_contrato_investidor == 1)
                            <p style="text-align:center;">Assinatura do Investidor em Falta.</p>
                            @elseif($investidor->status_contrato_investidor == 3)
                            <p style="text-align:center;">Assinado Pelo Investidor</p>
                            @endif

                            @if ($investidor->status_contrato_startup == 1)
                            <p style="text-align:center;">Assinatura do Sócio Fundador em Falta</p>

                            @elseif($investidor->status_contrato_startup == 2)
                            <p style="text-align:center;">Assinado Pelo Sócio Fundador</p>
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




                <div class="card-footer text-right bg-light situation-container">

                    @if ($investidor->status_investimento == 0)
                    @if ($rodada->estado == 'fechada' && $presentUser == $rodada->fk_startup)
                    @if ($investidor->contrato_mutou == null)
                    <label type="button" class="btn btn-outline-primary"
                        for="load-contrato-investimento{{ $investidor->fk_investidor }}"
                        ><i class="fas fa-file-contract"></i> Adicionar
                        Contrato</label>
                    @endif
                    @endif
                    @endif


                    @if ($investidor->contrato_mutou != null)
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#pdfModal"
                        data-doc="{{ $investidor->contrato_mutou }}" data-origin=1>
                        <i class="fas fa-file-contract"></i> Ler Contrato
                    </button>

                    @if ($investidor->status_contrato_investidor != 3)
                    <button class="btn btn btn-outline-danger btn-eliminar-contrato"
                        linker="{{ $investidor->fk_investidor }}"
                        ><i class="fas fa-ban"></i> Eliminar
                        Contrato</button>
                    @endif

                    @if ($investidor->status_contrato_investidor == 2)
                    <a rule="button" href="{{route('mensagens_post',['id_other' => $investidor->fk_investidor])}}" class="btn btn-primary"><i class="fas fa-comments"></i> Iniciar Meeting</a><br>
                    @endif

                    @if ($investidor->status_contrato_startup == 1)
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#pdfModal"
                        data-doc="{{ $investidor->contrato_mutou }}"
                        data-idinvestor="{{ $investidor->fk_investidor }}"
                        data-origin=2>
                        <i class="fas fa-pen"></i> Assinar Contrato
                    </button>
                    @endif
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class=" col-12 d-flex align-items-center justify-content-center" style="min-height:200px;">
            <h2 style="font-size:25px;">Nenhum @if ($investidor != null)
                outro
                @endif Investidor Participou da Rodada.
            </h2>
        </div>
        @endforelse
    </div>

    @include('modais/pdf_visualizer_m')
    @include('modais/sign_m')
</section>
@endsection



@section('scripts_base_inicio')
<script src="{{ asset('assets/js/pdfJS_2_16_105.min.js') }}"></script>
<script src="{{ asset('assets/js/signature_pad.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pagina_da_rodada.js') }}"></script>
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
    $(document).on("shown.bs.modal", "#pdfModal", function(event) {
        var button = $(event.relatedTarget);
        var origin = button.data('origin');
        $("#id-investor").val(button.data('idinvestor'));

        if (origin == 1)
            $("#options-visualizer").hide();
        else if (origin == 2)
            $("#options-visualizer").show();
        urlDoc = "{{ asset('storage/') }}/" + button.data('doc');
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

    $("#clear-signature").click(function() {
        signaturePad.clear();
    });

    $("#signModal").on('hidden.bs.modal', function() {
        $('body').addClass('modal-open');
    });

    $("#add-sign").click(function() {
        if (!signaturePad.isEmpty()) {
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
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        signaturePad.clear(); // Limpa a assinatura após redimensionar
    }

    function submitSign() {

        const loader = "<div class='d-flex justify-content-center' style='width:100%;height:100%;'>\
                                                    <div class='spinner-border align-self-center' style='width: 7rem; height: 7rem;' role='status'>\
                                                        <span class='sr-only'>Loading...</span>\
                                                    </div>\
                                                </div>";

        $("#pdf-container").empty();
        $("#pdf-container").append(loader);
        $("#signModal").modal('hide');
        var formPointSigned = new FormData($("#point-to-insert-sign")[0]);
        $.ajax({
            url: '/add-signature',
            type: 'post',
            contentType: false,
            processData: false,
            data: formPointSigned,
            success: function(response) {
                $("#pdf-container").empty();
                urlDoc = "{{ asset('storage/') }}/" + response['new_path_doc'];
                $("#path_doc").val(response['new_path_doc']);

                pdfjsLib.getDocument(urlDoc).promise.then(function(pdfDoc_) {
                    pdfDoc = pdfDoc_;
                    pageCountDisplay.textContent = pdfDoc.numPages;
                    renderAllPages();
                });

                Swal.fire({
                    icon: "success",
                    title: "Contrato Assinado",
                    showConfirmButton: false,
                    timer: 1500
                });

                $("#btn-feito").show();
            },
            error: function(error) {
                console.log("Erro");
                console.log(error);
            }
        });
    }
    //-----------------------END_MODAL_SIGN
</script>
@endsection