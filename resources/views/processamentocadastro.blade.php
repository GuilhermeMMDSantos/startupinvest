@extends('../layout')
@section('stylesheets') 
<style type="text/css">
.page{
    margin:0px !important;
    padding:0px !important;
}
header{
    background-color: rgba(0, 0, 0, 0.9);
    min-height: 63px; 
    padding-top:13px;
    
}

header h1{ 
    font-size: 2em; 
}
header a{
    color:#dcaf25;
}

header a:hover{
    color:#dcaf25;
    text-decoration:none;
}

section{
    text-align:center;
    padding-top:20px;
}
</style>
@endsection
@section('contentBody')
<div class="container-fluid page">
    <header class="container-fluid">
        <h1><a href="{{url('home')}}">ecoStartup</a></h1>
    </header>

    <section class="container-fluid">

    <h1>Obrigado!</h1>
    <h1>O seus dados serão validados em menos de 24 horas.</h1>

    <a href="{{url('home')}}" title="inicio">Aguardando</a>

    </section>


</div>
@endsection


    