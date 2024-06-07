<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}">
    <title>startupinveste</title>

    <!-- Fonts -->
    <!--<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">-->


    <!--Scripts-->
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('assets/js/alertify.min.js')}}"></script>


    <!-- Styles -->
    <link href="{{asset('assets/fontawesome/css/all.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap-select.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('assets/css/config.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" type="text/css" rel="stylesheet">

    <link href="{{asset('assets/css/alertify.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('assets/css/default.min.css')}}" type="text/css" rel="stylesheet">
    @yield('stylesheets')

</head>

<body>
    @yield('contentBody')
    @yield('scripts')
</body>


</html>