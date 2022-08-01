<?php

namespace App\Http\Controllers;

use App\Conversas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Mensagens;
use App\Notifications\Message;
use App\PermissoesVerPitch;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;

use function React\Promise\Stream\first;

class ChatController extends Controller
{
    public function getConversas()
    {
        $idStartup = Auth::user()->id;

        $conversas = Conversas::where('fk_startup', $idStartup)
            ->orderBy('updated_at')
            ->get();

        $html = view('blocos_html/lista_conversas', compact('conversas'))->render();

        return response()->json([
            'html' => $html
        ]);
    }


    public function sendMessage(Request $request)
    {
        $remetente = $request->remetente;
        $distinatario =  $request->distinatario;
        $conteudoMessage = $request->conteudoMessage;
        $fk_investidor = '';
        $fk_startup = '';

        $user = User::where('id', $distinatario)
            ->first();

        if ($user->tipo == 'investidor') {
            $fk_investidor = $distinatario;
            $fk_startup = $remetente;
        } else {
            $fk_investidor =  $remetente;
            $fk_startup = $distinatario;
        }

        $conversa = Conversas::where([
            ['fk_startup', $fk_startup],
            ['fk_investidor', $fk_investidor]
        ])
            ->first();

        if (empty($conversa)) {
            $conversa = Conversas::create([
                'fk_startup' => $fk_startup,
                'fk_investidor' => $fk_investidor
            ]);
        }

        $mensagem = Mensagens::create([
            'conteudo' => $conteudoMessage,
            'fk_conversa' => $conversa->id,
            'fk_remetente' => $remetente,
            'fk_destinatario' => $distinatario
        ]);

        $user->notify(new \App\Notifications\Message($conteudoMessage));
    }

    public function getMessages(Request $request)
    {

        $remetente = $request->remetente;
        $distinatario =  $request->distinatario;
        $fk_investidor = '';
        $fk_startup = '';

        $user = User::where('id', $distinatario)
            ->first();

        if ($user->tipo == 'investidor') {
            $fk_investidor = $distinatario;
            $fk_startup = $remetente;
        } else {
            $fk_investidor =  $remetente;
            $fk_startup = $distinatario;
        }


        $mensagens = Mensagens::select(
            '*',
            DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y %h:%m") AS dataenvio')
        )
            ->whereHas('conversa', function ($query) use ($fk_startup, $fk_investidor) {
                $query->where([
                    ['fk_startup', $fk_startup],
                    ['fk_investidor', $fk_investidor]
                ]);
            })
            ->get();


        $html = view('blocos_html/lista_mensagens', compact('mensagens'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function getInfoDestinatario(Request $request)
    {
        $destinatario = $request->distinatario;
        $nome = "";

        $user = User::with(['startup', 'investidor'])
            ->where('id', $destinatario)
            ->first();

        if (!empty($user->startup))
            $nome = $user->startup->nome;
        else if (!empty($user->investidor)) {
            $nome = $user->investidor->nome;
            if ($user->investidor->sobrenome != null)
                $nome = $nome . ' ' . $user->investidor->sobrenome;
        }

        $html = view('blocos_html/info_destinatario', compact('nome'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function verificarPermissaoParaEnviarMensagem(Request $request)
    {
        $remetente = $request->remetente;
        $destinatario = $request->destinatario;
        $havePermissao = false;

        $fk_investidor = '';
        $fk_startup = '';


        $user = User::where('id', $destinatario)
            ->first();

        if ($user->tipo == 'investidor') {
            $fk_investidor = $destinatario;
            $fk_startup = $remetente;
        } else {
            $fk_investidor =  $remetente;
            $fk_startup = $destinatario;
        }

        $permissao = PermissoesVerPitch::where([
            ['fk_startup', $fk_startup],
            ['fk_investidor', $fk_investidor]
        ])
            ->first();

        if (!empty($permissao) && $permissao->estado == 'ativo')
            $havePermissao = true;


        return response()->json([
            'permissao' => (bool)$havePermissao
        ]);
    }
}
