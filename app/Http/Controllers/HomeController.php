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

            // listar apartir das startups menos vistas  , as que o seus perfis foram visitados livam +2 os outros +1



            $fases =  DB::table('fases_desenvolvimento')
                ->select('id', 'nome')
                ->get();

            $setores = DB::table('setores_economico')
                ->select('id', 'nome')
                ->get();

            $tiposBusness = DB::table('tipos_negocio')
                ->select('id', 'nome')
                ->get();

            $notifications = Notifications::where('fk_user_distination', Auth::user()->id)
                ->where('status', 'nao_visto')
                ->get();

            $qtdnotifications = (int)count($notifications);


            return view('inicio', compact('setores', 'tiposBusness', 'fases', 'qtdnotifications'));
        }

        return Redirect::to("new_home_page")->with('error', 'Faça Login');
    }

    public function buscarIncubadoraAceleradora(Request $request)
    {

        $palavras = $request->valorNome;

        $incubadorasAceleradoras = IncubadorasAceleradoras::where('nome', 'like', $palavras . '%')
            ->get();

        $returnHtml = view('blocos_html/lista_resultado_busca_incubadora_aceleradora', compact('incubadorasAceleradoras'))->render();

        return response()->json($returnHtml);
    }

    public function loadInvestidoresPage()
    {

        if (!Auth::check()) {
            return Redirect::to("new_home_page")->with('error', 'Faça Login');
        }

        $investidores = Investidores::with(['user', 'rodadas' => function ($query) {
            $query->where('estado', 'fechada')
                ->get();
        }])
            ->where('fk_user', '!=', Auth::user()->id)
            ->get();

        $notifications = Notifications::where('fk_user_distination', Auth::user()->id)
            ->where('status', 'nao_visto')
            ->get();

        $qtdnotifications = (int)count($notifications);

        return view('stackholder_investidores', compact('investidores','qtdnotifications'));
    }

    public function loadWaitValidationPag()
    {
        return view('processamentocadastro');
    }

    public function showNewHome(){
        return view('new_home');
    }

    public function showNewCadastroPage(){
        $setores = Setores::orderBy('nome', 'ASC')
            ->get();
        $fases = Fases::get();

        return view('new_cadastro_page', compact('setores', 'fases'));
    }

    public function showNewLoginPage(){
        return view('new_login_page');
    }
}
