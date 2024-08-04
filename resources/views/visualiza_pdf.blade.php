<!DOCTYPE html>
<html>
<head>
  <title>startupInveste</title>
  <script src="{{asset('assets/js/pdfobject.min.js')}}"></script>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js"></script>-->
</head>
<body>
  <div id="pdf-container" style="height: 600px;"></div>
  <script>
    PDFObject.embed("{{asset($url_pdf)}}", "#pdf-container");
  </script>
</body>
</html>
