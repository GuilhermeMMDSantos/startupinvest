<style type="text/css">
    .link-card:hover {
        transform: scale(1.02);
        transition: all 0.7s;
        border: 1px solid rgb(119, 129, 123);
        border-radius: 5px;
    }

    .link-card {
        transition: all 0.7s;
    }
</style>

@forelse($startupsCards as $startupCard)
<div class="col-sm-6 col-md-4" style="padding-left:10px !important;padding-right:10px !important;padding-top:15px;">
    <a href="{{route('startup.perfil',$startupCard->user->code_user)}}" style="display:block;width:100%;height:100%;text-decoration:none;color:#333;" class="link-card">
        <div class="h-100 card">
            <div style="height:230px;">
                <img src="{{asset('storage/'.$startupCard->logotipo)}}" class="card-img-top" style="height:100%;width:100%;object-fit:cover !important;">
            </div>
            <div class="card-body">
                <h5 class="card-title">{{$startupCard->nome}}</h5>

                <p style="font-size:11px;">
                    <span style="background:#ccc;display:inline-block;padding:2px;border-radius:5px;">{{$startupCard->fase->nome}}</span>
                    <span style="background:#ccc;display:inline-block;padding:2px;border-radius:5px;">{{$startupCard->setor->nome}}</span>
                    </p>
                <p class="card-text">
                    {{ str_replace('##',' ',$startupCard->pitch_elevator) }}
                </p>

            </div>
            @if($startupCard->rodadaAtual != null)
            <div class="card-footer" style="border-top:none;background-color:white;">
                <hr style="margin-bottom:0.5rem;">
                <span style="font-size:12px;color:#adb5bdd6;">Conseguido</span>
                @php
                $porcentagem =($startupCard->rodadaAtual->valor_obtido*100)/$startupCard->rodadaAtual->valor_objetivo;

                @endphp
                <p style="font-size:14px;">{{$porcentagem}}% - {{$startupCard->rodadaAtual->tempo_restante}} Dias Restantes</p>

                <div class="progress" style="margin-top:-13px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width:{{$porcentagem}}%"></div>
                </div>

                <div class="row" style="margin-top:5px;">
                    <div class="col-4">
                        <span style="font-size:13px;color:#adb5bdd6;">Objectivo</span>
                        <p>{{number_format($startupCard->rodadaAtual->valor_objetivo,2,',','.')}} AOA</p>
                    </div>
                    <div class="col-4" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                        <span style="font-size:13px;color:#adb5bdd6;">
                            Atingido
                        </span>
                        <p>{{number_format($startupCard->rodadaAtual->valor_obtido,2,',','.')}} AOA</p>
                    </div>
                    <div class="col-4">
                        <span style="font-size:13px;color:#adb5bdd6;">Investidores</span>
                        <p>{{count($startupCard->rodadaAtual->investidores)}}</p>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </a>
</div>

@empty
<div  class="d-flex justify-content-center align-items-center col-12">
    <h4 style="font-size: 25px; 
    color: #545b62;">Nenhuma Startup Buscando Financiamento</h4>
</div>
@endforelse