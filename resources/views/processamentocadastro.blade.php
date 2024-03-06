@extends('../layout')
@section('stylesheets')
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }

    #header {
        background-color: var(--secundary);
    }

    #logo {
        color: var(--primary);
        font-size: 27px;
        margin-top: 5px;
    }

    #logo a {
        color: inherit;
        display: inherit;
        text-decoration: none;
    }

    #header .container-fluid {
        padding: 2px 80px;
    }
    #body{
        text-align:center;
    }
</style>
@endsection
@section('contentBody')
<div id="header" class="w-100">
    <div class="container-fluid">
        <h1 id="logo"><a href="{{route('new_home_page')}}">startup<strong style="color:white !important;">Investe</strong></a></h1>

    </div>
</div>

<section class="container-fluid" id="body">

    <h1>Obrigado!</h1>
    <h1>O seus dados serão validados em menos de 24 horas.</h1>

    <a href="{{route('new_home_page')}}" title="inicio">Aguardando</a>

</section>


</div>
@endsection