<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function loadNotifications()
    {
        $qtdnotifications = 0;


        Notifications::where('fk_user_distination', Auth::user()->id)
            ->where('status', 'nao_visto')
            ->update([
                'status' => 'visto'
            ]);
            
        $notificacoes  = Notifications::where('fk_user_distination', Auth::user()->id)
        ->select('*', DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y %h:%m") as data'))
            ->get();

        return view('notificacao', compact('notificacoes', 'qtdnotifications'));
    }

    public function showOwnerNotification($notificationId)
    {
        $notification = Notifications::where('id', $notificationId)
            ->first();

        $notification->update([
                'status' => 'clicado'
            ]);

           // return Redirect("startup.perfil",$notification->userdeorigem->code_user);
            return redirect()->route('startup.perfil',['codeUser' => $notification->userdeorigem->code_user]);
    }
}
