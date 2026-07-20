@extends('inicio_base')

@section('contentBody_base_inicio')
<div class="container-fluid py-4 px-4 px-lg-5">
    <h2 class="fw-bold mb-4">Rodadas Captação</h2>

    <div class="mb-4" id="estatistica">
        <div class="d-flex justify-content-center">
            <div class="spinner-border align-self-center" style="width: 5rem; height: 5rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="row" id="container-filtro" style="display:none;">
        <div class="col-12 col-sm-3 offset-sm-9">
            <label for="filtro-estado-rodada" class="form-label"><i class="fa fa-filter" aria-hidden="true"></i> Filtro Estados</label>
            <select id="filtro-estado-rodada" class="form-control selectpicker" title="Todos" multiple data-selected-text-format="count>2" data-count-selected-text="+{0} Filtros" multiple>
                <option value="sucedida">Sucedidas</option>
                <option value="fechada">Fechadas</option>
                <option value="aberta">Abertas</option>
                <option value="anulada">Canceladas</option>
            </select>
        </div>
    </div>

    <div id="container-lista-rodadas" class="pt-4">
        <div class="d-flex justify-content-center">
            <div class="spinner-border align-self-center" style="width: 5rem; height: 5rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts_base_inicio')
<script src="{{ asset('assets/js/rodadas_captacao.js') }}"></script>
@endsection
