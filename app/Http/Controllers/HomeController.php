<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use App\Setores;
use App\Fases;
use App\IncubadorasAceleradoras;
use App\Investidores;
use App\Startups;
use App\Notifications;
use App\Mensagens;

class HomeController extends Controller
{
    public function index()
    {

        $setores = Setores::orderBy('nome', 'ASC')
            ->get();
        $fases = Fases::get();

        return view('home', compact('setores', 'fases'));
    }

    public function loadHomePag()
    {

        if (Auth::check()) {

           

            $presentUser = Auth::user()->id;

            $fases =  DB::table('fases_desenvolvimento')
                ->select('id', 'nome')
                ->get();

            $setores = DB::table('setores_economico')
                ->select('id', 'nome')
                ->get();

            

            $notifications = Notifications::where('fk_user_distination', $presentUser)
                ->where('status', 'nao_visto')
                ->get();

            $messages = Mensagens::where([

                ['fk_destinatario', $presentUser],
                ['vista', 'nao']
            ])
                ->get();

            $qtdMessageUnview = (int) count($messages);

            $qtdnotifications = (int)count($notifications);


            return view('inicio', compact('setores', 'fases', 'qtdnotifications','qtdMessageUnview'));
        }

        return Redirect::to("new_home_page")->with('error', 'Faça Login');
    }

 

    public function loadInvestidoresPage()
    {

        if (!Auth::check()) {
            return Redirect::to("new_home_page")->with('error', 'Faça Login');
        }

        $presentUser = Auth::user()->id;

        $investidores = Investidores::with(['user', 'rodadas' => function ($query) {
            $query->where('estado', 'fechada')
                ->get();
        }])
            ->where('fk_user', '!=', $presentUser)
            ->get();

        $notifications = Notifications::where('fk_user_distination', $presentUser)
            ->where('status', 'nao_visto')
            ->get();

        $qtdnotifications = (int)count($notifications);

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        return view('stackholder_investidores', compact('investidores', 'qtdnotifications','qtdMessageUnview'));
    }

    public function loadWaitValidationPag()
    {
        return view('processamentocadastro');
    }

    public function showNewHome()
    {
        return view('new_home');
    }

    public function showNewCadastroPage()
    {
        $setores = Setores::orderBy('nome', 'ASC')
            ->get();
        $fases = Fases::get();

        return view('new_cadastro_page', compact('setores', 'fases'));
    }

    public function showNewLoginPage()
    {
        return view('new_login_page');
    }
}
