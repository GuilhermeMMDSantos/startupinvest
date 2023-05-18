<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mensagens;

class NotificationController extends Controller
{
    public function loadNotifications()
    {
        $qtdnotifications = 0;
        $presentUser = Auth::user()->id;

        Notifications::where('fk_user_distination', $presentUser)
            ->where('status', 'nao_visto')
            ->update([
                'status' => 'visto'
            ]);

        $notificacoes  = Notifications::where('fk_user_distination', $presentUser)
            ->select('*', DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y %h:%m") as data'))
            ->orderBy('created_at','DESC')
            ->get();

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        return view('notificacao', compact('notificacoes', 'qtdnotifications','qtdMessageUnview'));
    }

    public function showOwnerNotification($notificationId)
    {
        $notification = Notifications::where('id', $notificationId)
            ->first();

        $notification->update([
            'status' => 'clicado'
        ]);

        // return Redirect("startup.perfil",$notification->userdeorigem->code_user);
        return redirect()->route('startup.perfil', ['codeUser' => $notification->userdeorigem->code_user]);
    }
}
