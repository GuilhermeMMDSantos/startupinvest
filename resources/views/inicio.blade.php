 @extends('inicio_base')
 @section('stylesheets_base_inicio')
 <link rel="stylesheet" type="text/css" href="{{asset('assets/css/inicio.css')}}" />
 @endsection

 @section('contentBody_base_inicio')

 <section style="padding-left:6.5%;padding-right:6.5%;" class="container-fluid">
     <div class="row">
         <div class="col-sm-12">

             <div class="card">
                 <div class="card-body">
                     <div class="row">
                         <div class="col-sm-8">
                             <div class="form-row" style="font-size:13px;">
                                 <div class="form-group col-md-4">
                                     <label for="inputState">Fase Desenvolvimento</label>
                                     <select id="inputState" class="form-control">
                                         @foreach($fases as $fase)
                                         <option value="{{$fase->id}}">{{$fase->nome}}</option>
                                         @endforeach
                                     </select>
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label for="inputState">Sector Economico</label>
                                     <select id="inputState" class="form-control">
                                         @foreach($setores as $setor)
                                         <option value="{{$setor->id}}">{{$setor->nome}}</option>
                                         @endforeach
                                     </select>
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label for="inputState">Tipo de Negocio</label>
                                     <select id="inputState" class="form-control">
                                         @foreach($tiposBusness as $tb)
                                         <option value="{{$tb->id}}">{{$tb->nome}}</option>
                                         @endforeach
                                     </select>
                                 </div>

                             </div>
                         </div>
                         <div class="col-sm-4" style="padding-top:25px;">
                             <form>

                                 <div id="input-busca-startup" style="border:1px solid #ccc; border-radius:3px;padding:5px 9px;display:flex;background: #f8f9fa;">
                                 <i class="fa fa-search" style="display:inline-block;margin-top:5px;"></i>
                                 <input style="border:none;width:93%;margin-left:6px; outline:none;background:transparent;" type="search" placeholder="Buscar Startup"/>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>

             <div  class="container-fluid" style="padding-bottom:10px;">
                 <div class="row" id="startup_cards_container">


                 </div>
             </div>

         </div>
     </div>
 </section>


 </div>

 @endsection
 @section('scripts_base_inicio')
 <script src="assets/js/script2.js"></script>
 @endsection