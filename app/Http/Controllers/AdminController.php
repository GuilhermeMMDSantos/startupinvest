<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Investidores;
use App\Mail\EmailSenha;
use App\Startups;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function index()
    {
        if (Auth::check()) {

            $startups = Startups::with('incubadorAceleradora')
                ->whereHas('user', function (Builder $query) {
                    $query->where('estado', 'espera'); // 0 - ainda não avaliado, 1- aceite, 2-regeitado
                })
                ->orderBy('fk_user', 'desc')
                ->get();
             

            $investidores = Investidores::whereHas('user', function (Builder $query) {
                $query->where('estado', 'espera'); // 0 - ainda não avaliado, 1- aceite, 2-regeitado
            })
                ->orderBy('fk_user', 'desc')
                ->get();



            return view('Admin/painel', compact('startups', 'investidores'));
        }

        return Redirect::to("new_home_page")->with('error', 'Faça Login');
    }


    public function atualizarEstadoUser(Request $request)
    {

        if (!request()->ajax()) {
            Session::flush();
            Auth::logout();
            return Redirect("new_home_page");
        }

        $id_user = $request->id;



        $user = User::find($id_user);

        if ($request->action_ == 'Aceitar') {
            $user->estado = 'aceite';
        } else if ($request->action_ == 'Regeitar') {
            $user->estado = 'regeitado';
        }

        $user->save();

        // Mail::to('guiframart1@gmail.com')->send(new EmailSenha());
    }
}
