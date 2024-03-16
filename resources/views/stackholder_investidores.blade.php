 @extends('inicio_base')
 @section('stylesheets_base_inicio')
 <link rel="stylesheet" type="text/css" href="{{asset('assets/css/stackholder_investidores.css')}}" />
 @endsection

 @section('contentBody_base_inicio')

 <section style="padding-left:6.5%;padding-right:6.5%;" class="container-fluid">
     <div class="row">
         @foreach($investidores as $investidor)
         <div class="col-sm-6 col-md-4" style="padding-left:10px !important;padding-right:10px !important;padding-top:15px;">

             <a href="{{route('startup.perfil',$investidor->user->code_user)}}" style="display:block;width:100%;height:100%;text-decoration:none;color:#333;" class="link-card">

                 <div class="h-100 card" style="padding-top:20px;padding-bottom:20px;">
                     <div style="height:100px;width:100px;border-radius:100%;border:1px solid #ccc;margin:auto;">
                         <img src="{{asset('storage/'.$investidor->foto)}}" class="card-img-top" style="height:100%;width:100%;border-radius:100%;object-fit:contain !important;">
                     </div>
                     <h5 style="text-align:center;">{{$investidor->nome_completo}}</h5>
                     <span style="display:block;margin-top:-10px;color:#545b62b0;font-size:15px;text-align:center;" >Investidor<i style="font-size:20px;margin-right:4px;margin-left:4px;">•</i>Pessoa Física</span>
                     <h5 style="text-align:center;font-size:17px;">Startups investidas pela plataforma: <span style="color:green;">{{count($investidor->rodadas)}}</span></h5>

                 </div>

             </a>

         </div>
         @endforeach
     </div>
 </section>


 </div>

 @endsection
 @section('scripts_base_inicio')

 @endsection