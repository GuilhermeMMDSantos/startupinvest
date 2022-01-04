<link rel="stylesheet" type="text/css" href="{{asset('assets/css/includes_header.css')}}" />
<header class=" container-fluid" id="header" style="position:fixed;top:0;z-index:10;">
    <div class="row" id="headMenu">

        <div class="col-sm-6 col-lg-6 logo" style="padding-top:12px;">
            <h1><a href="{{url('ecostartup')}}">ecoStartup</h1>
        </div>

        <nav class="col-lg-5 menu" style="padding-top:7px;padding-bottom:7px;">

            <ul>
                <li class="liMenu"><a href="#" class="anchorMenu"><i class="fa fa-bell"></i><span>Notificões</span></a></li>
                <li class="liMenu"><a href="#" class="anchorMenu"><i class="fa fa-envelope"></i><span>Mensagens</span></a></li>
                <li class="liMenu"><a href="#" class="anchorMenu"><i class="fa fa-users"></i><span>Stackholder</span></a></li>
            </ul>

        </nav>

        <div class="col-lg-1 more_perfil" style="padding-top:7px;padding-right:0px !important;">
            <div style="position:relative;right:-28px; width:50px;">
                <div id="myself" style="width:45px;height:45px;border-radius:25px;border:2px solid white;display:inline-block;cursor:pointer;">
                    <img src="{{asset('assets/img/img1.png')}}" id="myself_img" style="width:100%;height:100%;" />
                </div>

                <ul class="submenu">
                    <li><a href="{{route('user.perfil')}}">Perfil {{Auth::user()->tipo}}</a></li>
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

<script type="text/javascript">
  $(function(){
    

      $("#myself").click(function(){
          $(".submenu").toggle(100);
           
      });

      $(document).click(function(element){
      
      if($(element.target).attr('id') != 'myself_img'){
        $(".submenu").hide(100);
      }
    });
    
  });
</script>