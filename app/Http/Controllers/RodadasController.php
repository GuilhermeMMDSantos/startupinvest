<?php

namespace App\Http\Controllers;

use App\Investidores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications;
use Illuminate\Support\Facades\DB;
use App\Mensagens;
use App\RodadasInvestidores;
use App\RodadasInvestimento;

class RodadasController extends Controller
{
    public function showPage(Request $request)
    {
        $qtdnotifications = 0;
        $presentUser = Auth::user()->id;
        $investidor = null;

        Notifications::where('fk_user_distination', $presentUser)
            ->where('status', 'nao_visto')
            ->update([
                'status' => 'visto'
            ]);

        $notificacoes  = Notifications::where('fk_user_distination', $presentUser)
            ->select('*', DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y %h:%m") as data'))
            ->orderBy('created_at', 'DESC')
            ->get();

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        if (Auth::user()->tipo == 'investidor') {

            $investidor =  RodadasInvestidores::where('fk_rodada', $request->id_rodada)->where('fk_investidor',Auth::user()->id)->first();
            $investidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)->where('fk_investidor','!=',Auth::user()->id)->get();
        }else
            $investidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)->get();
        $rodada = RodadasInvestimento::where('id', $request->id_rodada)->first();
        return view('pagina_da_rodada', compact('notificacoes', 'qtdnotifications', 'qtdMessageUnview', 'investidores', 'rodada', 'investidor'))->render();
    }

    public function visualizarParaAssinarPdf(Request $request){
        $url_pdf = 'storage/armazenamento/contratos/'.$request->doc;
        return view('visualiza_pdf', compact('url_pdf'));
    }
}
