<!DOCTYPE html>
<html>

<head>
    <title>startupInveste</title>
    <script src="{{asset('assets/js/pdfobject.min.js')}}"></script>
    <script src="{{asset('assets/js/signature_pad.min.js')}}"></script>
    <style>
        #pdf-canvas {
            border: 1px solid black;
            cursor: pointer;
        }

        #signature-pad {
            border: 1px solid black;
            width: 100%;
            height: 200px;
        }
    </style>
</head>

<body>
    <div id="pdf-container" style="height: 600px;position:relative;"></div>
    <div>
        <canvas id="signature-pad"></canvas>
        <button id="clear-signature">Clear</button>
    </div>
    <form action="{{ route('pdf.add-signature') }}" method="post">
        @csrf
        <input type="hidden" name="path" value="{{ $url_pdf }}">
        <input type="hidden" name="x" id="x">
        <input type="hidden" name="y" id="y">
        <input type="hidden" name="signature" id="signature">
        <button type="submit">Add Signature</button>
    </form>
    <script>
        PDFObject.embed("{{asset($url_pdf)}}", "#pdf-container");


        document.getElementById('pdf-container').addEventListener('click', function(event) {
            const viewer = document.getElementById('pdf-container');
            const rect = viewer.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            document.getElementById('x').value = x;
            document.getElementById('y').value = y;
            
        });

        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            signaturePad.clear(); // Limpa a assinatura após redimensionar
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        document.getElementById('clear-signature').addEventListener('click', function() {
            signaturePad.clear();
        });

        document.querySelector('form').addEventListener('submit', function() {
            if (!signaturePad.isEmpty()) {
                document.getElementById('signature').value = signaturePad.toDataURL();
            }
        });
    </script>
</body>

</html>