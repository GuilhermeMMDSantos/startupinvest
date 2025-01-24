<?php

namespace App\Http\Controllers;

use App\Mensagens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Events\SendMessage;
use App\Notifications;
use App\Notifications\Message;
use App\PermissoesVerPitch;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $presentUser = Auth::user()->id;
        $notifications = Notifications::where('fk_user_distination', $presentUser)
            ->where('status', 'nao_visto')
            ->get();
        $userIdPostRequest = $request->id_other;
        $qtdnotifications = (int)count($notifications);

        $code = Auth::user()->id;

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        return view('message', compact('qtdnotifications', 'qtdMessageUnview', 'code', 'userIdPostRequest'));
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
                    select count(id) from mensagens where (fk_remetente  = tb.id and fk_destinatario = ?) and (vista = ?)
                 ) as unview,

                 (select fk_remetente from mensagens where (fk_remetente  = tb.id and fk_destinatario = ?) or (fk_remetente  = ? and fk_destinatario = tb.id) order by created_at desc limit 1
                 ) as remetente
      
                 
                from 
                (
                select fk_destinatario as id from mensagens where fk_remetente = ?
                union
                select fk_remetente as id from mensagens where fk_destinatario = ?
                ) as tb  order by date_ desc', [$presentUser, $presentUser, $presentUser, $presentUser, $presentUser, 'nao', $presentUser, $presentUser, $presentUser, $presentUser]);


        $html =  view('blocos_html/meetings', compact('dados'))->render();

        return response()->json(
            [
                'html' => $html,
                'count' => count($dados)
            ]
        );
    }

    public function loadMessageMeeting(Request $request)
    {
        $otherUserId  = $request->idUser;
        $otherUser = User::where('id', $otherUserId)->first();
        $currentUser = Auth::user();
        $presentUserId = $currentUser->id;
        $permissionToSendMessage = false;


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

        if ($currentUser->tipo == 'investidor') {
            $permission = PermissoesVerPitch::where('fk_startup', $otherUser->id)
                ->where('fk_investidor', $currentUser->id)
                ->whereIn('estado', ['ativo', 'livre'])
                ->first();
            if ($permission != null || $otherUser->tipo == 'investidor')
                $permissionToSendMessage = true;
        } else if ($otherUser->tipo == 'investidor') {
            $permission = PermissoesVerPitch::where('fk_startup', $currentUser->id)
                ->where('fk_investidor', $otherUser->id)
                ->whereIn('estado', ['ativo', 'livre'])
                ->first();
            if ($permission != null || $currentUser->tipo == 'investidor')
                $permissionToSendMessage = true;
        }

        $html = view('blocos_html/meeting', compact('mensagens', 'otherUser', 'permissionToSendMessage'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function sendMessage(Request $request)
    {


        $mensagem = $request->mensagem;
        $destinatario = $request->codeUser;
        $remetente = Auth::user()->id;

        $userDestinatario = User::where('id', $destinatario)->first();

        $mensagemEnviada = Mensagens::create([
            'fk_remetente' => $remetente,
            'fk_destinatario' => $destinatario,
            'conteudo' => $mensagem
        ]);


        $messages = Mensagens::where([

            ['fk_destinatario', $destinatario],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        $userDestinatario->notify(new Message($qtdMessageUnview));

        event(new SendMessage($destinatario, $mensagemEnviada->id));

        return response()->json([
            'messageId' => $mensagemEnviada->id
        ]);
    }

    public function setMessageStatus(Request $request)
    {
        $otherUser = $request->idOtherUser;
        $presentUser = Auth::user()->id;
        $userDestinatario = User::where('id', $presentUser)->first();

        Mensagens::where([
            ['fk_remetente', $otherUser],
            ['fk_destinatario', $presentUser]
        ])
            ->update([
                'vista' => 'sim'
            ]);

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        $userDestinatario->notify(new Message($qtdMessageUnview));

        return response()->json([
            'status' => 200
        ]);
    }

    public function showMeetingEmpty()
    {

        $html = view('blocos_html.meeting_empty')->render();

        return response()->json([
            'html' => $html
        ]);
    }
}
