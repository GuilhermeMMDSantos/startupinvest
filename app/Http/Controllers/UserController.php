<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Startups;
use App\Investidores;
use App\User;

class UserController extends Controller
{
    public function showPerfil()
    {
        if (!Auth::check()) {
            return Redirect("home");
        }
         

        $isMine = true;
        $tipoUser = Auth::user()->tipo;

        if ($tipoUser == 'startup') {
            $startup = Startups::where('id_user', Auth::user()->id)->first();

            return view('perfil_startup', compact('startup', 'isMine', 'tipoUser'));
        } else if ($tipoUser == 'investidor') {
            $investidor = Investidores::where('id_user', Auth::user()->id)->first();
            return view('perfil_investidor', compact('potencialInvestidor', 'isMine', 'tipoUser'));
        }
    }

    public function showPerfilOther($item)
    {
        if (!Auth::check()) {
            return Redirect("home");
        }

        $isMine = false;
        $tipoUser = User::where('id',$item)
        ->first()
        ->tipo;

        if ($tipoUser == 'startup') {
            $startup = Startups::where('id_user', $item)->first();

            return view('perfil_startup', compact('startup', 'isMine', 'tipoUser'));
        } else if ($tipoUser == 'investidor') {
            $investidor = Investidores::where('id_user', $item)->first();
            return view('perfil_investidor', compact('investidor', 'isMine', 'tipoUser'));
        }
    }
}
