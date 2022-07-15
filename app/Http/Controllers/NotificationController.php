<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use Illuminate\Support\Facades\Auth;

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
            ->get();

        return view('notificacao', compact('notificacoes', 'qtdnotifications'));
    }
}
