<link rel="stylesheet" type="text/css" href="{{asset('assets/css/includes_header.css')}}" />
<header class=" container-fluid" id="header" style="position:fixed;top:0;z-index:10;">
    <div class="row" id="headMenu">

        <div class="col-sm-5 col-lg-5 logo" style="padding-top:12px;">
            <h1><a href="{{url('stackholder_startup')}}">ecoStartup</h1>
        </div>

        <nav class="col-lg-6 menu" style="padding-top:7px;padding-bottom:7px;">

            <ul>

                <li class="liMenu" style="position: relative !important;">
                    <a href="{{route('notificacao.menu')}}" class="anchorMenu">
                        <i class="fa fa-bell"></i><span>Notificões</span>
                    </a>
                    <span id="indicador-existe-notificacao" class="badge badge-light" style="position: absolute !important ;top:0px;left:33px;min-width:13px;border-radius:50%;padding:1px !important;border:1px solid black;font-size:10px;text-align:center;background-color:#ffcb2f;@if($qtdnotifications==0)display:none;@endif">@if($qtdnotifications>0) {{$qtdnotifications}} @endif</span>
                </li>




                @if(Auth::user()->tipo == 'investidor')
                <li class="liMenu"><a href="{{route('investidor.menu')}}" class="anchorMenu"><i class="fa fa-envelope"></i><span>Investidores</span></a></li>
                @endif
                <li class="liMenu"><a href="{{route('startup.menu')}}" class="anchorMenu"><i class="fa fa-users"></i><span>Startups</span></a></li>

            </ul>

        </nav>

        <div class="col-lg-1 more_perfil" style="padding-top:7px;padding-right:0px !important;">
            <div style="position:relative;right:-28px; width:50px;">
                @php
                $img = Auth::user()->tipo == 'startup' ? Auth::user()->startup->logotipo : Auth::user()->investidor->foto;
                $code = Auth::user()->id;
                @endphp
                <div id="myself" style="width:45px;height:45px;border-radius:25px;border:2px solid white;display:inline-block;cursor:pointer;">
                    <img src="{{asset('storage/'.$img)}}" id="myself_img" style="width:100%;height:100%;border-radius:25px;object-fit:cover !important;" />
                </div>

                <ul class="submenu">
                    <li><a href="{{route('startup.perfil',Auth::user()->code_user)}}">Perfil {{Auth::user()->tipo}}</a></li>
                    <li><a href="#">Configurações e privacidade</a></li>
                    <li><a href="{{url('userout')}}">Sair</a></li>
                </ul>
            </div>

        </div>

    </div>
</header>
<br>
<br>
<br>
<script src="{{asset('js/app.js')}}"></script>
<script type="text/javascript">
    $(function() {


        $("#myself").click(function() {
            $(".submenu").toggle(100);

        });

        $(document).click(function(element) {

            if ($(element.target).attr('id') != 'myself_img') {
                $(".submenu").hide(100);
            }
        });

    });
</script>