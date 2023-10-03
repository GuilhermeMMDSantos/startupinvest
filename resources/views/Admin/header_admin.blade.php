<link rel="stylesheet" type="text/css" href="{{asset('assets/css/header_admin.css')}}" />
<header id="header" class="container-fluid " style="position:fixed;top:0;z-index:10;">
    <div class=" d-flex justify-content-between" >
        <div class="" id="logo"  style="padding-top:14px">
            <h1><a href="{{route('admin.stackholders')}}">startup<strong style="color:white !important;">Investe</strong>-Adm</a></h1>
        </div>

        <nav   id="menu" style="padding-top:7px">
            <ul class="d-flex ">
                <li>
                    <a href="{{route('admin.stackholders')}}">
                        <i class="fa fa-bell"></i><span>stackolders</span>
                    </a>
                </li>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <li>
                    <a href="{{route('admin.pagamento.page')}}">
                        <i class="fa fa-envelope"></i><span>Pagamentos</span>
                    </a>

                </li>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <li>
                    <a href="#">
                        <i class="fa fa-envelope"></i><span>Comprovativos</span>
                    </a>

                </li>
            </ul>
        </nav>

        <div class=" "  style="padding-top:14px">
            <a id="btn_sair" href="{{url('userout')}}" style="color:#ffcb2f;text-decoration:underline;">Sair</a>
        </div>
    </div>
</header>
<br>
<br>
<br>