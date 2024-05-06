<link rel="stylesheet" type="text/css" href="{{asset('assets/css/header_admin.css')}}" />
<header id="header" class="container-fluid " style="position:fixed;top:0;z-index:10;">
    <div class=" d-flex" >
        <div class="flex-grow-1" id="logo"  style="padding-top:14px;">
            <h1><a href="{{route('admin.stackholders')}}">startup<strong style="color:white !important;">Investe</strong>-Adm</a></h1>
        </div>

        <nav  class="no-mobile" id="menu" style="padding-top:7px;">
            <ul class="d-flex ">
                <li class="mr-4">
                    <a href="{{route('admin.stackholders')}}">
                        <i class="fa fa-bell"></i><span>stackolders</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('rodadas.page.admin')}}">
                        <i class="fa fa-envelope"></i><span>Rodadas</span>
                    </a>

                </li>
            </ul>
        </nav>

        <div  class="no-mobile ml-5" style="padding-top:14px;">
            <a id="btn_sair" href="{{url('userout')}}" style="color:#ffcb2f;text-decoration:underline;">Sair</a>
        </div>
    </div>
</header>
<br>
<br>
<br>