<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Startups;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StartupController extends Controller
{ //Além de fazerem o tratamento de uma solicitação, devem ser vistos como os DAO

    public function loadStartups()
    {
        if (!request()->ajax()) {
            Session::flush();
            Auth::logout();
            return Redirect("home");
        } // E se eu criar um middleware

        $startupsCards =  Startups::with(['setor', 'fase', 'tipobusnessfunc'])
            ->whereHas('user', function ($query) {
                $query->where('estado', 'aceite');
            })
            ->where('id_user', '!=', Auth::user()->id)
            ->get();

        $returnHtml = view('carregamentos.startup_cards', compact('startupsCards'))->render();
        return response()->json($returnHtml);
    }

    public function filtrarStartups(Request $request)
    {
        if (!request()->ajax()) {
            Session::flush();
            Auth::logout();
            return Redirect("home");
        }  // E se eu criar um middleware

        $fasesSelecionadas = $request->fases;
        $setoresSelecionados = $request->setores;
        $tiposNegocioSelecionados = $request->typeBusness;
        $value_search_filtro = $request->search;

        $startupsCards = Startups::with(['setor', 'fase', 'tipobusnessFunc'])
            ->whereHas('user', function ($query) {
                $query->where('estado', 'aceite');
            })
            ->whereIn('setor_atividade', $setoresSelecionados)
            ->whereIn('fase_desenvolvimento', $fasesSelecionadas)
            ->whereIn('tipobusness', $tiposNegocioSelecionados)
            ->when($value_search_filtro, function ($query, $value_search_filtro) {
                return $query->where('nome', 'like', '%' . $value_search_filtro . '%');
            })
            ->where('id_user', '!=', Auth::user()->id)
            ->get();

        $returnHtml = view('carregamentos.startup_cards', compact('startupsCards'))->render();
        return response()->json($returnHtml);
    }
}
