<?php

namespace App\Http\Controllers;

use App\Mensagens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Events\SendMessage;


class MessageController extends Controller
{
    public function index()
    {
        $qtdnotifications = 0;
        $code = Auth::user()->id;
        return view('message', compact('qtdnotifications','code'));
    }


    public function loadMeetings()
    {

        $presentUser = Auth::user()->id;

        $dados = DB::select('select id,(
                select conteudo from mensagens where (fk_remetente  = tb.id and fk_destinatario = ?) or (fk_remetente  = ? and fk_destinatario = tb.id) order by created_at desc limit 1
                 ) as conteudo,

                 (select created_at from mensagens where (fk_remetente  = tb.id and fk_destinatario = ?) or (fk_remetente  = ? and fk_destinatario = tb.id) order by created_at desc limit 1
                 ) as date_,

                 (
                    select count(id) from mensagens where (fk_remetente  = tb.id and fk_destinatario = ?) or (fk_remetente  = ? and fk_destinatario = tb.id )
                 ) as unview
      
                 
                from 
                (
                select fk_destinatario as id  from mensagens where fk_remetente = ?
                union
                select fk_remetente as id from mensagens where fk_destinatario = ?
                ) as tb  order by date_ desc',[$presentUser, $presentUser, $presentUser, $presentUser, $presentUser, $presentUser, $presentUser, $presentUser]);


        $html =  view('blocos_html/meetings', compact('dados'))->render();

        $user = new \app\User;

        return response()->json(
            [
                'html' => $html
            ]
        );
    }

    public function loadMessageMeeting(Request $request)
    {
        $otherUserId  = $request->idUser;
        $otherUser = User::where('id', $otherUserId)->first();
        $presentUserId = Auth::user()->id;



        $mensagens = Mensagens::where([

            ['fk_remetente', $presentUserId],
            ['fk_destinatario', $otherUserId]
        ])

            ->orWhere(function ($query) use ($presentUserId, $otherUserId) {
                $query->where([
                    ['fk_remetente', $otherUserId],
                    ['fk_destinatario', $presentUserId]
                ]);
            })
            ->get();

        $html = view('blocos_html/meeting', compact('mensagens', 'otherUser'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function sendMessage(Request $request)
    {

        
        $mensagem = $request->mensagem;
        $destinatario= $request->codeUser;


        $remetente = Auth::user()->id; 

        $mensagemEnviada = Mensagens::create([
            'fk_remetente' => $remetente,
            'fk_destinatario' => $destinatario,
            'conteudo' => $mensagem
        ]);




        event(new SendMessage($destinatario, $mensagemEnviada->id));

        return response()->json([
            'messageId' => $mensagemEnviada->id
        ]);
    }
}
