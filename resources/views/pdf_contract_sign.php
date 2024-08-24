@extends('inicio_base')

@section('stylesheets_base_inicio')

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        height: 100vh;
        overflow-y: scroll;
        font-family: Arial, Helvetica, sans-serif;
    }

    .pdf-page {
        border: 1px solid black;
        display: block;
        margin-bottom: 20px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    #pdf-container {
        padding-top: 90px;
    }

    #header_visualize {
        background: #ccc;
        height: 30px;
        width: 100%;
        position: fixed;
        top: 59px;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        /* z-index: 10;*/
    }
</style>
@endsection

@section('contentBody_base_inicio')

            <div id="header_visualize">
                Page: <span id="page_num">0</span> / <span id="page_count">0</span>
            </div>
            <div id="pdf-container" style="border:1px solid red;"></div>
       
@endsection

@section('scripts_base_inicio')
<script src="{{asset('assets/js/pdfJS_2_16_105.min.js')}}"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = "{{asset('assets/js/pdfJS_2_16_105.worker.min.js')}}";

    var pdfDoc = null,
        pdfContainer = document.getElementById('pdf-container'),
        pageNumDisplay = document.getElementById('page_num'),
        pageCountDisplay = document.getElementById('page_count'),
        scale = calculateScale(),
        canvasList = [];

    pdfjsLib.getDocument('https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/web/compressed.tracemonkey-pldi-09.pdf').promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        pageCountDisplay.textContent = pdfDoc.numPages;
        renderAllPages();
    });


    window.addEventListener('scroll', onScroll);

    window.addEventListener('resize', function() {
        scale = calculateScale();
        renderAllPages();
    });

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
</script>
@endsection