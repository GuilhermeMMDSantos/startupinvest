<style type="text/css">
    .startup_card {
        margin-bottom: 10px;
        display: none;
        transition: transform 0.5s;

    }

    .linkCard,
    .linkCard:hover {
        text-decoration: none;
        color: black;
    }

    .startup_card:hover {
        transform: scale(1.03);
        transition: all 0.5s;
    }

    .content_startup_card_img {
        padding-left: 3.2%;
        padding-right: 3.2%;
        padding-top: 2%; 
    }

    .startup_card_img {
        width: 80px;
        height: 80px;
       /* border-radius: 50%;*/
        border: 2px solid #e6ecf1;
    }

    .startup_card_img img {
        width: 100%;
        height: 100%;

    }

    .startup_card_info {
        padding-top: 2%;
        padding-bottom: 2%;
        padding-right: 3%;
        padding-left: 0px;
        font-size: 13px;

    }

    .startup_card_info span {
        margin-right: 10px;
        background-color: #e6ecf1;
        border-radius: 2px;
        padding: 4px 8px;
    }
</style>

@forelse($startupsCards as $startupCard)
<div class="card startup_card container-fluid">
    <a class="linkCard" href="{{route('user_perfil',$startupCard->id_user)}}" style="display:block; width:100%;height:100%;">
        <div class="row">
            <div class="col-sm col-md-2 content_startup_card_img">
                <div class="startup_card_img">
                    <img src="{{asset('assets/img/img1.png')}}" />
                </div>
            </div>
            <div class="col-sm col-md-10 startup_card_info">
                <h4 style="font-size:16px;font-weight:bold;">{{$startupCard->nome}}</h4>
                <p>
                    <span>{{$startupCard->fase->nome}}</span>
                    <span>{{$startupCard->setor->nome}}</span>
                    <span>{{$startupCard->tipobusnessfunc->nome}}</span>
                </p>
                <p>{{strtoupper($startupCard->pitch_elevator)}}</p>
            </div>
        </div>
    </a>
</div>
@empty
<div style="padding-left:20px;">
    <h4 style="font-size: 15px;
    color: #545b62;">Sem startups registradas</h4>
</div>
@endforelse