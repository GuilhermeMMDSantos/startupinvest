 
 <link rel="stylesheet" type="text/css" href="{{asset('assets/css/includes_footerMobile.css')}}">
 
 <footer id="rodapeMenu" style=" height:50px;width:100%;position:fixed;bottom:0;z-index:10;background-color:#ccc;">
     <ul>
         <li class="rodapeMenu"><a href="{{route('menu_mobile')}}" class="anchorMenu"><i class="fa fa-users"></i></a></li><!--menu-->
         <li class="rodapeMenu"><a href="{{route('mensagens.menu')}}" class="anchorMenu"><i class="fa fa-envelope"></i></a></li><!--mensagem-->
         <li class="rodapeMenu"><a href="{{route('notificacao.menu')}}" class="anchorMenu"><i class="fa fa-bell"></i></a></li><!--notificacao-->
     </ul>
 </footer>