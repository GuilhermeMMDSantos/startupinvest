<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use App\Setores;
use App\Fases;
use App\Startups;

class HomeController extends Controller
{
    public function index()
    {
        
        $setores = Setores::orderBy('nome','ASC')
        ->get();
        $fases = Fases::get();

        return view('home',compact('setores','fases'));
    }

    public function loadHomePag()
    {

        if (Auth::check()) {

            // listar apartir das startups menos vistas  , as que o seus perfis foram visitados livam +2 os outros +1



            $fases =  DB::table('fases')
                ->select('id', 'nome')
                ->get();

            $setores = DB::table('setores')
                ->select('id', 'nome')
                ->get();

            $tiposBusness = DB::table('tipo_busnesses')
                ->select('id', 'nome')
                ->get();


            return view('inicio', compact('setores', 'tiposBusness', 'fases'));
        }

        return Redirect::to("home")->with('error', 'Faça Login');
    }

    public function loadWaitValidationPag()
    {
        return view('processamentocadastro');
    }
}
