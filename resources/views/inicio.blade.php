@extends('inicio_base')

@section('contentBody_base_inicio')

<div class="container-fluid py-4 px-4 px-lg-5">

    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="fase-desenvolvimento-filter" class="form-label">Fase Desenvolvimento</label>
                    <select id="fase-desenvolvimento-filter" class="form-control selectpicker" title="Todos" multiple data-selected-text-format="count>1" data-count-selected-text="+{0} Filtros" data-size="5" multiple>
                        @foreach($fases as $fase)
                            <option value="{{ $fase->id }}">{{ $fase->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="sector-economico-filter" class="form-label">Sector Económico</label>
                    <select id="sector-economico-filter" class="form-control selectpicker" data-live-search="true" title="Todos" multiple data-selected-text-format="count>2" data-count-selected-text="+{0} Filtros" data-size="5" multiple>
                        @foreach($setores as $setor)
                            <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group" id="input-busca-startup">
                        <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
                        <input class="form-control" id="nome-startup-filter" type="search" placeholder="Buscar Startup">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4" id="startup_cards_container" style="min-height:500px;">
        <div class="d-flex justify-content-center" style="width:100%;padding-top:70px;">
            <div class="spinner-border align-self-center" style="width: 5rem; height: 5rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

</div>

@endsection
@section('scripts_base_inicio')
<script src="{{ asset('assets/js/script2.js') }}"></script>
@endsection