@extends('inicio_base')

@section('stylesheets_base_inicio')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/rodadas_captacao.css')}}" />
@endsection

@section('contentBody_base_inicio')
<section id="body-section" class="container-fluid" style="padding-left:6.5%;padding-right:6.5%; padding-bottom:50px;">

    <h2 class="mb-4" id="title-page">Rodadas Captação</h2>

    <div class="mb-4" id="estatistica">
        <div class="d-flex justify-content-center " style="width:100%;height:100%;">
            <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
   <div class="row" id="container-filtro" style="display:none;">
        <div class="col-12 col-sm-3 offset-sm-9">
            <label for="filtro-estado-rodada"><i class="fa fa-filter" aria-hidden="true"></i> Filtro Estados</label>
            <select id="filtro-estado-rodada" class="form-control selectpicker" title="Todos" multiple data-selected-text-format="count>2" data-count-selected-text="+{0} Filtros" multiple>
                <option value="sucedida">Sucedidas</option>
                <option value="fechada">Fechadas</option>
                <option value="aberta">Abertas</option>
                <option value="anulada">Canceladas</option>
            </select>
        </div>
    </div>
    <div id="container-lista-rodadas" style="padding-top:30px;">
        <div class="d-flex justify-content-center " style="width:100%;height:100%;">
            <div class="spinner-border align-self-center" style="width: 7rem; height: 7rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div> 

</section>
@endsection



@section('scripts_base_inicio')
<script src="{{asset('assets/js/rodadas_captacao.js')}}">
</script>
@endsection