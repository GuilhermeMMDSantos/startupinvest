<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF.js Scroll Example</title>
    <style>
        * {
            margin: 0px !important;
            padding: 0px !important;
        }

        body {
            height: 100vh;
            overflow-y: scroll;
        }

        .pdf-page {
            border: 1px solid black;
            display: block;
            margin-bottom: 20px !important;
            margin-left:auto !important;
            margin-right:auto !important;
        }

        #pdf-container{
            padding-top:90px;
        }

        #header {
            background: #ccc;
            height: 50px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
    </style>
</head>

<body>
    <div id="header">
        Page: <span id="page_num">0</span> / <span id="page_count">0</span>
    </div>
    <div id="pdf-container" style="border:1px solid red;"></div>

     
    <script src="{{asset('assets/js/pdfJS_2_16_105.min.js')}}"></script>
    <script>
      
        pdfjsLib.GlobalWorkerOptions.workerSrc = "{{asset('assets/js/pdfJS_2_16_105.worker.min.js')}}";

        var pdfDoc = null,
            scale = 1.3,
            pdfContainer = document.getElementById('pdf-container'),
            pageNumDisplay = document.getElementById('page_num'),
            pageCountDisplay = document.getElementById('page_count'),
            canvasList = [];

      
        function renderPage(num) {
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport({ scale: scale });
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

      
        pdfjsLib.getDocument('https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/web/compressed.tracemonkey-pldi-09.pdf').promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            pageCountDisplay.textContent = pdfDoc.numPages;
            for (var i = 1; i <= pdfDoc.numPages; i++) {
                renderPage(i);
            }
        });

        window.addEventListener('scroll', onScroll);
    </script>
</body>

</html>
