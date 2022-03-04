<style type="text/css">
    .link-card:hover {
        transform: scale(1.02);
        transition: all 0.7s;
    }
    .link-card{
        transition: all 0.7s;
    }
</style>

@forelse($startupsCards as $startupCard)
<div class="col-sm-4" style="padding-left:10px !important;padding-right:10px !important;padding-top:15px;">
    <a href="#" style="display:block;width:100%;height:100%;text-decoration:none;color:#333;" class="link-card">
        <div class="h-100 card">

            <img src="{{asset('assets/img/3081627.jpg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$startupCard->nome}}</h5>

                <p style="font-size:11px;">
                    <span style="background:#ccc;display:inline-block;padding:2px;border-radius:5px;">{{$startupCard->fase->nome}}</span>
                    <span style="background:#ccc;display:inline-block;padding:2px;border-radius:5px;">{{$startupCard->setor->nome}}</span>
                    <span style="background:#ccc;display:inline-block;padding:2px;border-radius:5px;">{{$startupCard->tipobusnessfunc->nome}}</span>
                </p>
                <p class="card-text">
                    {{$startupCard->pitch_elevator}}
                </p>

            </div>
            <div class="card-footer" style="border-top:none;background-color:white;">
                <hr style="margin-bottom:0.5rem;">
                <span style="font-size:12px;color:#adb5bdd6;">Conseguido</span>
                <p style="font-size:14px;">80% - 4 Restantes</p>

                <div class="progress" style="margin-top:-13px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="row" style="margin-top:5px;">
                    <div class="col-4">
                        <span style="font-size:13px;color:#adb5bdd6;">Objectivo</span>
                        <p>20.000Kz</p>
                    </div>
                    <div class="col-4" style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                        <span style="font-size:13px;color:#adb5bdd6;">
                            Atingido
                        </span>
                        <p>17.000Kz</p>
                    </div>
                    <div class="col-4">
                        <span style="font-size:13px;color:#adb5bdd6;">Investidores</span>
                        <p>4</p>
                    </div>
                </div>
            </div>

        </div>
    </a>
</div>

@empty
<div style="padding-left:20px;" class="col-12">
    <h4 style="font-size: 15px;
    color: #545b62;">Sem startups registradas</h4>
</div>
@endforelse