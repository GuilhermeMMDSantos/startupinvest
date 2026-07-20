<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    <title>startupInveste</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2_11.js') }}"></script>

    <link href="{{ asset('assets/fontawesome/css/all.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-select.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/css/config.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('stylesheets')

</head>

<body>
    <noscript>
        <meta http-equiv="refresh" content="0; url={{ route('javascript.disabled') }}">
    </noscript>

    <div class="app-shell">
        @yield('contentBody')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')
</body>


</html>
