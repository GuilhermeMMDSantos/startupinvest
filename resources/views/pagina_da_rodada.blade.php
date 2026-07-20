@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pagina_da_rodada.css') }}" />
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid py-4 px-4 px-lg-5">

    <h2 class="fw-bold mb-4" id="title-page" val="{{ $rodada->id }}">Rodada
        @if ($rodada->estado == 'anulada')
        <span class="badge badge-danger ms-2">{{ $rodada->estado }}</span>
        @elseif($rodada->estado == 'fechada' || $rodada->estado == 'sucedida')
        <span class="badge badge-success ms-2">{{ $rodada->estado }}</span>
        @elseif($rodada->estado == 'aberta')
        <span class="badge badge-warning ms-2">{{ $rodada->estado }}</span>
        @endif
    </h2>

    <div class="card mb-4" id="intro-rodada">
        <div class="card-body row g-3">
            <div class="col-sm-3 col-6">
                <h5 class="text-muted small mb-1">Rodada</h5>
                <h6 class="fw-semibold">{{ $rodada->id }}</h6>
            </div>

            <div class="col-sm-3 col-6">
                <h5 class="text-muted small mb-1">Valor objectivo</h5>
                <h6 class="fw-semibold">{{ number_format($rodada->valor_objetivo, 2, ',', '.') }} AOA</h6>
            </div>

            <div class="col-sm-3 col-6">
                <h5 class="text-muted small mb-1">Valor Captado</h5>
                <h6 class="fw-semibold">{{ number_format($rodada->valor_obtido, 2, ',', '.') }} AOA</h6>
            </div>

            <div class="col-sm-3 col-6">
                <h5 class="text-muted small mb-1">Participação Oferecida</h5>
                <h6 class="fw-semibold">{{ $rodada->oferta_acoes }}%</h6>
            </div>
        </div>
    </div>

    @if($rodada->estado == 'sucedida' && $rodada->comprovativo != NULL)
    <div class="card mb-4" id="container-btn-send-amount">
        <div class="card-body text-center">
            <h6 class="badge badge-primary p-2 mb-2">Confirmação Da Tranferência Do Montante Para Startup</h6>
            <div>
                <a href="{{ asset('storage/'.$rodada->comprovativo) }}" target="_blank"><i class="fas fa-file-contract"></i> Comprovativo de Transferência</a>
            </div>
        </div>
    </div>
    @endif

    @if ($investidor != null)
    <div class="row mb-3" id="container-investor-into-the-round">
        <div class="d-flex justify-content-center" style="width:100%;height:400px;">
            <div class="spinner-border align-self-center" style="width: 5rem; height: 5rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    @endif

    <h5 class="text-muted">
        @if ($investidor != null)
        Outros
        @endif Investidores na Rodada
    </h5>

    <div class="row" id="container-investor-na-rodada">
        <div class="d-flex justify-content-center" style="width:100%;height:400px;">
            <div class="spinner-border align-self-center" style="width: 5rem; height: 5rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
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
    loadInvestorsIntoTheRound();
    loadInvestorIntoTheRound();
    pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('assets/js/pdfJS_2_16_105.worker.min.js') }}";

    var canvas = null;
    var signaturePad = null;
    var urlDoc = null;
    var pdfDoc = null,
        pdfContainer = document.getElementById('pdf-container'),
        scale = (document.getElementById('body-section').clientWidth) / 800,
        originalScale = scale,
        scale = scale < 1 ? scale : 1.2,
        canvasList = [];
    $("#render-scale").val(scale);
    $(document).on("shown.bs.modal", "#pdfModal", function(event) {
        var button = $(event.relatedTarget);
        var origin = button.data('origin');
        $("#btn-feito").hide();
        $("#id-investor").val(button.data('idinvestor'));

        if (origin == 1)
            $("#options-visualizer").hide();
        else if (origin == 2)
            $("#options-visualizer").show();
        urlDoc = "{{ asset('storage/') }}/" + button.data('doc');
        $("#path_doc").val(button.data('doc'));

        pdfjsLib.getDocument(urlDoc).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
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
    //------------------------OUVINTES
    Echo.private('discordar-contrato-channel.' + '{{ $presentUser }}')
        .listen('DiscordarContrato', function(e) {

            loadInvestorsIntoTheRound();

        });

    Echo.private('assinar-contrato-startup-channel.' + '{{ $presentUser }}')
        .listen('AssinarContratoStartup', function(e) {
            loadInvestorIntoTheRound();
        });

    Echo.private('assinar-contrato-investor-channel.' + '{{ $presentUser }}')
        .listen('AssinarContratoInvestor', function(e) {

            loadInvestorsIntoTheRound();
        });

    Echo.private('adicionar-contrato-channel.' + '{{ $presentUser }}')
        .listen('AdicionarContrato', function(e) {
            loadInvestorIntoTheRound();

        });

    Echo.private('adicionar-comprovativo-assinatura-channel.' + '{{ $presentUser }}')
        .listen('AdicionarComprovativoAssinatura', function(e) {
            loadInvestorIntoTheRound();

        });
    //-----------------------END_MODAL_SIGN

    function loadInvestorsIntoTheRound() {
        var rodada = @json($rodada);
        $.ajax({
            url: '/load_investors_into_the_round',
            type: 'get',
            data: {
                'rodada': rodada
            },
            success: function(response) {
                $("#container-investor-na-rodada").empty();
                $("#container-investor-na-rodada").append(response['html']);
            },
            error: function(error) {
                console.log("Erro ao carregar investidores");
                console.log(error);
            }
        });
    }

    function loadInvestorIntoTheRound() {
        var rodada = @json($rodada);
        $.ajax({
            url: '/load_investor_into_the_round',
            type: 'get',
            data: {
                'rodada': rodada
            },
            success: function(response) {
                $("#container-investor-into-the-round").empty();
                $("#container-investor-into-the-round").append(response['html']);
            },
            error: function(error) {
                console.log("Erro ao carregar investidor");
                console.log(error);
            }
        });
    }

    function renderPage(num) {
        if (num > pdfDoc.numPages)
            return false;

        pdfDoc.getPage(num).then(function(page) {
            var viewport = page.getViewport({
                scale: scale
            });
            var canvas = document.createElement('canvas');
            canvas.className = 'pdf-page';
            canvas.setAttribute('data-page-number', num);
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
                renderPage(num + 1);
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
    }

    function renderAllPages() {
        pdfContainer.innerHTML = '';
        canvasList = [];
        renderPage(1);
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