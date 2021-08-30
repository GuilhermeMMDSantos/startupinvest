 @extends('inicio_base')
 @section('stylesheets_base_inicio')
 <link rel="stylesheet" type="text/css" href="{{asset('assets/css/inicio.css')}}" />
 @endsection

 @section('contentBody_base_inicio')

 <section class="container-fluid" style="padding-left:6.5%;padding-right:6.5%;  ">


     <div class="row ">

         <div class="col-sm-4" class="menuAsideFiltro">
             <div class="card" style="width: 20rem;">
                 <div class="card-body">
                     <h4 class="headFiltros">Fase de Desenvolvimento</h4>
                     <form>
                         <div class="form-check">
                             <input class="form-check-input filtroall" type="checkbox" id="faseFiltroall" value="0">
                             <label class="form-check-label" for="faseFiltroall">
                                 Todos
                             </label>
                         </div>
                         @foreach($fases as $fase)
                         <div class="form-check">
                             <input class="form-check-input faseFiltro _checkbox" type="checkbox" id="fasefiltro_{{$fase->id}}" value="{{$fase->id}}">
                             <label class="form-check-label" for="fasefiltro_{{$fase->id}}">
                                 {{$fase->nome}}
                             </label>
                         </div>
                         @endforeach
                     </form>

                     <hr>
                     <h4 class="headFiltros">Sector de atividade</h4>
                     <form>
                         <div class="form-check">
                             <input class="form-check-input filtroall" type="checkbox" id="setorFiltroall" value="0">
                             <label class="form-check-label" for="setorFiltroall">
                                 Todos
                             </label>
                         </div>
                         @foreach($setores as $setor)
                         <div class="form-check">
                             <input class="form-check-input setorFiltro _checkbox" type="checkbox" id="setorfiltro_{{$setor->id}}" value="{{$setor->id}}">
                             <label class="form-check-label" for="setorfiltro_{{$setor->id}}">
                                 {{$setor->nome}}
                             </label>
                         </div>
                         @endforeach
                     </form>

                     <hr>

                     <h4 class="headFiltros">Tipo de Negócio</h4>
                     <form>
                         <div class="form-check">
                             <input class="form-check-input filtroall" type="checkbox" id="tiponegocioFiltroall" value="0">
                             <label class="form-check-label" for="tiponegocioFiltroall">
                                 Todos
                             </label>
                         </div>
                         @foreach($tiposBusness as $tipoBusness)
                         <div class="form-check">
                             <input class="form-check-input tiponegocioFiltro _checkbox" type="checkbox" id="tiponegocio_{{$tipoBusness->id}}" value="{{$tipoBusness->id}}">
                             <label class="form-check-label" for="tiponegocio_{{$tipoBusness->id}}">
                                 {{$tipoBusness->nome}}
                             </label>
                         </div>
                         @endforeach
                     </form>

                 </div>
             </div>
         </div>

         <div class="col-sm-8"  >
             <div class="card">
                 <div class="card-body">
                     <form>
                         <div>
                             <input type="text" id="search_filtro" class="form-control" placeholder="Buscar Startup" style="border-radius:3px;">
                         </div>
                     </form>
                 </div>
             </div>
             <div id="startup_cards_container" style="margin-top:20px;min-height:20px;">

             </div>
         </div>
     </div>
 </section>


 </div>

 @endsection
 @section('scripts_base_inicio')
 <script src="assets/js/script2.js"></script>
 @endsection